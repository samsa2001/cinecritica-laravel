<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ImagenPelicula;
use Illuminate\Http\Request;
use App\Models\Pelicula;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $peliculas = Pelicula::orderBy('popularidad','desc')->paginate(10);
        $peliculas = Pelicula::orderBy('fecha', 'desc')->with('actores', 'directores', 'guionistas', 'escritores', 'generos')->paginate(10);
        return view('backend.peliculas.index', compact('peliculas'));
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
        $pelicula = Pelicula::find($id);
        return view('backend.peliculas.show', compact('pelicula'));
    }
    public function showSlug($slug)
    {
        $pelicula = Pelicula::where('slug', $slug)->firstOrFail();
        $pelicula->actores;
        return view('backend.peliculas.show', compact('pelicula'));
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
    public function verNovedades()
    {
        $query = "discover/movie?language=es-ES&primary_release_date.lte=2019-08-05&sort_by=popularity.desc&vote_count.gte=500&page=";
        $query = "discover/movie?language=es-ES&primary_release_date.gte=2023-01-01&sort_by=popularity.desc&vote_count.gte=10&page=";
        $query = "discover/movie?language=es-ES&primary_release_date.gte=2023-01-01&region=ES&sort_by=popularity.desc&vote_count.gte=1&with_original_language=es&page=";
        // $query = "discover/movie?language=es-ES&sort_by=popularity.desc&with_people=13918&page=";
        //$query = "discover/movie?primary_release_year=2009&sort_by=popularity.desc&vote_count.gte=50&with_original_language=es&page=";
        $novedades = $this->getMovieApi($query . "1");
        $newPeliculas = [];
        $updatePeliculas = [];
        $datosPelicula = [];
        for ($i = 1; $i <= $novedades["total_pages"]; $i++) {
            $novedades = $this->getMovieApi($query . $i);
            foreach ($novedades['results'] as $resultado)
                if (Pelicula::find($resultado['id']) != null) {
                    array_push($updatePeliculas, $resultado['id']);
                } else {
                //     array_push($newPeliculas, $resultado['id']);
                    $datosPelicula = $this->getMovieApi("movie/" . $resultado['id'] . "?language=es-ES");
                    array_push($newPeliculas, $datosPelicula);
                    // echo "Novedad -> " . $datosPelicula['title'] 
                    // . '<img src=" https://image.tmdb.org/t/p/original' . $datosPelicula['poster_path'] . '" width="300" style="display:inline-block">  
                    // <input type="checkbox" name="novedad' . $resultado['id'] . '" value="'. $resultado['id'] .'"><strong>'. $resultado['id'] .'</strong><span style="margin: 1rem 3rem"> | </span> ';
                }
        }      
        return view('backend.peliculas.novedades', ['peliculas' => $newPeliculas]);
    }


    // public function addNovedades()
    // {
    //     $query = "discover/movie?language=es-ES&primary_release_date.gte=2022-08-21&vote_count.gte=150&page=";
    //     // $query = "discover/movie?primary_release_date.gte=2021-12-21&sort_by=popularity.desc&vote_count.gte=50&with_original_language=es&page=";
    //     $novedades = $this->getMovieApi($query . "1");
    //     $newPeliculas = [];
    //     $updatePeliculas = [];
    //     for ($i = 1; $i <= $novedades["total_pages"]; $i++) {
    //         $novedades = $this->getMovieApi($query . $i);
    //         foreach ($novedades['results'] as $resultado)
    //             if (Pelicula::find($resultado['id']) != null) {
    //                 array_push($updatePeliculas, $resultado['id']);
    //             } else {
    //                 array_push($newPeliculas, $resultado['id']);
    //             }
    //     }
    //     // dd($newPeliculas, $updatePeliculas);
    //     if (count($newPeliculas) > 0)
    //         $this->addPeliculas($newPeliculas);
    //     if (count($updatePeliculas) > 0)
    //         $this->updatePeliculas($updatePeliculas);
    // }
    public function addNovedades(Request $request)
    {
        $novedades = [];
        foreach ($request->input('peli.*') as $novedad){
            array_push($novedades,$novedad);
        }
        if (count($novedades) > 0)
            $this->addPeliculas($novedades);
        echo "Añadidas " . count($novedades) . " películas";
    }
    public function cambiosDia()
    {
        $query = "movie/changes";
        // $query = "movie/changes?start_date=2022-12-10&language=es-ES";
        $novedades = $this->getMovieApi($query);
        $updatePeliculas = [];
        foreach ($novedades['results'] as $resultado)
            if (Pelicula::find($resultado['id']) != null) {
                array_push($updatePeliculas, $resultado['id']);
            }
        // dd($updatePeliculas);
        if (count($updatePeliculas) > 0)
            $this->updatePeliculas($updatePeliculas);
    }
    /*
    Cambio manual
    */
    // public function cambiosDia()
    // {
    //     $updatePeliculas = [610150,438631,550988,766507,507086];
    //     if (count($updatePeliculas) > 0)
    //         $this->updatePeliculas($updatePeliculas);
    // }
    public function prueba5()
    {
        dd('Descargar imagenes de todas las pelis');
        $peliculas=Pelicula::get();
        foreach ($peliculas as $pelicula){
            $datosPelicula = $this->getMovieApi("movie/" . $pelicula->id . "?language=es-ES");
            if( isset($datosPelicula['poster_path']) ) {
                $this->guardarImagen($datosPelicula['poster_path'], 'peliculas');
                echo "Añadido -> " . $pelicula->id . ' --> <img src=" https://image.tmdb.org/t/p/original' . $datosPelicula['poster_path'] . '" width="300"><br><hr><br>';
            }
        }
        dd('Fin');
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
                } elseif ($rol == 'principal') {
                    $rol = 'imagen-principal';
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
    public function addPeliculas($idPeliculas)
    {
        foreach ($idPeliculas as $key => $idPelicula) {
            // verificar que la pelicula no está añadida
            $pelicula = Pelicula::find($idPelicula);
            if (!$pelicula) {
                try {
                    $datosPelicula = $this->getMovieApi("movie/" . $idPelicula . "?language=es-ES");
                    $pelicula = [
                        'id' => $datosPelicula['id'],
                        'titulo' => $datosPelicula['title'],
                        'nota' => $datosPelicula['vote_average'],
                        'descripcion' => $datosPelicula['overview'],
                        'imagen' => $datosPelicula['poster_path'],
                        'numero_votos' => $datosPelicula['vote_count'],
                        'titulo_original' => $datosPelicula['original_title'],
                        'presupuesto' => $datosPelicula['budget'],
                        'recaudacion' => $datosPelicula['revenue'],
                        'fecha' => $datosPelicula['release_date'],
                        'imdb_id' => $datosPelicula['imdb_id'],
                        'duracion' => $datosPelicula['runtime'],
                        'tagline' => $datosPelicula['tagline'],
                        'popularidad' => $datosPelicula['popularity'],
                        'video' => $datosPelicula['video'],
                        'idioma' => $datosPelicula['original_language'],
                        'imagen_principal' => $datosPelicula['backdrop_path']
                    ];
                    if (count($datosPelicula['production_companies']) > 1)
                        $pelicula['productora'] = $datosPelicula['production_companies'][0]['name'];
                    $pelicula['slug'] = Str::slug($pelicula['titulo'] . '-' . $pelicula['id']);
                    $pelicula['year'] = substr($pelicula['fecha'], 0, 4);
                    $objPelicula = Pelicula::create($pelicula);
                    if (isset($datosPelicula['genres']))
                        foreach ($datosPelicula['genres'] as $datoPelicula) {
                            $objPelicula->generos()->attach($datoPelicula['id']);
                        }
                    echo "Añadido -> " . $pelicula['titulo'] . '<img src=" https://image.tmdb.org/t/p/original' . $pelicula['imagen'] . '" width="300"><br><img src=" https://image.tmdb.org/t/p/original' . $pelicula['imagen_principal'] . '" width="300"><br><hr><br>';
                    Log::info("Añadido -> " . $pelicula['titulo'] . ' -> ' . $pelicula['id']);
                    $this->guardarImagen($pelicula['imagen'], 'pelicula');
                    $this->guardarImagen($pelicula['imagen_principal'], 'principal');
                    $this->addCrew($objPelicula);
                    $this->addImagenesPeliculas($objPelicula->id);
                    // Add providers
                    $providerPelicula = $this->getMovieApi("movie/" . $idPelicula . "/watch/providers");  
                    if (array_key_exists('ES',$providerPelicula['results']) && array_key_exists('flatrate',$providerPelicula['results']['ES'])){                  
                        foreach( $providerPelicula['results']['ES']['flatrate'] as $provider ){
                            $objPelicula->providers()->attach($provider['provider_id']);
                        }
                    }
                } catch (\Throwable $th) {
                    dd($key, $idPelicula, $datosPelicula, $th);
                    dd($key . '=>' . $idPelicula . '<br>' . $th . '<hr>');
                    dd($key . '=>' . $idPelicula . '<br>' . $th . '<hr>');
                }
            }
        }
    }
    public function checkPopularity(){
        $peliculas = Pelicula::orderBy('popularidad','desc')->paginate(30);
        $idPeliculas = [];
        foreach ($peliculas as $pelicula){
            array_push($idPeliculas,$pelicula->id);
        }
        $this->updatePeliculas($idPeliculas);
    }
    public function updatePeliculas($idPeliculas)
    {
        foreach ($idPeliculas as $key => $idPelicula) {
            // verificar que la pelicula no está añadida
            $pelicula = [];
            try {
                $datosPelicula = $this->getMovieApi("movie/" . $idPelicula . "?language=es-ES");
                $pelicula = [
                    'nota' => $datosPelicula['vote_average'],
                    'numero_votos' => $datosPelicula['vote_count'],
                    'presupuesto' => $datosPelicula['budget'],
                    'recaudacion' => $datosPelicula['revenue'],
                    'popularidad' => $datosPelicula['popularity']
                ];
                $objPelicula = Pelicula::find($idPelicula);
                $objPelicula->update($pelicula);
                $objPelicula->providers()->detach();
                $providerPelicula = $this->getMovieApi("movie/" . $idPelicula . "/watch/providers");
                if (array_key_exists('ES',$providerPelicula['results']) && array_key_exists('flatrate',$providerPelicula['results']['ES']))
                    foreach( $providerPelicula['results']['ES']['flatrate'] as $provider ){
                        $objPelicula->providers()->attach($provider['provider_id']);
                    }
                echo 'Pelicula actualizada -> ' . $objPelicula->slug . '<hr><br>';
                Log::info("Actualizada pelicula -> " . $objPelicula->titulo . ' -> ' . $objPelicula->id);
            } catch (\Throwable $th) {
                dd($objPelicula->id,$th);
            }
        }
    }
    public function addCrew($pelicula)
    {
        $crews = $this->getMovieApi("movie/" . $pelicula->id . "/credits?language=es-ES");
        //actores
        //si popularidad por debajo de 50 solo 10 actores, si no 15
        ($pelicula->popularidad > 49) ? $popular = 15 : $popular = 10;
        for ($i = 0; $i < $popular; $i++) {
            if (count($crews['cast']) > $i && $crews['cast'][$i]) {
                $newPersona = Persona::find($crews['cast'][$i]['id']);
                if (!$newPersona) {
                    $newPersona = $this->getPersona($crews['cast'][$i]['id'], true);
                    Persona::create($newPersona);
                    echo "Añadido Actor-> " . $newPersona['nombre'] . '<img src=" https://image.tmdb.org/t/p/original' . $newPersona['foto'] . '" width="300"><br><hr><br>';
                    $this->guardarImagen($newPersona['foto'], 'actor');
                }
                $pelicula->actores()->attach($crews['cast'][$i]['id'], ['personaje' => $crews['cast'][$i]['character'], 'orden' => $crews['cast'][$i]['order']]);
            }
        }
        //directores, guionistas y escritores
        if (isset($crews['crew']))
            foreach ($crews['crew'] as $peliCrew) {
                if ($peliCrew['job'] == 'Director') {
                    $director = Persona::find($peliCrew['id']);
                    if (!$director) {
                        $director = $this->getPersona($peliCrew['id'], true);
                        Persona::create($director);
                        echo "Añadido director-> " . $director['nombre'] . '<img src=" https://image.tmdb.org/t/p/original' . $director['foto'] . '" width="300"><br><hr><br>';
                        $this->guardarImagen($newPersona['foto'], 'director');
                    }
                    $pelicula->directores()->attach($peliCrew['id']);
                }
                if ($peliCrew['job'] == 'Screenplay') {
                    $guionista = Persona::find($peliCrew['id']);
                    if (!$guionista) {
                        $guionista = $this->getPersona($peliCrew['id'], false);
                        Persona::create($guionista);
                    }
                    $pelicula->guionistas()->attach($peliCrew['id'], ['role' => 'guionista']);
                }
                if ($peliCrew['job'] == 'Writer') {
                    $escritor = Persona::find($peliCrew['id']);
                    if (!$escritor) {
                        $escritor = $this->getPersona($peliCrew['id'], false);
                        Persona::create($escritor);
                    }
                    $pelicula->escritores()->attach($peliCrew['id'], ['role' => 'escritor']);
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
    public function addImagenesPeliculas($idPelicula)
    {       
            try {
                $datosPelicula = $this->getMovieApi("movie/" . $idPelicula . "/images");
                $imagenes = [];
                $cont = 1;
                foreach ($datosPelicula['backdrops'] as $imagen) {
                    echo '<img src="https://image.tmdb.org/t/p/original/' . $imagen['file_path'] . '" width="300"><br>';
                    ImagenPelicula::create(['pelicula_id' => $idPelicula, 'imagen' => $imagen['file_path']]);
                    if ($cont == 6) break;
                    $cont++;
                }
            } catch (\Throwable $th) {
                dd($th);
            }
    }
}
