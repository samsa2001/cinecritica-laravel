<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'serie_temporadas';

    protected $fillable = [
        'id',
        'serie_id',
        'titulo',
        'slug',
        'numero',
        'episodios',
        'fecha',
        'imagen'
    ];
    
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }
}
