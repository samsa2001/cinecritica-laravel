<?php

use App\Http\Controllers\backend\PeliculaController;
use App\Http\Controllers\backend\PersonaController;
use App\Http\Controllers\backend\SerieController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'backend'], function(){
    Route::resources([
        'peliculas' => PeliculaController::class,
        'personas' => PersonaController::class,
        'series' => SerieController::class,
    ]);
    Route::get('/pelicula/{pelicula:slug}','App\Http\Controllers\backend\PeliculaController@showSlug')->name('pelicula.show');
    Route::get('/importar-directores','App\Http\Controllers\backend\PersonaController@importarDirectores');
    Route::get('/importar-escritores','App\Http\Controllers\backend\PersonaController@importarEscritores');
    Route::get('/importar-guionistas','App\Http\Controllers\backend\PersonaController@importarGuionistas');
    Route::get('/prueba5','App\Http\Controllers\backend\PeliculaController@prueba5');
    Route::get('/buscarSerie{request?}','App\Http\Controllers\backend\SerieController@buscarSerie');
    Route::get('/prueba4{request?}','App\Http\Controllers\backend\SerieController@prueba4');
    Route::get('/pruebas5','App\Http\Controllers\backend\SerieController@prueba5');
});
