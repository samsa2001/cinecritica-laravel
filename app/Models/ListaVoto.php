<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaVoto extends Model
{
    use HasFactory;

    protected $table = 'lista_voto';

    protected $fillable = [
        'lista_id',
        'user_id',
        'voto'
    ];

    public function lista()
    {
        return $this->belongsTo(Lista::class,'lista_pelicula');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
