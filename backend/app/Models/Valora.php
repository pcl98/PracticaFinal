<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Valora extends Model
{
    use HasFactory;

    protected $table = 'valora';

    protected $fillable = [
        'dni',
        'id_clase',
        'comentario',
        'fecha_valoracion',
        'califiacion',
    ];

    public $timestamps = false;
}
