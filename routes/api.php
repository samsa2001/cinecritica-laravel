<?php

use App\Http\Controllers\api\BuscadorController;
use App\Http\Controllers\api\PeliculaController;
use App\Http\Controllers\api\PersonaController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\SerieController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\VotosController;
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
Route::get('peliculas/popularidad',[PeliculaController::class,'indexByPopularity']); 
Route::get('pelicula/{pelicula:slug}',[PeliculaController::class,'slug']); 
Route::get('peliculas/soloPeliculas',[PeliculaController::class,'soloPeliculas']); 
Route::get('peliculas/soloEspana',[PeliculaController::class,'soloEspana']); 
Route::resource('peliculas',PeliculaController::class)->except(['create','edit']);

Route::get('series/votos',[SerieController::class,'indexByVotes']); 
Route::get('series/popularidad',[SerieController::class,'indexByPopularity']); 
Route::get('serie/{serie:slug}',[SerieController::class,'slug']); 
Route::get('series/soloSeries',[SerieController::class,'soloSeries']); 
Route::resource('series',SerieController::class)->except(['create','edit']);

Route::get('personas/all',[PersonaController::class,'indexAll']); 
Route::get('persona/{persona:slug}',[PersonaController::class,'slug']); 
Route::get('personas/soloPersonas',[PersonaController::class,'soloPersonas']); 
Route::resource('personas',PersonaController::class)->except(['create','edit']);

Route::get('buscar/popular',[BuscadorController::class,'masPopular']);
Route::get('buscar/{request}',[BuscadorController::class,'index']);

Route::get('posts/estrenos',[PostController::class,'indexEstrenos']);
Route::get('posts/taquilla',[PostController::class,'indexTaquilla']);
Route::get('posts/curiosidades',[PostController::class,'indexCuriosidades']);
Route::get('post/{post:slug}',[PostController::class,'slug']);
Route::resource('posts',PostController::class)->except(['create','edit']);

// usuarios
Route::post('user/login', [UserController::class, 'login']);
Route::post('user/logout', [UserController::class, 'logout']);
Route::post('user/token-check', [UserController::class, 'checkToken']);
Route::post('user/register', [UserController::class, 'register']);

//votos
Route::post('voto',[VotosController::class, 'store']);
