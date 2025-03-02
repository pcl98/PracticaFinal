<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesorDescripcionSeeder extends Seeder
{
    /**
     * Ejecutar el seeder.
     *
     * @return void
     */
    public function run()
    {
        // Descripciones ficticias para los profesores basadas en su especialidad
        $descripciones = [
            2 => "Profesora apasionada por la guitarra, con más de 10 años de experiencia enseñando en diferentes niveles. Su enfoque se centra en la técnica y la expresión personal.",
            5 => "Profesora experta en piano, con un enfoque pedagógico flexible que se adapta a las necesidades y objetivos del estudiante. Aporta conocimientos teóricos y prácticos.",
            7 => "Profesora de batería con una gran trayectoria en el escenario. Su metodología se basa en la improvisación y el ritmo, buscando la creatividad de los estudiantes.",
            10 => "Profesor de canto con un enfoque técnico para el desarrollo de la voz. Se especializa en técnicas de respiración y control vocal.",
            3 => "Profesor de violín con años de experiencia en música clásica y contemporánea. Sus clases se adaptan a estudiantes de todos los niveles.",
            4 => "Profesor de bajo con enfoque en los aspectos técnicos y creativos del instrumento. Sus clases incluyen teoría musical y práctica en grupo.",
            6 => "Profesor de canto con una fuerte base en técnicas vocales y expresión emocional. Se enfoca en lograr un sonido único para cada alumno.",
            9 => "Profesor de teclado con enfoque en la armonía y la improvisación. Ofrece una enseñanza práctica y dinámica para todos los niveles.",
            8 => "Profesor de flauta con más de 15 años de experiencia. Se enfoca en la técnica, interpretación y musicalidad del instrumento.",
            1 => "Profesor de percusión con un enfoque en la coordinación y el ritmo. Las clases incluyen una mezcla de teoría y mucha práctica para perfeccionar las habilidades de los estudiantes."
        ];

        // Actualizar las descripciones de los profesores
        foreach ($descripciones as $id => $descripcion) {
            DB::table('usuario_profesor')->where('id', $id)->update(['descripcion' => $descripcion]);
        }
    }
}
