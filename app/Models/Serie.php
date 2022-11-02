<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
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
        'fecha',
        'imdb_id',
        'canal',
        'year',
        'tagline',
        'certificacion',
        'numero_episodios',
        'numero_temporadas',
        'duracion',
        'en_produccion',
        'fecha_ultimo',
        'popularidad',
        'tvdb_id',
        'pais',
        'idioma',
        'video',
        'imagen_principal'
    ];

    public function actores()
    {
        return $this->belongsToMany(Persona::class,'serie_persona')->wherePivot('role','actor')->orderBy('orden');
    }
    public function creadores()
    {
        return $this->belongsToMany(Persona::class,'serie_persona')->wherePivot('role','creador');
    }
    public function generos()
    {
        return $this->belongsToMany(Genero::class,'serie_genero');
    }
    public function temporadas()
    {
        return $this->hasMany(Temporada::class);
    }
}
