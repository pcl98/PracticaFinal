<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifica extends Model
{
    use HasFactory;

    protected $table = 'notifica';

    protected $fillable = [
        'dni',
        'id_clase',
        'fecha_envio',
        'contenido',
    ];

    public $timestamps = false;
}
