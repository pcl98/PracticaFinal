<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Examen extends Model
{
    use HasFactory;

    protected $table = 'examen';

    protected $fillable = [
        'titulo',
        'descripcion',
        'nivel_dificultad',
        'puntuacion',
    ];

    public $timestamps = false;
}
