<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PublicController extends Controller
{
    public function home()
    {
        return view('public.home', [
            'programs'      => config('site.programs'),
            'latestNews'    => collect(config('site.news'))->sortByDesc('date')->take(3)->values(),
            'upcomingEvent' => collect(config('site.events'))->sortBy('date')->first(),
        ]);
    }

    public function about()
    {
        return view('public.about', [
            'programCount' => count(config('site.programs')),
        ]);
    }

    public function programs()
    {
        return view('public.programs', [
            'programs' => config('site.programs'),
        ]);
    }

    public function news()
    {
        return view('public.news', [
            'news' => collect(config('site.news'))->sortByDesc('date')->values(),
        ]);
    }

    public function newsDetail(string $slug)
    {

        $article = collect(config('site.news'))->firstWhere('slug', $slug);

        abort_if($article === null, 404);


        $related = collect(config('site.news'))
            ->reject(fn ($item) => $item['slug'] === $slug)
            ->sortByDesc('date')
            ->take(2)
            ->values();

        return view('public.news-detail', [
            'article' => $article,
            'related' => $related,
        ]);
    }

    public function events()
    {
        return view('public.events', [
            'events' => collect(config('site.events'))->sortBy('date')->values(),
        ]);
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function submitContact(Request $request)
    {

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'min:20', 'max:2000'],
        ], [
            'message.min' => 'El mensaje debe tener al menos :min caracteres.',
        ]);


        logger()->info('Mensaje de contacto recibido', $validated);

        return redirect()
            ->route('contact')
            ->with('success', 'Tu mensaje fue enviado correctamente. Te responderemos al correo indicado.');
    }

    public function search(Request $request)
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

        return view('public.search', [
            'query'       => $request->input('q', ''),
            'results'     => $results,
            'total'       => count($results['programs']) + count($results['news']) + count($results['events']),
        ]);
    }

    public function adminPanel()
    {
        return redirect()->route('courses.index');
    }


    private function normalize(string $value): string
    {
        $value = mb_strtolower(trim($value));


        $map = ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ü'=>'u','ñ'=>'n'];

        return strtr($value, $map);
    }

    private function matches(string $query, array $fields): bool
    {
        foreach ($fields as $field) {
            if (str_contains($this->normalize($field), $query)) {
                return true;
            }
        }

        return false;
    }
}
