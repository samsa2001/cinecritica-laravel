<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'id',
        'titulo',
        'nota',
        'descripcion',
        'slug',
        'imagen',
        'numero_votos',
        'titulo_original',
        'presupuesto',
        'recaudacion',
        'fecha',
        'imdb_id',
        'productora',
        'duracion',
        'year',
        'tagline',
        'certificacion',
        'popularidad',
        'video',
        'pais',
        'idioma',
        'imagen_principal'
    ];

    public function actores()
    {
        return $this->belongsToMany(Persona::class,'pelicula_actor')->withPivot('personaje','orden')->orderBy('orden');
    }
    public function directores()
    {
        return $this->belongsToMany(Persona::class,'pelicula_director');
    }
    public function escritores()
    {
        return $this->belongsToMany(Persona::class,'pelicula_guionista')->withPivot('role')->wherePivot('role','escritor');
    }
    public function guionistas()
    {
        return $this->belongsToMany(Persona::class,'pelicula_guionista')->withPivot('role')->wherePivot('role','guionista');
    }
    public function generos()
    {
        return $this->belongsToMany(Genero::class,'pelicula_genero');
    }
}
