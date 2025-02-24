<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $table = 'clase';

    protected $fillable = [
        'instrumento',
        'dificultad',
        'duracion',
        'max_alumnos',
        'precio',
        'profesor_id',
    ];

    public $timestamps = true;
}
