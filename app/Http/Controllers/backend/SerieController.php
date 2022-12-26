<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ImagenSerie;
use App\Models\Pelicula;
use App\Models\Serie;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Temporada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $series = Serie::paginate(10);
        return view('backend.series.index', compact('series'));
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
        $serie = Serie::find($id);
        return view('backend.series.show', compact('serie'));
    }
    public function showSlug($slug)
    {
        $serie = Serie::where('slug', $slug)->firstOrFail();
        return view('backend.series.show', compact('serie'));
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

    public function getMovieApi($pregunta)
    {
        $authorization = "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NDQwMDlmMWM5YWY1YzZlYTkzNTBjZjVlZDU1YTA4YSIsInN1YiI6IjYwYWZiOTcxNWIwNzE0MDAyOTY2YzFmOCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.b_bDJCgVUc9w1C5816Mm2alWfAqyYRF5Ss_pWmpvDgY";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.themoviedb.org/3/" . $pregunta,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                $authorization
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($response) return json_decode($response, true);
        return $err;
    }
    public function prueba5()
    {
        // $series = DB::select('select * from ramon_series_series_genero');
        // $idSeries = array();
        // // foreach ($series as $serie){
        // //     if (!Serie::find($serie->serie_id) && !array_search($serie->serie_id,$idSeries)){
        //         //  $idSeries[] = $serie->serie_id;
        //          $idSeries[] =1448;
        //     }
        // }
        // $this->addseries(array_slice($idSeries, 0, 500));

        //$this->addseries($idSeries);
        $series = DB::select('select `id`,`pais`, `video` from ramon_peliculas_series');
        //dd($series);
        foreach ($series as $serie) {
            $objserie = Serie::find($serie->id);
            $objserie->update([
                'pais' => $serie->pais,
                'video' => $serie->video
            ]);
            echo 'Added -> ' . $objserie->id . '<hr>';
        }
    }
    public function buscarSerie(Request $request)
    {
        $series = '';
        if (isset($request['year']) && $request['year'] < 2023 && $request['year'] > 1900) {
            $series = Serie::where('year', $request['year'])->paginate();
        }
        if (isset($request['find']) && strlen($request['find']) > 3) {
            $strQuery = 'select `id`, `titulo` from `peliculas` where `titulo` Like "%' . $request['find'] . '%"';
            $arrayPelis = DB::select($strQuery);
            $strQuery = 'select `id`, `titulo` from `series` where `titulo` Like "%' . $request['find'] . '%"';
            $arraySeries = DB::select($strQuery);
            //dd(array_merge($arrayPelis,$arraySeries));
            $series = Serie::where('titulo', 'like', '%' . $request['find'] . '%')->get();
            $pelis = Pelicula::where('titulo', 'like', '%' . $request['find'] . '%')->get();
            $persona = Persona::where('nombre', 'like', '%' . $request['find'] . '%')->get();
            //dd($series->merge($pelis->merge($persona))->sortByDesc('popularidad'));
            return view('backend.search', ['collection' => $series->merge($pelis->merge($persona))->sortByDesc('popularidad')]);
        } else {
            $series = Serie::orderBy('numero_votos','desc')->paginate(100);
            return view('backend.search', ['collection' => $series]);
        }
        // return view('backend.series.indexAll',compact('series'));

    }
    public function prueba4(Request $request)
    {
        $series = '';
        if (isset($request['year']) && $request['year'] < 2023 && $request['year'] > 1900) {
            $series = Serie::where('year', $request['year'])->paginate();
        } else
            $series = Serie::paginate(10);
        dd($series);
        return view('backend.series.index', compact('series'));
    }
    public function guardarImagen($url, $rol)
    {
        $path = "https://image.tmdb.org/t/p/original" . $url;
        if (isset($url))
            try {
                $contents = file_get_contents($path);
                if ($rol == 'actor') {
                    $rol = 'actores';
                } elseif ($rol == 'director') {
                    $rol = 'directores';
                } elseif ($rol == 'creador') {
                    $rol = 'creador';
                } elseif ($rol == 'principal') {
                    $rol = 'imagen_principal';
                } elseif ($rol == 'principal-serie') {
                    $rol = 'imagen-principal-series';
                } elseif ($rol == 'serie-temporada') {
                    $rol = "series-temporada";
                } elseif ($rol == 'serie') {
                    $rol = 'series';
                } else {
                    $rol = 'peliculas';
                }
                $name = 'media/' . $rol . $url;
                Storage::put($name, $contents);
            } catch (\Throwable $th) {
                echo $th;
            }
    }
    public function verNovedades()
    {
        $query = "discover/tv?language=es-ES&vote_count.gte=20&first_air_date.gte=2022-08-21&page=";
        $novedades = $this->getMovieApi($query . "1");
        $newSeries = [];
        $updatedSeries = [];
        for ($i = 1; $i <= $novedades["total_pages"]; $i++) {
            $novedades = $this->getMovieApi($query . $i);
            foreach ($novedades['results'] as $resultado)
                if(Serie::find($resultado['id']) != null) {
                    array_push($updatedSeries,$resultado['id']);
                } else {
                    $datosSerie = $this->getMovieApi("tv/" . $resultado['id']. "?language=es-ES");
                    array_push($newSeries,$datosSerie);
                }
        }
        return view('backend.series.novedades', ['series' => $newSeries]);
        dd($updatedSeries,$newSeries);
    }
 
    // public function addNovedades(){
    //     $query = "discover/tv?language=es-ES&vote_count.gte=50&first_air_date.gte=2022-08-21&page=";
    //     $novedades = $this->getMovieApi($query . "1");
    //     $newSeries = [];
    //     $updatedSeries = [];
    //     for ($i=1; $i <= $novedades["total_pages"]; $i++){
    //         $novedades = $this->getMovieApi($query . $i);
    //         foreach($novedades['results'] as $resultado){
    //             if(Serie::find($resultado['id']) != null) {
    //                 array_push($updatedSeries,$resultado['id']);
    //             } else {
    //                 array_push($newSeries,$resultado['id']);
    //             }
    //         }
    //     }
    //     // dd($newSeries, $updatedSeries);
    //     if (count($newSeries) > 0)
    //         $this->addseries($newSeries);
    //     if (count($updatedSeries) > 0)
    //         $this->updateSerie($updatedSeries);
    // } 
    public function addNovedades(Request $request){
        $novedades = [];
        foreach ($request->input('serie.*') as $novedad){
            array_push($novedades,$novedad);
        }
        if (count($novedades) > 0)
            $this->addseries($novedades);
        echo "Añadidas " . count($novedades) . " series";
    }
    public function cambiosDia()
    {
        $query = "tv/changes&language=es-ES";
        $query = "tv/changes?start_date=2022-12-10&language=es-ES";
        $novedades = $this->getMovieApi($query);
        $updateSeries = [];
        foreach ($novedades['results'] as $resultado)
            if (Serie::find($resultado['id']) != null) {
                array_push($updateSeries, $resultado['id']);
            }
        // dd($updateSeries);
        if (count($updateSeries) > 0)
            $this->updateSerie($updateSeries);
    }
    /*
    cambios día manual
    */
    // public function cambiosDia()
    // {
    //     $updateSeries = [114410,105248,129959];
    //     if (count($updateSeries) > 0)
    //         $this->updateSerie($updateSeries);
    // }
    public function checkPopularity(){
        $series = Serie::orderBy('popularidad','desc')->paginate(30);
        $idSeries = [];
        foreach ($series as $serie){
            array_push($idSeries,$serie->id);
        }
        $this->updateSerie($idSeries);
    }
    /*
    * Dado un array de ids añade las películas
    */
    public function addseries($idSeries)
    {
        foreach ($idSeries as $key => $idSerie) {
            // verificar que la serie no está añadida
            $serie = Serie::find($idSerie);
            if (!$serie) {
                try {
                    $datosSerie = $this->getMovieApi("tv/" . $idSerie . "?language=es-ES");
                    $serie['id'] = (isset($datosSerie['id'])) ? $datosSerie['id'] : null;
                    $serie['titulo'] = (isset($datosSerie['name'])) ? $datosSerie['name'] : null;
                    $serie['nota'] = (isset($datosSerie['vote_average'])) ? $datosSerie['vote_average'] : null;
                    $serie['descripcion'] = (isset($datosSerie['overview'])) ? $datosSerie['overview'] : null;
                    $serie['imagen'] = (isset($datosSerie['poster_path'])) ? $datosSerie['poster_path'] : null;
                    $serie['numero_votos'] = (isset($datosSerie['vote_count'])) ? $datosSerie['vote_count'] : null;
                    $serie['titulo_original'] = (isset($datosSerie['original_name'])) ? $datosSerie['original_name'] : null;
                    $serie['fecha'] = (isset($datosSerie['first_air_date']) && $datosSerie['first_air_date'] != '') ? $datosSerie['first_air_date'] : null;
                    $serie['tagline'] = (isset($datosSerie['tagline'])) ? $datosSerie['tagline'] : null;
                    $serie['numero_episodios'] = (isset($datosSerie['number_of_episodes'])) ? $datosSerie['number_of_episodes'] : null;
                    $serie['numero_temporadas'] = (isset($datosSerie['number_of_seasons'])) ? $datosSerie['number_of_seasons'] : null;
                    $serie['en_produccion'] = (isset($datosSerie['in_production'])) ? $datosSerie['in_production'] : null;
                    $serie['fecha_ultimo'] = (isset($datosSerie['last_air_date'])) ? $datosSerie['last_air_date'] : null;
                    $serie['popularidad'] = (isset($datosSerie['popularity'])) ? $datosSerie['popularity'] : null;
                    $serie['idioma'] = (isset($datosSerie['original_language'])) ? $datosSerie['original_language'] : null;
                    $serie['imagen_principal'] = (isset($datosSerie['backdrop_path'])) ? $datosSerie['backdrop_path'] : null;
                    if (count($datosSerie['networks']) > 0)
                        $serie['canal'] = $datosSerie['networks'][0]['name'];
                    if (count($datosSerie['episode_run_time']) > 0)
                        $serie['duracion'] = $datosSerie['episode_run_time'][0];
                    $serie['slug'] = Str::slug($serie['titulo'] . '-' . $serie['id']);
                    $serie['year'] = (isset($serie['fecha'])) ? substr($serie['fecha'], 0, 4) : null;
                    if (count($datosSerie['networks']) > 0)
                        $serie['canal'] = $datosSerie['networks'][0]['name'];
                    if (count($datosSerie['episode_run_time']) > 0)
                        $serie['duracion'] = $datosSerie['episode_run_time'][0];
                    $serie['slug'] = Str::slug($serie['titulo'] . '-' . $serie['id']);
                    $serie['year'] = substr($serie['fecha'], 0, 4);
                    echo "nuevo -> " . $serie['titulo']  . "<br><hr>";
                    $objserie = Serie::create($serie);
                    $providerPelicula = $this->getMovieApi("tv/" . $idSerie . "/watch/providers");
                    if (array_key_exists('ES',$providerPelicula['results']) && array_key_exists('flatrate',$providerPelicula['results']['ES']))
                        foreach( $providerPelicula['results']['ES']['flatrate'] as $provider ){
                            $objserie->providers()->attach($provider['provider_id']);
                        }
                    if (isset($datosSerie['genres']))
                        foreach ($datosSerie['genres'] as $datoSerie) {
                            $objserie->generos()->attach($datoSerie['id']);
                        }
                    echo "Añadido -> " . $serie['titulo'] . '<img src=" https://image.tmdb.org/t/p/original' . $serie['imagen'] . '" width="300"><br><img src=" https://image.tmdb.org/t/p/original' . $serie['imagen_principal'] . '" width="300"><br><hr><br>';
                    Log::info("Añadida serie -> " . $serie['titulo'] . ' -> ' . $serie['id']);
                    $this->guardarImagen($serie['imagen'], 'serie');
                    $this->guardarImagen($serie['imagen_principal'], 'principal-serie');
                    $this->addTemporada($objserie, $datosSerie['seasons']);
                    $this->addImagenSeries($serie['id']);
                    $this->addCrew($objserie);
                    foreach ($datosSerie['created_by'] as $created_by) {
                        $creador = Persona::find($created_by['id']);
                        if (!$creador) {
                            $creador = $this->getPersona($created_by['id'], true);
                            Persona::create($creador);
                            echo "Añadido creador-> " . $creador['nombre'] . '<img src=" https://image.tmdb.org/t/p/original' . $creador['foto'] . '" width="300"><br><hr><br>';
                            $this->guardarImagen($creador['foto'], 'creador');
                        }
                        $objserie->creadores()->attach($created_by['id']);
                    }
                } catch (\Throwable $th) {
                    dd($key, $idSerie, $datosSerie, $th);
                    dd($key . '=>' . $idSerie . '<br>' . $th . '<hr>');
                    dd($key . '=>' . $idSerie . '<br>' . $th . '<hr>');
                }
            }
        }
    }
    public function updateSerie($idSeries)
    {
        // $idSeries = ['205442'];
        foreach ($idSeries as $key => $idSerie) {
            $serie = [];
                try {
                    $datosSerie = $this->getMovieApi("tv/" . $idSerie . "?language=es-ES");
                    $serie['nota'] = (isset($datosSerie['vote_average'])) ? $datosSerie['vote_average'] : null;
                    $serie['numero_votos'] = (isset($datosSerie['vote_count'])) ? $datosSerie['vote_count'] : null;
                    $serie['numero_episodios'] = (isset($datosSerie['number_of_episodes'])) ? $datosSerie['number_of_episodes'] : null;
                    $serie['numero_temporadas'] = (isset($datosSerie['number_of_seasons'])) ? $datosSerie['number_of_seasons'] : null;
                    $serie['en_produccion'] = (isset($datosSerie['in_production'])) ? $datosSerie['in_production'] : null;
                    $serie['fecha_ultimo'] = (isset($datosSerie['last_air_date'])) ? $datosSerie['last_air_date'] : null;
                    $serie['popularidad'] = (isset($datosSerie['popularity'])) ? $datosSerie['popularity'] : null;
                    $objserie = Serie::find($idSerie);
                    $objserie->update($serie);
                    $objserie->providers()->detach();
                    $providerPelicula = $this->getMovieApi("tv/" . $idSerie . "/watch/providers");
                    if (array_key_exists('ES',$providerPelicula['results']) && array_key_exists('flatrate',$providerPelicula['results']['ES']))
                        foreach( $providerPelicula['results']['ES']['flatrate'] as $provider ){
                            $objserie->providers()->attach($provider['provider_id']);
                        }
                    echo "Actualizado -> " . $datosSerie['name'] . '"><br>';
                    Log::info("Actualizada serie -> " . $datosSerie['name'] . ' -> ' . $datosSerie['id']);
                    $this->updateTemporada($objserie, $datosSerie['seasons']);
                    $this->updateCrew($objserie);
                    
                    echo 'Fin <hr><br>';
                } catch (\Throwable $th) {
                    dd($idSerie, $objserie, $serie, $th);
                }

        }
    }
    public function addCrew($serie)
    {
        $crews = $this->getMovieApi("tv/" . $serie->id . "/credits?language=es-ES");
        //actores
        //si popularidad por debajo de 50 solo 10 actores, si no 15
        ($serie->popularidad > 49) ? $popular = 15 : $popular = 10;
        for ($i = 0; $i < $popular; $i++) {
            if (count($crews['cast']) > $i && $crews['cast'][$i]) {
                $newPersona = Persona::find($crews['cast'][$i]['id']);
                if (!$newPersona) {
                    $newPersona = $this->getPersona($crews['cast'][$i]['id'], true);
                    Persona::create($newPersona);
                    echo "Añadido Actor-> " . $newPersona['nombre'] . '<img src=" https://image.tmdb.org/t/p/original' . $newPersona['foto'] . '"><br><hr><br>';
                    $this->guardarImagen($newPersona['foto'], 'actor');
                }
                $serie->actores()->attach($crews['cast'][$i]['id'], ['personaje' => $crews['cast'][$i]['character'], 'orden' => $crews['cast'][$i]['order']]);
            }
        }
    }
    public function updateCrew($serie)
    {
        $crews = $this->getMovieApi("tv/" . $serie->id . "/credits?language=es-ES");
        //actores
        //si popularidad por debajo de 50 solo 10 actores, si no 15
        ($serie->popularidad > 49) ? $popular = 15 : $popular = 10;
        for ($i = 0; $i < $popular; $i++) {
            try {
                if (count($crews['cast']) > $i && $crews['cast'][$i]) {
                    $newPersona = Persona::find($crews['cast'][$i]['id']);
                    if (!$newPersona) {
                        $newPersona = $this->getPersona($crews['cast'][$i]['id'], true);
                        Persona::create($newPersona);
                        echo "Añadido Actor-> " . $newPersona['nombre'] . '<img src=" https://image.tmdb.org/t/p/original' . $newPersona['foto'] . '"><br>';
                        $this->guardarImagen($newPersona['foto'], 'actor');
                    };
                    if ($serie->actores->contains($crews['cast'][$i]['id']) == null ){
                        echo 'Añadida relacion actor/serie -> ' . $crews['cast'][$i]['id'] . ' --> ' . $serie->id . '<br>';
                        $serie->actores()->attach($crews['cast'][$i]['id'], ['personaje' => $crews['cast'][$i]['character'], 'orden' => $crews['cast'][$i]['order']]);
                    }
                }
            } catch (\Throwable $th) {
                dd($th);
            }
        }
    }
    public function getPersona($id, $addImage)
    {
        $persona = $this->getMovieApi("person/" . $id . "?language=es-ES");
        if (isset($persona['id'])) {
            $newPersona = [
                'id' => $persona['id'],
                'nombre' => $persona['name'],
                'slug' => Str::slug($persona['name']) . '-' . $persona['id'],
                'popularidad' => $persona['popularity'],
                'descripcion' => $persona['biography'],
                'genero' => $persona['gender'],
            ];
            if ($addImage) {
                $newPersona['foto'] = $persona['profile_path'];
            }
            if ($persona['birthday'] != null) {
                $newPersona['fecha_1'] = $persona['birthday'];
                $newPersona['year_1'] = substr($persona['birthday'], 0, 4);
            }
            if ($persona['deathday'] != null) {
                $newPersona['fecha_2'] = $persona['deathday'];
                $newPersona['year_2'] = substr($persona['deathday'], 0, 4);
            }
            return $newPersona;
        } else {
            echo '<h3>Error al intentar añadir persona:</h3>';
            dd($persona);
        }
    }
    public function addTemporada(Serie $serie, $arrayTemps)
    {
        foreach ($arrayTemps as $arrayTemp) {
            $temporada = [
                'id' => $arrayTemp['id'],
                'titulo' => $arrayTemp['name'],
                'numero' => $arrayTemp['season_number'],
                'episodios' => $arrayTemp['episode_count'],
                'fecha' => $arrayTemp['air_date'],
                'imagen' => $arrayTemp['poster_path']
            ];
            $temporada['slug'] = $serie->slug . '-' . $temporada['numero'];
            $temporada['serie_id'] = $serie->id;
            Temporada::create($temporada);
            $this->guardarImagen($temporada['imagen'], 'serie-temporada');
        }
    }
    public function updateTemporada(Serie $serie, $arrayTemps)
    {
        foreach ($arrayTemps as $arrayTemp) {
            try{
                $existeTemp = Temporada::find($arrayTemp['id']);
                if(!$existeTemp){
                    $temporada = [
                        'id' => $arrayTemp['id'],
                        'titulo' => $arrayTemp['name'],
                        'numero' => $arrayTemp['season_number'],
                        'episodios' => $arrayTemp['episode_count'],
                        'fecha' => $arrayTemp['air_date'],
                        'imagen' => $arrayTemp['poster_path']
                    ];
                    $temporada['slug'] = $serie->slug . '-' . $temporada['numero'];
                    $temporada['serie_id'] = $serie->id;                    
                    echo "Nueva temp -> " . $arrayTemp['name'] . '"><br>';
                    Temporada::create($temporada);
                    $this->guardarImagen($temporada['imagen'], 'serie-temporada');
                }
            } catch (\Throwable $th) {
                dd( $th);
            }
        }
    }
    public function addImagenSeries ($idSerie){
        try {
            $datosserie = $this->getMovieApi("tv/" . $idSerie . "/images");
            $cont = 1;
            if(isset ($datosserie['backdrops']))
                foreach ($datosserie['backdrops'] as $imagen){
                    echo '<img src="https://image.tmdb.org/t/p/original/'. $imagen['file_path'] . '" width="300"<br>>';
                    ImagenSerie::create(['serie_id' => $idSerie, 'imagen' => $imagen['file_path']]); 
                    if ($cont == 6) break;
                    $cont++;              
                }
        } catch (\Throwable $th) {
            dd($th);
        }  
    }
    public function updateSeriesImg (){
        $seriesSinImagen = Serie::where('year','>','2020')->doesntHave('imagenes')->get();
        foreach ($seriesSinImagen as $serieSinImagen){
            try {
                $datosserie = $this->getMovieApi("tv/" . $serieSinImagen->id . "/images");
                $imagenes = [];
                $cont = 1;
                if(isset ($datosserie['backdrops']))
                    foreach ($datosserie['backdrops'] as $imagen){
                        echo '<img src="https://image.tmdb.org/t/p/original/'. $imagen['file_path'] . '">';
                        ImagenSerie::create(['serie_id' => $serieSinImagen->id, 'imagen' => $imagen['file_path']]); 
                        if ($cont == 6) break;
                        $cont++;              
                    }
            } catch (\Throwable $th) {
                dd($th);
            }  
        }
        dd($seriesSinImagen);
    }
}
