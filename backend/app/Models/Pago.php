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

    public $timestamps = true;

    /*
     * Relación con la tabla clase
     */
    public function clase() {
        return $this->belongsTo(Clase::class, 'id_clase', 'id');
    }

    /*
     * Relación con la tabla estudiante
     */
    public function estudiante() {
        return $this->belongsTo(UsuarioEstudiante::class, 'id_estudiante', 'id');
    }
}