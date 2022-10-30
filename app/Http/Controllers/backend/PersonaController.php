<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PersonaController extends Controller
{

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
    public function importarDirectores(){
        $peliculas = Pelicula::where('year','<',1970)->where('year','>=',1900)->get();
        foreach ($peliculas as $pelicula){
            $directores = $this->getMovieApi("movie/" . $pelicula->id . "/credits?language=es-ES");
            //dd($directores);
            if(isset($directores['crew']))
                foreach($directores['crew'] as $peliCrew)
                    if ($peliCrew['job'] == 'Director'){
                        //dd($peliCrew);  
                        $director = Persona::find($peliCrew['id']);
                        if ($director){
                            echo $director->nombre;
                        }
                        else {
                            $this->addPersona($peliCrew['id'],true);                    
                        }
                        foreach ($pelicula->directores as $addedDirector)
                            if ($addedDirector->id != $peliCrew['id'] ){
                                $pelicula->directores()->attach($peliCrew['id'], ['role' => 'director']);
                        }
                    }
        }
    }
    public function importarEscritores(){
        $peliculas = Pelicula::where('year','<',2100)->where('year','>=',1900)->get();
        foreach ($peliculas as $pelicula){
            $escritores = $this->getMovieApi("movie/" . $pelicula->id . "/credits?language=es-ES");
            //dd($escritores);
            if(isset($escritores['crew']))
                foreach($escritores['crew'] as $peliCrew)
                    if ($peliCrew['job'] == 'Writer'){
                        //dd($peliCrew);  
                        $escritor = Persona::find($peliCrew['id']);
                        if (!$escritor) {
                            $this->addPersona($peliCrew['id'],false);                    
                        }
                        if(count($pelicula->escritores)>0){
                            foreach ($pelicula->escritores as $addedEscritor)
                                if ($addedEscritor->id != $peliCrew['id'] ){
                                    $pelicula->escritores()->attach($peliCrew['id'], ['role' => 'escritor']);
                            }
                        } else {                            
                            $pelicula->escritores()->attach($peliCrew['id'], ['role' => 'escritor']);
                        }
                    }
        }
    }
    public function importarGuionistas(){
        $peliculas = Pelicula::where('year','<',2100)->where('year','>=',1900)->get();
        foreach ($peliculas as $pelicula){
            $guionistas = $this->getMovieApi("movie/" . $pelicula->id . "/credits?language=es-ES");
            //dd($guionistas);
            if(isset($guionistas['crew']))
                foreach($guionistas['crew'] as $peliCrew)
                    if ($peliCrew['job'] == 'Screenplay'){
                        //dd($peliCrew);  
                        $guionista = Persona::find($peliCrew['id']);
                        if (!$guionista) {
                            $this->addPersona($peliCrew['id'],false);                    
                        }
                        if(count($pelicula->guionistas)>0){
                            foreach ($pelicula->guionistas as $addedGuionista)
                                if ($addedGuionista->id != $peliCrew['id'] ){
                                    $pelicula->guionistas()->attach($peliCrew['id'], ['role' => 'guionista']);
                            }
                        } else {                            
                            $pelicula->guionistas()->attach($peliCrew['id'], ['role' => 'guionista']);
                        }
                    }
        }
    }
    public function addPersona ($id, $addImage){        
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
            Persona::create($newPersona);
            echo "Añadido -> " . $persona['name'] . '<img src=" https://image.tmdb.org/t/p/original' . $persona['profile_path'] . '"><br><hr><br>';
        }
        else {
            echo '<h3>Error al intentar añadir persona:</h3>';
            dd($persona);
        }
    }
}