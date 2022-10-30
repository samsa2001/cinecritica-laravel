<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'imagen_principal',
        'director_id'
    ];

    public function actores()
    {
        return $this->belongsToMany(Persona::class)->wherePivot('role','actor');
    }
    public function directores()
    {
        return $this->belongsToMany(Persona::class)->wherePivot('role','director');
    }
    public function escritores()
    {
        return $this->belongsToMany(Persona::class)->wherePivot('role','escritor');
    }
    public function guionistas()
    {
        return $this->belongsToMany(Persona::class)->wherePivot('role','guionista');
    }
}
