<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Course;
use App\Models\TrainingCenter;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrador ADMISENA',
            'email' => 'admin@sena.edu.co',
            'password' => Hash::make('admin123'),
        ]);

        $centers = [];
        foreach ([
            'Centro de Comercio y Servicios' => 'Calle 4 No. 2-80, Barrio Centro - Popayán, Cauca',
            'Centro Agropecuario' => 'Km 4 Vía al norte, vereda Calibío - Popayán, Cauca',
            'Ciudad Jardín' => 'Carrera 12 No. 41-30, Barrio Ciudad Jardín - Popayán, Cauca',
        ] as $name => $address) {
            $centers[$name] = TrainingCenter::firstOrCreate(['name' => $name], ['address' => $address]);
        }

        $areas = [];
        foreach (['Salud', 'Finanzas', 'Tecnología', 'Belleza', 'Barismo'] as $areaName) {
            $areas[$areaName] = Area::firstOrCreate(['name' => $areaName]);
        }

        $commerce = $centers['Centro de Comercio y Servicios'];
        $agro = $centers['Centro Agropecuario'];
        $jardin = $centers['Ciudad Jardín'];

        $tech = $areas['Tecnología'];
        $health = $areas['Salud'];
        $fin = $areas['Finanzas'];
        $beauty = $areas['Belleza'];
        $bar = $areas['Barismo'];

        $now = Carbon::now();

        $offerings = [
            ['ADSO-2738711', 'Análisis y Desarrollo de Software',   'Diurno',   45, $tech,   [$commerce]],
            ['GRD-2738812', 'Gestión de Redes de Datos',            'Nocturno', 40, $tech,   [$jardin]],
            ['MEI-2738901', 'Mantenimiento Electrónico Industrial', 'Diurno',    30, $tech,   [$commerce]],
            ['CF-2739002',  'Contabilidad y Finanzas',              'Diurno',    50, $fin,    [$commerce, $jardin]],
            ['ENF-2739101', 'Técnico en Enfermería',                'Diurno',    25, $health, [$jardin, $commerce]],
            ['NUT-2739401', 'Técnico en Nutrición y Dietética',     'Diurno',    38, $health, [$agro]],
            ['BAR-2739201', 'Barismo y Cafés Especiales',           'Nocturno',  35, $bar,    [$commerce, $agro]],
            ['BEL-2739301', 'Servicios de Belleza',                 'Diurno',    28, $beauty, [$jardin, $commerce]],
            ['BEL-2739302', 'Maquillaje Profesional',               'Nocturno',  21, $beauty, [$jardin]],
            ['CF-2739009',  'Gestión Financiera y de Cartera',      'Nocturno',   4, $fin,    [$commerce]],
            ['ENF-2739999', 'Auxiliar en Salud Oral (cerrada)',     'Diurno',    -3, $health, [$agro]],
        ];

        foreach ($offerings as [$code, $name, $day, $daysToDeadline, $area, $centerList]) {
            foreach ($centerList as $center) {
                Course::firstOrCreate(
                    ['course_number' => $code, 'training_center_id' => $center->id],
                    [
                        'name' => $name,
                        'day' => $day,
                        'deadline' => $now->copy()->addDays($daysToDeadline)->toDateString(),
                        'image' => null,
                        'area_id' => $area->id,
                        'training_center_id' => $center->id,
                    ]
                );
            }
        }
    }
}
