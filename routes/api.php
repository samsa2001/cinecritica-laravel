<?php

use App\Http\Controllers\api\BuscadorController;
use App\Http\Controllers\api\PeliculaController;
use App\Http\Controllers\api\PersonaController;
use App\Http\Controllers\api\SerieController;
use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('peliculas/votos',[PeliculaController::class,'indexByVotes']); 
Route::get('pelicula/{pelicula:slug}',[PeliculaController::class,'slug']); 
Route::resource('peliculas',PeliculaController::class)->except(['create','edit']);

Route::get('series/votos',[SerieController::class,'indexByVotes']); 
Route::get('serie/{serie:slug}',[SerieController::class,'slug']); 
Route::resource('series',SerieController::class)->except(['create','edit']);

Route::get('personas/all',[PersonaController::class,'indexAll']); 
Route::get('persona/{persona:slug}',[PersonaController::class,'slug']); 
Route::resource('personas',PersonaController::class)->except(['create','edit']);

Route::get('buscar/popular',[BuscadorController::class,'masPopular']);
Route::get('buscar/{request}',[BuscadorController::class,'index']);
