<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenPelicula extends Model
{
    use HasFactory;

    protected $table = 'pelicula_imagenes';
    
    public $timestamps = false;

    protected $fillable = [
        'imagen',
        'pelicula_id'
    ];
    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class);
    }
}
