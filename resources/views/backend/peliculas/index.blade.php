@extends('backend.layout')
@section('content')  
<h1>Tabla de contenidos</h1>
<a href="{{ route('peliculas.create') }}" class="btn btn-green">Crear pelicula</a>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Titulo</th>
            <th>Slug</th>
            <th>Nota</th>
            <th>Popularidad</th>
            <th>Género</th>
            <th>Póster</th>
            <th>Director</th>
            <th>Actores</th>
            <th>Historia</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peliculas as $pelicula)
        <tr>
            <td>{{$pelicula->id}}</td>
            <td><a href="{{ route('peliculas.show',$pelicula) }}">{{$pelicula->titulo}}</a></td> 
            <td><a href="{{ route('pelicula.show',$pelicula) }}">{{$pelicula->slug}}</a></td> 
            <td>{{$pelicula->nota}}</td>
            <td>{{$pelicula->popularidad}}</td>
            <td><ul>
            @foreach ($pelicula->generos as $genero)
                <li>{{$genero->titulo}}</li>
            @endforeach
            </ul></td>
            <td class="block mx-auto"><img class="d-none d-md-block poster-pelicula" src="https://cdn1.cinecritica.com/media/peliculas{{$pelicula->imagen}}" alt="Póster película {{$pelicula->title}}" width="100"></td>
            <td><ul>
            @foreach ($pelicula->directores as $director)
                <li>{{$director->nombre}}</li>
            @endforeach
            </ul></td>
            <td><ul>
            @foreach ($pelicula->actores as $actor)
                <li><a href="{{ route('personas.show',$actor)  }}">{{$actor->nombre}}</a></li>
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
        @endforeach
    </tbody>
</table>
{{ $peliculas -> links() }}


@endsection