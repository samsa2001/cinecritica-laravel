<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nombre', 
        'foto', 
        'slug', 
        'fecha_1',
        'fecha_2',
        'year_1',
        'year_2', 
        'popularidad', 
        'descripcion',
        'genero',
    ];
    
    public function peliculas()
    {
        return $this->belongsToMany(Pelicula::class)->withPivot('role','personaje','orden');
    }
}
