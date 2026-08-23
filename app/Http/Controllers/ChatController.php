<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ChatController extends Controller
{
    private const HISTORY_LIMIT = 8;

    public function send(Request $request)
    {

        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'history' => ['nullable', 'array', 'max:' . self::HISTORY_LIMIT],
            'history.*.role'    => ['required_with:history', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:1000'],
        ]);


        $apiKey = config('services.openai.key');
        if (empty($apiKey)) {
            return response()->json([
                'reply' => 'El asistente inteligente no está disponible en este momento. '
                    . 'Escríbenos a ' . config('site.contact.email')
                    . ' o llama gratis al ' . config('site.contact.phone') . '.',
                'fallback' => true,
            ]);
        }

        try {
            $response = Http::withToken($apiKey)
                ->timeout(30) 

                ->post('https://api.openai.com/v1/chat/completions', [
                    'model'       => config('services.openai.model', 'gpt-4o-mini'),
                    'temperature' => 0.4,           

                    'max_tokens'  => 350,           

                    'messages'    => $this->buildMessages($data['message'], $data['history'] ?? []),
                ]);
        } catch (\Throwable $e) {
            report($e); 


            return response()->json([
                'reply'    => 'Tengo problemas de conexión en este momento. Inténtalo de nuevo en unos minutos.',
                'fallback' => true,
            ]);
        }


        if ($response->failed()) {
            logger()->warning('OpenAI respondió error', ['status' => $response->status()]);

            return response()->json([
                'reply'    => 'No pude procesar tu consulta ahora mismo. También puedes llamar a la línea gratuita ' . config('site.contact.phone') . '.',
                'fallback' => true,
            ]);
        }


        $reply = $response->json('choices.0.message.content');

        return response()->json([
            'reply' => trim($reply ?? 'Lo siento, no tengo respuesta para eso ahora mismo.'),
        ]);
    }

    private function buildMessages(string $userMessage, array $history): array
    {
        $contact  = config('site.contact');
        $programs = collect(config('site.programs'))
            ->map(fn ($p) => "- {$p['name']} ({$p['level']}, {$p['duration']}, modalidad {$p['modality']})")
            ->implode("\n");
        $faqs = collect(config('site.faqs'))
            ->map(fn ($f) => "P: {$f['q']}\nR: {$f['a']}")
            ->implode("\n\n");

        $systemPrompt = <<<PROMPT
Eres "SenaBot", asistente virtual oficial del sitio web de ADMISENA (Servicio Nacional de Aprendizaje — SENA, Colombia).

REGLAS:
- Responde SIEMPRE en español, con tono institucional, claro y cordial.
- Sé breve: máximo 4 oraciones por respuesta.
- Usa SOLO la información institucional provista aquí. Si no sabes algo,
  indica amablemente que contacte la línea gratuita {$contact['phone']}
  o el correo {$contact['email']}. NUNCA inventes datos.

INFORMACIÓN INSTITUCIONAL:
Dirección: {$contact['address']}
Horario: {$contact['schedule']}
Teléfono gratuito: {$contact['phone']}

PROGRAMAS DE TECNOLOGÍA OFERTADOS:
{$programs}

PREGUNTAS FRECUENTES VERIFICADAS:
{$faqs}
PROMPT;


        $messages = [['role' => 'system', 'content' => $systemPrompt]];

        foreach (array_slice($history, -self::HISTORY_LIMIT) as $turn) {
            $messages[] = [
                'role'    => $turn['role'],
                'content' => $turn['content'],
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        return $messages;
    }
}
