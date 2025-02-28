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

    public $timestamps = true;
    
    /**
     * Relación con el modelo UsuarioProfesor
     */
    public function profesor()
    {
        // Relación uno a uno, el dni de notifica hace referencia a usuario_profesor.dni
        return $this->belongsTo(UsuarioProfesor::class, 'dni', 'dni');
    }

    /**
     * Relación con el modelo Clase
     */
    public function clase()
    {
        // Relación de muchos a uno, id_clase hace referencia a clase.id
        return $this->belongsTo(Clase::class, 'id_clase', 'id');
    }
}
