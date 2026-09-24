<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
use App\Models\Area;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PublicApiController extends Controller
{
    public function config(): JsonResponse
    {
        return response()->json([
            'app'       => config('site.app'),
            'contact'   => config('site.contact'),
            'locations' => config('site.locations'),
        ]);
    }

    public function programs(): JsonResponse
    {
        $activeCourses = Course::with(['area', 'trainingCenter'])
            ->whereDate('deadline', '>=', Carbon::today())
            ->get();

        $locations = collect(config('site.locations'))->map(function ($location) use ($activeCourses) {
            return [
                ...$location,
                'programs' => $activeCourses
                    ->where('trainingCenter.name', $location['name'])
                    ->values()
                    ->map(fn ($course) => [
                    'id'               => $course->id,
                    'course_number'    => $course->course_number,
                    'name'             => $course->name,
                    'day'              => $course->day,
                    'deadline'         => $course->deadline?->toDateString(),
                    'image'            => $course->image ? asset('storage/images/' . $course->image) : null,
                    'area'             => $course->area?->name,
                    'training_center'  => $course->trainingCenter?->name,
                ]),
            ];
        })->reject(fn ($section) => collect($section['programs'])->isEmpty())->values();

        $areas = Area::orderBy('name')->get(['id', 'name']);

        return response()->json([
            'locations' => $locations,
            'areas'     => $areas,
        ]);
    }

    public function news(): JsonResponse
    {
        $news = collect(config('site.news'))->sortByDesc('date')->values();

        return response()->json(['news' => $news]);
    }

    public function newsDetail(string $slug): JsonResponse
    {
        $article = collect(config('site.news'))->firstWhere('slug', $slug);

        if (! $article) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        $related = collect(config('site.news'))
            ->reject(fn ($item) => $item['slug'] === $slug)
            ->sortByDesc('date')
            ->take(2)
            ->values();

        return response()->json([
            'article' => $article,
            'related' => $related,
        ]);
    }

    public function events(): JsonResponse
    {
        $events = collect(config('site.events'))->sortBy('date')->values();

        return response()->json(['events' => $events]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $this->normalize($request->input('q', ''));
        $results = ['programs' => [], 'news' => [], 'events' => []];

        if ($query !== '') {
            foreach (config('site.programs') as $program) {
                if ($this->matches($query, [$program['name'], $program['summary'], ...$program['tags']])) {
                    $results['programs'][] = $program;
                }
            }
            foreach (config('site.news') as $article) {
                if ($this->matches($query, [$article['title'], $article['excerpt'], $article['category'], ...$article['body']])) {
                    $results['news'][] = $article;
                }
            }
            foreach (config('site.events') as $event) {
                if ($this->matches($query, [$event['title'], $event['detail'], $event['type'], $event['place']])) {
                    $results['events'][] = $event;
                }
            }
        }

        return response()->json([
            'query' => $request->input('q', ''),
            'results' => $results,
            'total' => count($results['programs']) + count($results['news']) + count($results['events']),
        ]);
    }

    public function contact(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'min:20', 'max:2000'],
        ]);

        logger()->info('Mensaje de contacto recibido', $validated);

        return response()->json(['success' => true, 'message' => 'Tu mensaje fue enviado correctamente. Te responderemos al correo indicado.']);
    }

    public function register(Request $request): JsonResponse
    {
        $course = Course::with('trainingCenter')
            ->whereKey($request->integer('course_id'))
            ->whereDate('deadline', '>=', Carbon::today())
            ->first();

        if (! $course) {
            return response()->json(['message' => 'La inscripción para este programa ya no está disponible.'], 422);
        }

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'surname'  => ['required', 'string', 'max:120'],
            'document' => ['required', 'string', 'max:20'],
            'address'  => ['required', 'string', 'max:255'],
            'estrato'  => ['required', 'integer', 'between:1,6'],
            'email'    => ['required', 'email', 'max:150'],
        ]);

        $already = Apprentice::where('document', $validated['document'])
            ->where('course_id', $course->id)
            ->exists();

        if ($already) {
            return response()->json(['message' => 'Ya existe una inscripción con este documento para este programa.'], 422);
        }

        Apprentice::create([
            'name'      => $validated['name'],
            'surname'   => $validated['surname'],
            'document'  => $validated['document'],
            'address'   => $validated['address'],
            'estrato'   => $validated['estrato'],
            'email'     => $validated['email'],
            'course_id' => $course->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Tu inscripción a «{$course->name}» fue recibida. Confirmaremos tu cupo al correo registrado.",
        ]);
    }

    private function normalize(string $value): string
    {
        $value = mb_strtolower(trim($value));
        $map   = ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n'];
        return strtr($value, $map);
    }

    private function matches(string $query, array $fields): bool
    {
        foreach ($fields as $field) {
            if (str_contains($this->normalize((string) $field), $query)) {
                return true;
            }
        }
        return false;
    }
}
