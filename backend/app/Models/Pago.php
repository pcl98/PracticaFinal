<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pago';

    protected $fillable = [
        'fecha_pago',
        'metodo_pago',
        'cantidad',
        'concepto',
        'id_estudiante',
        'id_clase',
    ];

    public $timestamps = false;
}
