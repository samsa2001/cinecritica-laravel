<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'slug',
    ];

    public function peliculas()
    {
        return $this->belongsToMany(Pelicula::class,'lista_pelicula')->withPivot('orden')->orderBy('orden');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function votos()
    {
        return $this->hasMany(ListaVoto::class);
    }
}
