<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use App\Models\Persona;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $personas = persona::orderBy('popularidad','desc')->paginate(10);
        $personas = Persona::orderBy('popularidad','desc')->with('peliculas','esDirector','esGuionista')->paginate(10);
        return response()->json($personas);
    }
    public function soloPersonas()
    {
        $personas = Persona::orderBy('popularidad','desc')->paginate(20);
        return response()->json($personas);
    }

    public function slug(Persona $persona)
    {
        $persona->peliculas;
        $persona->esDirector;
        $persona->esGuionista;
        $persona->series;
        return response()->json($persona);
    }

}