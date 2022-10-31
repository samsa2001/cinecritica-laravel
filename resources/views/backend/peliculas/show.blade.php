@extends('backend.layout')
@section('content')  
<h1>{{$pelicula->titulo}}</h1>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Póster</th>
            <th>Director</th>
            <th>Actores</th>
            <th>Historia</th>
            <th>Género</th>
            <th>Popularidad</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$pelicula->id}}</td>
            <td class="block mx-auto"><img class="d-none d-md-block poster-pelicula" src="https://cdn1.cinecritica.com/media/peliculas{{$pelicula->imagen}}" alt="Póster película {{$pelicula->title}}" width="100"></td>
            <td><ul>
            @foreach ($pelicula->directores as $director)
                <li>{{$director->nombre}}</li>
            @endforeach
            </ul></td>
            <td><ul>
            @foreach ($pelicula->actores as $actor)
                <li><a href="{{ route('personas.show',$actor)}}">{{$actor->nombre}}</a></li>
            @endforeach
            </ul></td>
            <td><ul>
            @foreach ($pelicula->escritores as $escritor)
                <li>{{$escritor->nombre}}(Historia)</li>
            @endforeach
            @foreach ($pelicula->guionistas as $guionista)
                <li>{{$guionista->nombre}}(Guión)</li>
            @endforeach
            </ul></td>
            @foreach ($pelicula->generos as $genero)
                <li>{{$genero->titulo}}</li>
            @endforeach
            <td>{{$pelicula->popularidad}}</td>
    </tbody>
</table>


@endsection