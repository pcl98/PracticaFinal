<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Para iniciar sesión
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'usuario';

    protected $fillable = [
        'nombre',
        'apellido',
        'nivel',
        'tipo_usuario',
        'password',
        'email',
    ];

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
        return []; // Puedes agregar más datos al token si lo necesitas
    }

    // Desactivamos timestamps
    public $timestamps = false;
}
