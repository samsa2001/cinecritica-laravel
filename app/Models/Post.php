<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'slug',
        'categoria_id' ,
        'contenido',
        'imagen',
        'fecha'
    ];
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
