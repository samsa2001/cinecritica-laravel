<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use App\Models\Serie;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Provider;
use App\Models\Temporada;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UtilsController extends Controller
{
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
    public function traspasarTabla()
    {
        $relaciones = DB::select('select * from pelicula_persona');
        foreach ($relaciones as $relacion) {
            try {
                DB::insert('insert into pelicula_persona2 (pelicula_id, persona_id, role, personaje, orden) values (?, ? ,?, ?, ?)', [$relacion->pelicula_id, $relacion->persona_id, $relacion->role, $relacion->personaje, $relacion->orden]);
            } catch (\Throwable $th) {
                echo $th;
            }
        }
    }
    public function traspasarTablaPersonas()
    {
        $relaciones = DB::select('select * from pelicula_persona  LIMIT 160000,40000');
        foreach ($relaciones as $relacion) {
            // dd($relacion);
            // try {
                if ($relacion->role == 'Actor' || $relacion->role == 'actor')
                    DB::insert('insert into pelicula_actor (pelicula_id, persona_id,  personaje, orden) values (?, ? ,? , ?)', [$relacion->pelicula_id, $relacion->persona_id, $relacion->personaje, $relacion->orden]);
                elseif ($relacion->role == 'Director' || $relacion->role == 'director')
                    DB::insert('insert into pelicula_director (pelicula_id, persona_id) values (?, ?)', [$relacion->pelicula_id, $relacion->persona_id]);
                else 
                    DB::insert('insert into pelicula_guionista (pelicula_id, persona_id, role) values (?, ? ,?)', [$relacion->pelicula_id, $relacion->persona_id, $relacion->role]);
            // } catch (\Throwable $th) {
            //     echo $th;
            // }
        }
        echo 'terminado';
    }
    public function traspasarTablaPersonasSerie()
    {
        $relaciones = DB::select('select * from serie_persona  LIMIT 40000');
        foreach ($relaciones as $relacion) {
            // dd($relacion);
            // try {
                if ($relacion->role == 'Actor' || $relacion->role == 'actor')
                    DB::insert('insert into serie_actor (serie_id, persona_id,  personaje, orden) values (?, ? ,? , ?)', [$relacion->serie_id, $relacion->persona_id, $relacion->personaje, $relacion->orden]);
                elseif ($relacion->role == 'Creador' || $relacion->role == 'creador')
                    DB::insert('insert into serie_creador (serie_id, persona_id) values (?, ?)', [$relacion->serie_id, $relacion->persona_id]);
            // } catch (\Throwable $th) {
            //     echo $th;
            // }
        }
        echo 'terminado';
    }
    public function prueba5()
    {
        $series = DB::select('select * from ramon_peliculas_series');
        $idSeries = array();
        foreach ($series as $serie) {
            if (!Serie::find($serie->id)) {
                $idSeries[] = $serie->id;
            }
        }
        // $this->addseries(array_slice($idSeries, 0, 500));
        // dd($idSeries);
        $this->addseries($idSeries);
    }
    public function prueba4(Request $request)
    {
        $series = '';
        if (isset($request)) {
            if (isset($request['year']) && $request['year'] < 2023 && $request['year'] > 1900) {
                $series = Serie::where('year', $request['year'])->paginate();
            }
        } else
            $series = Serie::paginate(10);
        return view('backend.series.index', compact('series'));
    }
    public function guardarImagen($url, $rol)
    {
        $path = "https://image.tmdb.org/t/p/original" . $url;
        if (isset($url))
            try {
                $contents = file_get_contents($path);
                if ($rol == 'actor') {
                    $rol = 'personas';
                } elseif ($rol == 'director') {
                    $rol = 'personas';
                } elseif ($rol == 'creador') {
                    $rol = 'personas';
                } elseif ($rol == 'principal') {
                    $rol = 'imagen-principal';
                } elseif ($rol == 'principal-serie') {
                    $rol = 'imagen-principal-series';
                } elseif ($rol == 'serie-temporada') {
                    $rol = "temporadas";
                } elseif ($rol == 'serie') {
                    $rol = 'series';
                } elseif ($rol == 'plataforma') {
                    $rol = 'plataformas';
                } else {
                    $rol = 'peliculas'; 
                }
                $name = 'media/' . $rol . $url;
                Storage::put($name, $contents);
            } catch (\Throwable $th) {
                echo $th;
            }
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
                    // dd($datosSerie);
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
                    $objserie = Serie::create($serie);
                    if (isset($datosSerie['genres']))
                        foreach ($datosSerie['genres'] as $datoSerie) {
                            $objserie->generos()->attach($datoSerie['id']);
                        }
                    echo "Añadido -> " . $serie['titulo'] . '<img src=" https://image.tmdb.org/t/p/original' . $serie['imagen'] . '"><br><img src=" https://image.tmdb.org/t/p/original' . $serie['imagen_principal'] . '"><br><hr><br>';
                    $this->guardarImagen($serie['imagen'], 'serie');
                    $this->guardarImagen($serie['imagen_principal'], 'principal-serie');
                    $this->addTemporada($objserie, $datosSerie['seasons']);
                    $this->addCrew($objserie);
                    foreach ($datosSerie['created_by'] as $created_by) {
                        $creador = Persona::find($created_by['id']);
                        if (!$creador) {
                            $creador = $this->getPersona($created_by['id'], true);
                            Persona::create($creador);
                            echo "Añadido creador-> " . $creador['nombre'] . '<img src=" https://image.tmdb.org/t/p/original' . $creador['foto'] . '"><br><hr><br>';
                            $this->guardarImagen($creador['foto'], 'creador');
                        }
                        $objserie->creadores()->attach($created_by['id'], ['role' => 'creador']);
                    }
                } catch (\Throwable $th) {
                    dd($key, $idSerie, $datosSerie, $th);
                    dd($key . '=>' . $idSerie . '<br>' . $th . '<hr>');
                    dd($key . '=>' . $idSerie . '<br>' . $th . '<hr>');
                }
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
                $serie->actores()->attach($crews['cast'][$i]['id'], ['role' => 'actor', 'personaje' => $crews['cast'][$i]['character'], 'orden' => $crews['cast'][$i]['order']]);
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
                'slug' => Str::slug($persona['name']),
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
    
    public function updatePersonas(){
        $personas = $this->getMovieApi('person/changes?start_date=2021-09-21');
        $cont = 0;
        foreach( $personas['results'] as $persona ){
        //  dd($personas, $persona);
            $noNewPersona = Persona::find($persona['id']);
            if($noNewPersona ){
                $popular = $this->getMovieApi('person/'.$persona['id']);
                // dd($noNewPersona->nombre, $noNewPersona->popularidad , $popular['popularity']);
                $cont++;
                $update =[];
                if (isset($popular['popularity'])){
                    $update['popularidad'] = $popular['popularity'];
                }
                if (isset($popular['deathday'])){
                    $update['fecha_2'] = $popular['deathday'];
                    $update['year_2'] = substr($popular['deathday'], 0, 4);
                }
                if(isset($update) && (isset($popular['popularity']) || isset($popular['deathday'])) ){             
                    echo $cont . '-' . $popular['id'] . '-' .$noNewPersona->popularidad. '-' .$popular['popularity']. '<br><hr>';
                    $noNewPersona->update($update);   
                }
            }
        }
    }
    public function cambiosDia(){
        $personas = $this->getMovieApi('person/changes?start_date=2020-12-25&language=es-ES');
        $cont = 0;
        foreach( $personas['results'] as $persona ){
        //  dd($personas, $persona);
            $noNewPersona = Persona::find($persona['id']);
            if($noNewPersona ){
                $popular = $this->getMovieApi('person/'.$persona['id']);
                // dd($noNewPersona->nombre, $noNewPersona->popularidad , $popular['popularity']);
                $cont++;
                $update =[];
                if (isset($popular['popularity'])){
                    $update['popularidad'] = $popular['popularity'];
                }
                if (isset($popular['deathday'])){
                    $update['fecha_2'] = $popular['deathday'];
                    $update['year_2'] = substr($popular['deathday'], 0, 4);
                }
                if(isset($update) && (isset($popular['popularity']) || isset($popular['deathday']))) {   
                    echo $cont . '-' . $popular['id'] . '- Old:' .$noNewPersona->popularidad. '- New:' .$popular['popularity']. '<br><hr>';          
                    $noNewPersona->update($update);   
                    Log::info("Actualizada persona -> " . $noNewPersona->nombre . ' -> ' . $noNewPersona->id);
                }
            }
        }
    }
    public function sitemapPeliculas(){
        $peliculas = Pelicula::paginate(1000);
        return view('sitemap.peliculas', compact('peliculas'));

    }
    public function sitemapSeries(){
        $series = Serie::paginate(1000);
        return view('sitemap.series', compact('series')); 

    }
    public function sitemapPersonas(){
        $personas = Persona::paginate(1000);
        return view('sitemap.personas', compact('personas'));

    }
    public function addProviders(){
        $providersPeliculas = $this->getMovieApi("/watch/providers/movie");
        $provider = [];
        foreach ( $providersPeliculas['results'] as $newProvider){
            if (Provider::find($newProvider['provider_id']) == null) {
                $provider['id'] = $newProvider['provider_id'];
                $provider['nombre'] = $newProvider['provider_name'];
                $provider['prioridad'] = $newProvider['display_priority'];
                $provider['logo'] = $newProvider['logo_path'];
                Provider::create($provider);
                $this->guardarImagen($newProvider['logo_path'],'plataforma');
                print_r($provider);
                echo '<hr>';
            }
        }
        $providersPeliculas = $this->getMovieApi("/watch/providers/tv");
        $provider = [];
        foreach ( $providersPeliculas['results'] as $newProvider){
            if (Provider::find($newProvider['provider_id']) == null) {
                $provider['id'] = $newProvider['provider_id'];
                $provider['nombre'] = $newProvider['provider_name'];
                $provider['prioridad'] = $newProvider['display_priority'];
                $provider['logo'] = $newProvider['logo_path'];
                Provider::create($provider);
                $this->guardarImagen($newProvider['logo_path'],'plataforma');
            }
            print_r($provider);
            echo '<hr>';
        }
        echo 'Fin';
    }
}
