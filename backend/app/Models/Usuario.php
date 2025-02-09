<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Para iniciar sesión

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuario';

    protected $fillable = [
        'nombre',
        'apellido',
        'nivel',
        'tipo_usuario',
        'contraseña',
        'email',
    ];

    // Mutador para el hashing de contraseñas
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // Desactivamos timestamps
    public $timestamps = false;
}
