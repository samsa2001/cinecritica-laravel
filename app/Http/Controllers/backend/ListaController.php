<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateListaRequest;
use App\Models\Lista;
use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $listas = Lista::orderBy('updated_at', 'desc')->with('user')->paginate(10);
    // dd($listas);
    return view('backend.listas.index', compact('listas'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $lista = new Lista();
    $peliculas = Pelicula::pluck('id', 'titulo');
    return view('backend.listas.create', compact('lista', 'peliculas'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(UpdateListaRequest $request)
  {
    if( Auth::check()){
      $data = $request->validated();
      $data['user_id']=Auth::id();
      $lista = Lista::create($data);
      $lista->peliculas()->attach([829280,'orden'=>'100']);
      // $lista->peliculas()->attach([[829280,'orden'=>'100'],[399566,'orden'=>'100'],[373571,'orden'=>'100'],[497582,'orden'=>'100']]);
      return redirect()->route('listas.index')->with('status', 'Lista actualizada');
    }
    return redirect()->route('listas.index')->with('status', 'Debes estar identificado');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Lista $lista)
  {
    $lista->user;
    $lista->peliculas;
    return view('backend.listas.show', compact('lista'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Lista $lista)
  {
    $peliculas = Pelicula::pluck('id', 'titulo');
    return view('backend.listas.edit', compact('lista', 'peliculas'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateListaRequest $request,  Lista $lista)
  {
    $data = $request->validated();
    $lista->update($data);
    return redirect()->route('listas.index')->with('status', 'Lista actualizada');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Lista $lista)
  {    
    $lista->peliculas()->detach();
    $lista->delete();        
    return redirect()->route('listas.index');
  }
}
