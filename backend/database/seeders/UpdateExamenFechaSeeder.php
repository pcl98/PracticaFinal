<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UpdateExamenFechaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Obtener todos los exámenes
        $examenes = DB::table('examen')->get();

        foreach ($examenes as $examen) {
            // Generar una fecha aleatoria en marzo de 2026
            $fechaAleatoria = Carbon::create(2025, 3, $faker->numberBetween(1, 31));

            // Actualizar la fecha del examen
            DB::table('examen')
                ->where('id', $examen->id)
                ->update(['fecha' => $fechaAleatoria]);
        }
    }
}
