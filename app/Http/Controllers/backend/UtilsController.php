<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Temporada;
use Illuminate\Support\Facades\DB;
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
}
