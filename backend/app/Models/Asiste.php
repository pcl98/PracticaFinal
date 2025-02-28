<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Asiste extends Model
{
    use HasFactory;

    protected $table = 'asiste';

    protected $fillable = [
        'dni',
        'id_clase'
    ];

    public $timestamps = true;

     // Indica que la clave primaria no es autoincremental
     public $incrementing = false;

     // Define la clave primaria compuesta
     protected $primaryKey = ['dni', 'id_clase'];

    /*
     * Relación con la tabla clase
    */
    public function clase() {
        return $this->belongsTo(Clase::class, 'id_clase', 'id');
    }

    /*
     * Relación con la tabla estudiante
    */
    public function estudiante() {
        return $this->belongsTo(UsuarioEstudiante::class, 'dni', 'dni');
    }

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('dni', $this->dni)
                    ->where('id_clase', $this->id_clase);
    }

}
