<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClasePresencial extends Model
{
    use HasFactory;

    protected $table = 'clase_presencial';

    protected $fillable = [
        'id',
        'ubicacion',
    ];

    public $timestamps = true;

    /*
     * Relación con la tabla clase
    */
    public function clase() {
        return $this->belongsTo(Clase::class, 'id', 'id');
    }
}
