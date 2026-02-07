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

/*
|--------------------------------------------------------------------------
| API Routes - Public (GET only)
|--------------------------------------------------------------------------
*/
Route::get('peliculas/index',[PeliculaController::class,'index']); 
Route::get('peliculas/votos',[PeliculaController::class,'indexByVotes']); 
Route::get('peliculas/popularidad',[PeliculaController::class,'indexByPopularity']); 
Route::get('pelicula/{pelicula:slug}',[PeliculaController::class,'slug']); 
Route::get('peliculas/soloPeliculas',[PeliculaController::class,'soloPeliculas']); 
Route::get('peliculas/soloEspana',[PeliculaController::class,'soloEspana']); 

Route::get('series/votos',[SerieController::class,'indexByVotes']); 
Route::get('series/popularidad',[SerieController::class,'indexByPopularity']); 
Route::get('serie/{serie:slug}',[SerieController::class,'slug']); 
Route::get('series/soloSeries',[SerieController::class,'soloSeries']); 

Route::get('personas/all',[PersonaController::class,'indexAll']); 
Route::get('persona/{persona:slug}',[PersonaController::class,'slug']); 
Route::get('personas/soloPersonas',[PersonaController::class,'soloPersonas']); 

Route::get('buscar/popular',[BuscadorController::class,'masPopular']);
Route::get('buscar/{request}',[BuscadorController::class,'index']);

Route::get('posts/estrenos',[PostController::class,'indexEstrenos']);
Route::get('posts/taquilla',[PostController::class,'indexTaquilla']);
Route::get('posts/curiosidades',[PostController::class,'indexCuriosidades']);
Route::get('post/{post:slug}',[PostController::class,'slug']);

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::post('user/login', [UserController::class, 'login']);
Route::post('user/register', [UserController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Protected Routes - API (Requires Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    // User
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::post('user/token-check', [UserController::class, 'checkToken']);
    
    // Protected Resources (Create, Update, Delete)
    Route::post('peliculas', [PeliculaController::class, 'store']);
    Route::put('peliculas/{pelicula}', [PeliculaController::class, 'update']);
    Route::delete('peliculas/{pelicula}', [PeliculaController::class, 'destroy']);
    Route::get('peliculas', [PeliculaController::class, 'index']);
    Route::get('peliculas/{pelicula}', [PeliculaController::class, 'show']);
    
    Route::post('series', [SerieController::class, 'store']);
    Route::put('series/{serie}', [SerieController::class, 'update']);
    Route::delete('series/{serie}', [SerieController::class, 'destroy']);
    Route::get('series', [SerieController::class, 'index']);
    Route::get('series/{serie}', [SerieController::class, 'show']);
    
    Route::post('personas', [PersonaController::class, 'store']);
    Route::put('personas/{persona}', [PersonaController::class, 'update']);
    Route::delete('personas/{persona}', [PersonaController::class, 'destroy']);
    Route::get('personas', [PersonaController::class, 'index']);
    Route::get('personas/{persona}', [PersonaController::class, 'show']);
    
    Route::post('posts', [PostController::class, 'store']);
    Route::put('posts/{post}', [PostController::class, 'update']);
    Route::delete('posts/{post}', [PostController::class, 'destroy']);
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{post}', [PostController::class, 'show']);
    
    // Votos (should be authenticated)
    Route::post('voto', [VotosController::class, 'store']);
});
