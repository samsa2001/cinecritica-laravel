<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use App\Models\Serie;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Temporada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BuscadorController extends Controller
{

    public function index($request)
    {
        if (isset($request) && strlen($request) > 3) {
            $series = Serie::where('titulo', 'like', '%' . $request . '%')->get();
            $pelis = Pelicula::where('titulo', 'like', '%' . $request . '%')->get();
            $persona = Persona::where('nombre', 'like', '%' . $request . '%')->get();
            return response()->json($series->merge($pelis->merge($persona))->sortByDesc('popularidad'));
        } else {
            $series = Serie::orderBy('numero_votos','desc')->paginate(100);
            return response()->json($series);
        }

    }
    public function masPopular(){
        $pelis = Pelicula::select('id', 'titulo','popularidad','nota','imagen','slug')->where('year', '>' , '2021')->orderBy('popularidad','desc')->take(12)->get();
        $series = Serie::select('id', 'titulo','popularidad', 'nota','imagen','slug','numero_episodios')->where('year', '>' , '2021')->orderBy('popularidad','desc')->take(8)->get();
        $ordenado = $pelis->merge($series)->sortByDesc('popularidad');
        // dd($ordenado);
        return response()->json($ordenado->values()->all());
    }
}
