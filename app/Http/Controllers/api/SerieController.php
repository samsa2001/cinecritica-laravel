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

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $personas = persona::orderBy('popularidad','desc')->paginate(10);
        $series = Serie::orderBy('fecha','desc')->with('actores')->paginate(20);
        return response()->json($series);
    }
    public function soloSeries()
    {
        $series = Serie::orderBy('popularidad','desc')->paginate(30);
        return response()->json($series);
    }

    public function indexByVotes()
    {
        // $peliculas = Pelicula::orderBy('popularidad','desc')->paginate(10);
        $series = Serie::orderBy('numero_votos','desc')->with('actores')->paginate(20);
        return response()->json($series);
    }
    public function indexByPopularity()
    {
        $series = Serie::orderBy('popularida2','desc')->with('actores')->paginate(20);
        return response()->json($series);
    }

    public function slug(Serie $serie)
    {
        $serie->actores;
        $serie->temporadas;     
        $serie->creadores;
        $serie->generos;
        $serie->imagenes;
        $serie->providers;
        return response()->json($serie);
    }
}
