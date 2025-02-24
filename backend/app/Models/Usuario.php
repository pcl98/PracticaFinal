<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Para iniciar sesión
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory;
    //use SoftDeletes;

    protected $table = 'usuario';

    protected $fillable = [
        'nombre',
        'apellido',
        'nivel',
        'tipo_usuario',
        'contraseña',
        'email',
    ];

    /*protected $hidden = [
        'contraseña', // Oculta la contraseña en las respuestas JSON
    ];*/

    // Mutador para el hashing de contraseñas
    /*public function setPasswordAttribute($value)
    {
        $this->attributes['contraseña'] = bcrypt($value);
    }*/
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Normalmente, es el ID del usuario
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
     * Relación con la tabla usuario_estudiante
    */
    public function estudiante() 
    {
        return $this->hasOne(UsuarioEstudiante::class, 'id', 'id');
    }

}
