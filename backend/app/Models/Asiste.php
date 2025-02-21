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

    public $timestamps = false;

    /*
     * Relación con la tabla clase
    */
    public function clase() {
        return $this->belongsTo(Clase::class, 'id_clase', 'id');
    }
}
