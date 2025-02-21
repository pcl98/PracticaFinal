<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClaseOnline extends Model
{
    use HasFactory;

    protected $table = 'clase_online';

    protected $fillable = [
        'id',
        'url_video',
        'titulo',
    ];

    public $timestamps = false;
}
