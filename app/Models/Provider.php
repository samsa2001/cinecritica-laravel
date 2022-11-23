<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nombre',
        'prioridad',
        'logo'
    ];
    public function peliculas()
    {
        return $this->belongsToMany(Pelicula::class,'pelicula_provider');
    }
    public function series()
    {
        return $this->belongsToMany(Serie::class,'serie_provider');
    }
}
