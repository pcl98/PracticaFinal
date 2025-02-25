<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsuarioProfesor extends Model
{
    use HasFactory;

    protected $table = 'usuario_profesor';

    protected $fillable = [
        'dni',
        'id',
        'especialidad',
        'media_calificacion',
    ];

    /*
     * Relación con la tabla usuario
    */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id', 'id');
    }

    public $timestamps = true;
}
