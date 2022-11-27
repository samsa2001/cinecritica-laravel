<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelicula;
use App\Models\Persona;

class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $peliculas = Pelicula::orderBy('popularidad','desc')->paginate(10);
        $peliculas = Pelicula::orderBy('fecha','desc')->paginate(10);
        return response()->json($peliculas);
    }
    public function indexByVotes()
    {
        // $peliculas = Pelicula::orderBy('popularidad','desc')->paginate(10);
        $peliculas = Pelicula::orderBy('numero_votos','desc')->paginate(10);
        return response()->json($peliculas);
    }
    public function soloPeliculas()
    {
        $peliculas = Pelicula::orderBy('popularidad','desc')->paginate(20);
        return response()->json($peliculas);
    }
    public function soloEspana()
    {
        $peliculas = Pelicula::where('idioma', 'es')->orderBy('fecha','desc')->paginate(10);
        return response()->json($peliculas);
    }

    public function slug(Pelicula $pelicula)
    {
        // dd($pelicula);
        $pelicula->actores;
        $pelicula->directores;
        $pelicula->guionistas;
        $pelicula->escritores;
        $pelicula->generos;
        $pelicula->imagenes;
        $pelicula->providers;
        //dd($pelicula->actores->role);
        return response()->json($pelicula);
    }

    public function indexAll()
    {
        // $peliculas = Pelicula::orderBy('popularidad','desc')->paginate(10);
        $peliculas = Pelicula::orderBy('fecha','desc')->get();
        return response()->json($peliculas);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelicula = Pelicula::find($id);
        return view('backend.peliculas.show',compact('pelicula'));
    }
    public function showSlug($slug)
    {
        $pelicula = Pelicula::where('slug',$slug)->firstOrFail();
        return view('backend.peliculas.show',compact('pelicula'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}