<?php

use App\Http\Controllers\backend\PostController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'backend'], function(){
    Route::resources([
        'peliculas' => PeliculaController::class,
        'personas' => PersonaController::class,
        'series' => SerieController::class,
        'posts' => PostController::class
    ]);
    Route::get('/pelicula/{pelicula:slug}','App\Http\Controllers\backend\PeliculaController@showSlug')->name('pelicula.show');
    Route::get('/importar-directores','App\Http\Controllers\backend\PersonaController@importarDirectores');
    Route::get('/importar-escritores','App\Http\Controllers\backend\PersonaController@importarEscritores');
    Route::get('/importar-guionistas','App\Http\Controllers\backend\PersonaController@importarGuionistas');
    Route::get('/addImagenPeliculas','App\Http\Controllers\backend\PeliculaController@addImagenPeliculas');
    Route::get('/buscarSerie{request?}','App\Http\Controllers\backend\SerieController@buscarSerie');
    Route::group(['prefix' => 'serie'], function(){
        Route::get('/prueba4{request?}','App\Http\Controllers\backend\SerieController@prueba4');
        Route::get('/pruebas5','App\Http\Controllers\backend\SerieController@prueba5');
    });    
    Route::get('/ver-novedades/pelis','App\Http\Controllers\backend\PeliculaController@verNovedades');
    Route::get('/ver-novedades/series','App\Http\Controllers\backend\SerieController@verNovedades');
    Route::get('/add-novedades/pelis','App\Http\Controllers\backend\PeliculaController@addNovedades');
    Route::get('/cambios/pelis','App\Http\Controllers\backend\PeliculaController@cambiosDia');
    Route::get('/add-novedades/series','App\Http\Controllers\backend\SerieController@addNovedades');
    Route::get('/cambios/series','App\Http\Controllers\backend\SerieController@cambiosDia');
    Route::get('/cambios/personas','App\Http\Controllers\backend\UtilsController@cambiosDia');
    Route::get('/addImagenSeries','App\Http\Controllers\backend\SerieController@addImagenSeries');
    Route::get('/traspaso','App\Http\Controllers\backend\UtilsController@traspasarTablaPersonasSerie');
    Route::get('/updatePersonas','App\Http\Controllers\backend\UtilsController@updatePersonas');
    Route::get('/addProviders','App\Http\Controllers\backend\UtilsController@addProviders');
});

Route::get('sitemap/peliculas','App\Http\Controllers\backend\UtilsController@sitemapPeliculas');
Route::get('sitemap/series','App\Http\Controllers\backend\UtilsController@sitemapSeries');
Route::get('sitemap/personas','App\Http\Controllers\backend\UtilsController@sitemapPersonas');
Route::get('/{rutaDeVue?}/{subRutaDeVue?}', function () {
    return view('vue');
})->name('vue');

