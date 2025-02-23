<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsuarioProfesor extends Model
{
    use HasFactory;

    protected $table = 'usuario_profesor';

    protected $fillable = [
        'dni',
        'id',
        'especialidad',
        'media_calificacion',
    ];

    public $timestamps = false;
}
