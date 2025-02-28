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

    /**
     * Relación con la tabla asiste
     */
    public function asiste() {
        return $this->hasMany(Asiste::class, 'id_clase', 'id');
    }

    /**
     * Relación con la tabla clase_online
     */
    public function online()
    {
        return $this->hasOne(ClaseOnline::class, 'id', 'id');
    }

    /**
     * Relación con la tabla clase_presencial
     */
    public function presencial()
    {
        return $this->hasOne(ClasePresencial::class, 'id', 'id');
    }

    /**
     * Devuelve los estudiantes que asisten a una clase
     */
    public function estudiantes()
    {
        return $this->belongsToMany(UsuarioEstudiante::class, 'asiste', 'id_clase', 'dni', 'id', 'dni');
    }

    /**
     * Relación con la tabla usuario_profesor (una clase pertenece a un profesor)
     */
    public function profesor()
    {
        return $this->belongsTo(UsuarioProfesor::class, 'profesor_id', 'id');
    }
}
