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

    /*
     * Relación con la tabla notificaciones
    */
    public function notificaciones() 
    {
        return $this->hasMany(Notifica::class, 'dni', 'dni');
    }

    /**
     * Devuelve la info de todas las clases a las que ha asistido un estudiante
     */
    public function clases() 
    {
        return $this->belongsToMany(Clase::class, 'asiste', 'dni', 'id_clase', 'dni', 'id');
    }

    public $timestamps = true;
}
