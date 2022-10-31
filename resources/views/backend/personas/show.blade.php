@extends('backend.layout')
@section('content')  
<h1>{{$persona->nombre}}</h1>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Foto</th>
            <th>Edad</th>
            <th>Descripción</th>
            <th>Películas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$persona->id}}</td>
            <td class="block mx-auto"><img class="d-none d-md-block poster-persona" src="https://cdn1.cinecritica.com/media/actores/{{$persona->foto}}" alt="Póster película {{$persona->nombre}}" width="100"></td>
            <td>
                {{$persona->Fecha_1}}
            </td>
            <td>
                {{$persona->descripcion}}
            </td>
            <td><ul>
            @foreach ($persona->peliculas as $pelicula)
                <li><a href="{{ route('peliculas.show',$pelicula) }}"">{{$pelicula->titulo}}</a></li><hr>
            @endforeach
            </ul></td>
    </tbody>
</table>


@endsection