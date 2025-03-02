<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ClaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Obtener todos los exámenes
        $clases = DB::table('clase')->get();

        foreach ($clases as $clase) {
            // Generar una fecha aleatoria en marzo de 2026
            $fechaAleatoria = Carbon::create(2025, 3, $faker->numberBetween(1, 31));

            // Actualizar la fecha del examen
            DB::table('clase')
                ->where('id', $clase->id)
                ->update(['fecha' => $fechaAleatoria]);
        }
    }
}
