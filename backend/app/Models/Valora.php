<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Valora extends Model
{
    use HasFactory;

    protected $table = 'valora';

    protected $fillable = [
        'dni',
        'id_clase',
        'comentario',
        'fecha_valoracion',
        'calificacion',
    ];

    public $timestamps = true;

    // Indica que la clave primaria no es autoincremental
    public $incrementing = false;

    // Define la clave primaria compuesta
    protected $primaryKey = ['dni', 'id_clase'];

    /**
     * Relación con el modelo UsuarioEstudiante
     */
    public function estudiante()
    {
        return $this->belongsTo(UsuarioEstudiante::class, 'dni', 'dni');
    }

    /**
     * Relación con el modelo Clase
     */
    public function clase()
    {
        return $this->belongsTo(Clase::class, 'id_clase', 'id');
    }

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('dni', $this->dni)
                    ->where('id_clase', $this->id_clase);
    }
}