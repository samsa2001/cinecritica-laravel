<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelicula;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
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
        $peliculas = Pelicula::orderBy('fecha','desc')->with('actores','directores','guionistas','escritores','generos')->paginate(10);
        return view('backend.peliculas.index',compact('peliculas'));
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
        return view('backend.peliculas.show',compact('pelicula'));
    }
    public function showSlug($slug)
    {
        $pelicula = Pelicula::where('slug',$slug)->firstOrFail();
        $pelicula->actores;
        return view('backend.peliculas.show',compact('pelicula'));
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
    
    public function getMovieApi($pregunta){
        $authorization = "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2NDQwMDlmMWM5YWY1YzZlYTkzNTBjZjVlZDU1YTA4YSIsInN1YiI6IjYwYWZiOTcxNWIwNzE0MDAyOTY2YzFmOCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.b_bDJCgVUc9w1C5816Mm2alWfAqyYRF5Ss_pWmpvDgY";
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.themoviedb.org/3/". $pregunta ,
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
    public function verNovedades(){
        $query = "discover/movie?language=es-ES&primary_release_date.gte=2021-12-21&vote_count.gte=300&page=";
        $novedades = $this->getMovieApi($query . "1");
        $results = $novedades['results'];
        for ($i=2; $i <= $novedades["total_pages"]; $i++){
            $novedades = $this->getMovieApi($query . $i);
            foreach($novedades['results'] as $resultado)
                array_push($results,$resultado);
        }
        dd($results);
    }
    
    public function addNovedades(){
        $query = "discover/movie?language=es-ES&primary_release_date.gte=2022-09-21&vote_count.gte=300&page=";
        $novedades = $this->getMovieApi($query . "1");
        $idPeliculas = [];
        for ($i=1; $i <= $novedades["total_pages"]; $i++){
            $novedades = $this->getMovieApi($query . $i);
            foreach($novedades['results'] as $resultado)
                array_push($idPeliculas,$resultado['id']);
        }
        $this->addPeliculas($idPeliculas);
    }
    public function prueba5(){      
        $peliculas = DB::select('select * from ramon_peliculas_peliculas_genero');
        $idPeliculas = array();
        foreach ($peliculas as $pelicula){
            if (!Pelicula::find($pelicula->pelicula_id) && !array_search($pelicula->pelicula_id,$idPeliculas)){
                $idPeliculas[] = $pelicula->pelicula_id;
            }
        }
        dd($idPeliculas);
        // $this->addPeliculas(array_slice($idPeliculas, 0, 500));
        $this->addPeliculas($idPeliculas);
    }
    public function prueba4(Request $request){  
        $peliculas ='';  
        if(isset($request)){  
            if (isset($request['year']) && $request['year']<2023 && $request['year']>1900){
                $peliculas=Pelicula::where('year',$request['year'])->paginate();
            }
        }
        else
            $peliculas = Pelicula::paginate(10);
        return view('backend.peliculas.index',compact('peliculas'));
        
    }
    public function guardarImagen($url, $rol){
        $path="https://image.tmdb.org/t/p/original" . $url;
        if(isset($url))
            try {
                $contents = file_get_contents($path);
                if($rol == 'actor'){
                    $rol='actores';
                } elseif ($rol == 'director'){
                    $rol='directores';
                }elseif ($rol=='principal'){
                    $rol='imagenes_principales';
                } else {
                    $rol='peliculas';
                }
                $name = 'media/'.$rol . $url;
                Storage::put($name, $contents);
            } catch (\Throwable $th) {
                echo $th;
            }
    }
    /*
    * Dado un array de ids añade las películas
    */
    public function addPeliculas($idPeliculas){        
        foreach ($idPeliculas as $key=>$idPelicula){
            // verificar que la pelicula no está añadida
            $pelicula = Pelicula::find($idPelicula);
            if( !$pelicula ){
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
                    if( count($datosPelicula['production_companies'])>1 )
                        $pelicula['productora'] = $datosPelicula['production_companies'][0]['name'];
                    $pelicula['slug'] = Str::slug( $pelicula['titulo'].'-'.$pelicula['id']);
                    $pelicula['year'] = substr($pelicula['fecha'], 0, 4);
                    $objPelicula = Pelicula::create($pelicula);
                    // if(isset($datosPelicula['genres']))
                    //     foreach($datosPelicula['genres'] as $datoPelicula){
                    //             $objPelicula->generos()->attach($datoPelicula['id']);
                    //         }
                    echo "Añadido -> " . $pelicula['titulo'] . '<img src=" https://image.tmdb.org/t/p/original' . $pelicula['imagen'] . '"><br><img src=" https://image.tmdb.org/t/p/original' . $pelicula['imagen_principal'] . '"><br><hr><br>';
                    $this->guardarImagen($pelicula['imagen'],'pelicula');
                    $this->guardarImagen($pelicula['imagen_principal'],'principal');
                    $this->addCrew($objPelicula); 
                } catch (\Throwable $th) {
                    dd($key,$idPelicula,$datosPelicula, $th);
                    dd($key. '=>'.$idPelicula . '<br>' . $th . '<hr>');
                    dd($key. '=>'.$idPelicula . '<br>' . $th . '<hr>');
                }   
                
            }
        }
    }
    public function addCrew($pelicula){  
        $crews = $this->getMovieApi("movie/" . $pelicula->id . "/credits?language=es-ES");
        //actores
        //si popularidad por debajo de 50 solo 10 actores, si no 15
        ($pelicula->popularidad > 49)? $popular=15 : $popular=10;
        for( $i=0; $i< $popular; $i++){
            if ( count($crews['cast'])>$i && $crews['cast'][$i]) {
                    $newPersona = Persona::find($crews['cast'][$i]['id']);
                    if(!$newPersona){
                        $newPersona = $this->getPersona($crews['cast'][$i]['id'], true);
                        Persona::create($newPersona);
                        echo "Añadido Actor-> " . $newPersona['nombre'] . '<img src=" https://image.tmdb.org/t/p/original' . $newPersona['foto'] . '"><br><hr><br>';
                        $this->guardarImagen($newPersona['foto'],'actor');
                    } 
                    $pelicula->actores()->attach($crews['cast'][$i]['id'], ['personaje' => $crews['cast'][$i]['character'], 'orden' =>$crews['cast'][$i]['order']]);
            }
        }
        //directores, guionistas y escritores
        if(isset($crews['crew']))
            foreach($crews['crew'] as $peliCrew){
                if ($peliCrew['job'] == 'Director'){ 
                    $director = Persona::find($peliCrew['id']);
                    if (!$director) {
                        $director = $this->getPersona($peliCrew['id'],true);  
                        Persona::create($director);   
                        echo "Añadido director-> " . $director['nombre'] . '<img src=" https://image.tmdb.org/t/p/original' . $director['foto'] . '"><br><hr><br>';   
                        $this->guardarImagen($newPersona['foto'],'director');            
                    }                         
                    $pelicula->directores()->attach($peliCrew['id']);
                }
                if ($peliCrew['job'] == 'Screenplay'){ 
                    $guionista = Persona::find($peliCrew['id']);
                    if (!$guionista) {
                        $guionista = $this->getPersona($peliCrew['id'],false);  
                        Persona::create($guionista);                  
                    }                         
                    $pelicula->guionistas()->attach($peliCrew['id'], ['role' => 'guionista']);
                }
                if ($peliCrew['job'] == 'Writer'){ 
                    $escritor = Persona::find($peliCrew['id']);
                    if (!$escritor) {
                        $escritor = $this->getPersona($peliCrew['id'],false); 
                        Persona::create($escritor);                    
                    }
                    $pelicula->escritores()->attach($peliCrew['id'], ['role' => 'escritor']);
                }
            }
    }
    public function getPersona ($id, $addImage){        
        $persona = $this->getMovieApi("person/" . $id . "?language=es-ES");
        if (isset($persona['id'])){
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
            if ($persona['birthday'] != null){ 
                $newPersona['fecha_1'] = $persona['birthday'];
                $newPersona['year_1'] = substr($persona['birthday'],0,4);
            }
            if ($persona['deathday'] != null){ 
                $newPersona['fecha_2'] = $persona['deathday'];
                $newPersona['year_2'] = substr($persona['deathday'],0,4);
            }
            return $newPersona;
        }
        else {
            echo '<h3>Error al intentar añadir persona:</h3>';
            dd($persona);
        }
    }

}
