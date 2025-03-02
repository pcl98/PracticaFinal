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
        'id',
        'fecha',
    ];

    public $timestamps = true;

    /**
     * Relación de muchos a uno con Clase.
     */
    public function clase()
    {
        return $this->belongsTo(Clase::class, 'id');  // La clave ajena es 'id_clase'
    }
}
