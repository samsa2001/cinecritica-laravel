<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenSerie extends Model
{
    use HasFactory;

    protected $table = 'serie_imagenes';
    
    public $timestamps = false;

    protected $fillable = [
        'imagen',
        'serie_id'
    ];
    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }
}
