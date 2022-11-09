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
        return $this->belongsToMany(Pelicula::class,'pelicula_actor')->withPivot('personaje','orden')->orderBy('popularidad','desc');
    }
    public function esDirector()
    {
        return $this->belongsToMany(Pelicula::class,'pelicula_director')->orderBy('popularidad','desc');
    }
    public function esGuionista()
    {
        return $this->belongsToMany(Pelicula::class,'pelicula_guionista')->withPivot('role')->orderBy('popularidad','desc');
    }
    public function series()
    {
        return $this->belongsToMany(Serie::class,'serie_persona')->withPivot('role','personaje','orden')->orderBy('popularidad','desc');
    }
}
