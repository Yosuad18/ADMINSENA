<?php

namespace App\Support;

use App\Models\Area;
use App\Models\Apprentice;
use App\Models\Computer;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\TrainingCenter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminDashboard
{
    public static function baseUrl(): string
    {
        $url = config('services.admin_api.base_url') ?: config('app.url') . '/api/v1';

        return rtrim($url, '/');
    }

    public static function tables(): array
    {
        return [
            [
                'key'      => 'areas',
                'label'    => 'Áreas tecnológicas',
                'icon'     => 'fa-layer-group',
                'endpoint' => '/areas',
                'route'    => 'areas.index',
                'model'    => Area::class,
            ],
            [
                'key'      => 'training-centers',
                'label'    => 'Centros de formación',
                'icon'     => 'fa-building',
                'endpoint' => '/training-centers',
                'route'    => 'training-centers.index',
                'model'    => TrainingCenter::class,
            ],
            [
                'key'      => 'computers',
                'label'    => 'Equipos de cómputo',
                'icon'     => 'fa-desktop',
                'endpoint' => '/computers',
                'route'    => 'computers.index',
                'model'    => Computer::class,
            ],
            [
                'key'      => 'teachers',
                'label'    => 'Instructores',
                'icon'     => 'fa-chalkboard-user',
                'endpoint' => '/teachers',
                'route'    => 'teachers.index',
                'model'    => Teacher::class,
            ],
            [
                'key'      => 'courses',
                'label'    => 'Cursos / Fichas',
                'icon'     => 'fa-book-open',
                'endpoint' => '/courses',
                'route'    => 'courses.index',
                'model'    => Course::class,
            ],
            [
                'key'      => 'apprentices',
                'label'    => 'Aprendices',
                'icon'     => 'fa-user-graduate',
                'endpoint' => '/apprentices',
                'route'    => 'apprentices.index',
                'model'    => Apprentice::class,
            ],
        ];
    }

    public static function fetch(string $endpoint): ?array
    {
        try {
            $response = Http::timeout(5)
                ->acceptJson()
                ->get(self::baseUrl() . $endpoint);
        } catch (\Throwable $e) {
            Log::warning('Sin conexión con la API del cliente: ' . $e->getMessage());

            return null;
        }

        if ($response->failed()) {
            Log::warning("La API del cliente respondió con error en {$endpoint}", [
                'status' => $response->status(),
            ]);

            return null;
        }

        $data = $response->json();

        return is_array($data) ? $data : null;
    }

    public static function records(array $table): array
    {
        return self::fetch($table['endpoint']) ?? [];
    }

    public static function count(array $table): int
    {
        $records = self::fetch($table['endpoint']);

        if ($records !== null) {
            return count($records);
        }

        return self::localCount($table);
    }

    public static function overview(): array
    {
        $online = false;

        $tables = collect(self::tables())
            ->map(function (array $table) use (&$online) {
                $records = self::fetch($table['endpoint']);

                $online = $online || $records !== null;

                $table['count'] = $records !== null ? count($records) : self::localCount($table);

                return $table;
            })
            ->values();

        return ['tables' => $tables, 'online' => $online];
    }

    private static function localCount(array $table): int
    {
        $model = $table['model'];

        try {
            return (int) $model::count();
        } catch (\Throwable $e) {
            Log::warning("No fue posible contar la tabla {$table['key']}: " . $e->getMessage());

            return 0;
        }
    }
}
