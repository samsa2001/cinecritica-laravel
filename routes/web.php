<?php

use App\Http\Controllers\backend\ListaController;
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

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified', 'admin']], function(){
    Route::resources([
        'peliculas' => PeliculaController::class,
        'personas' => PersonaController::class,
        'series' => SerieController::class,
        'posts' => PostController::class,
        'listas' => ListaController::class
    ]);
    Route::get('/pelicula/{pelicula:slug}','App\Http\Controllers\backend\PeliculaController@showSlug')->name('pelicula.show');
    Route::get('/buscarSerie{request?}','App\Http\Controllers\backend\SerieController@buscarSerie');
    
    // Rutas de novedades
    Route::get('/ver-novedades/pelis','App\Http\Controllers\backend\PeliculaController@verNovedades')->name('novedades.pelis');
    Route::get('/ver-novedades/series','App\Http\Controllers\backend\SerieController@verNovedades')->name('novedades.series');
    Route::post('/add-novedades/pelis','App\Http\Controllers\backend\PeliculaController@addNovedades')->name('pelicula.addnovedades');
    Route::post('/add-novedades/series','App\Http\Controllers\backend\SerieController@addNovedades')->name('serie.addnovedades');
    
    // Rutas de cambios y utilidades
    Route::get('/cambios/pelis','App\Http\Controllers\backend\PeliculaController@cambiosDia')->name('cambios.pelis');
    Route::get('/checkPopularity/pelis','App\Http\Controllers\backend\PeliculaController@checkPopularity');
    Route::get('/cambios/series','App\Http\Controllers\backend\SerieController@cambiosDia')->name('cambios.series');
    Route::get('/checkPopularity/series','App\Http\Controllers\backend\SerieController@checkPopularity');
    Route::get('/cambios/personas','App\Http\Controllers\backend\UtilsController@cambiosDia');
    
    // Rutas de proveedores
    Route::get('/proveedores','App\Http\Controllers\backend\UtilsController@addProviders')->name('proveedores.index');
});

Route::get('sitemap/peliculas','App\Http\Controllers\backend\UtilsController@sitemapPeliculas');
Route::get('sitemap/series','App\Http\Controllers\backend\UtilsController@sitemapSeries');
Route::get('sitemap/personas','App\Http\Controllers\backend\UtilsController@sitemapPersonas');
Route::get('/{rutaDeVue?}/{subRutaDeVue?}', function () {
    return view('vue');
})->name('vue');

