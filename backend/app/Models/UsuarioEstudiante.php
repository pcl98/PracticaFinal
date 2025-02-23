<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioEstudiante extends Model
{
    use HasFactory;

    protected $table = 'usuario_estudiante';

    protected $fillable = [
        'dni',
        'id',
        'historial_clases',
        'lecciones_completadas'
    ];

    /*
     * Relación con la tabla usuario
    */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id', 'id');
    }

    /*
     * Relación con la tabla asiste
    */
    public function asiste() 
    {
        return $this->hasMany(Asiste::class, 'dni', 'dni');
    }

    public $timestamps = false;
}
