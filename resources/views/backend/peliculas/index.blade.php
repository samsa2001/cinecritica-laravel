@extends('backend.layout')
@section('content')  
<h1>Tabla de contenidos</h1>
<a href="{{ route('peliculas.create') }}" class="btn btn-green">Crear pelicula</a>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Titulo</th>
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
            <td>{{$pelicula->titulo}}</td> 
            <td class="block mx-auto"><img class="d-none d-md-block poster-pelicula" src="https://cdn1.cinecritica.com/media/peliculas{{$pelicula->imagen}}" alt="Póster película {{$pelicula->title}}" width="100"></td>
            <td><ul>
            @foreach ($pelicula->directores as $director)
                <li>{{$director->nombre}}</li>
            @endforeach
            </ul></td>
            <td><ul>
            @foreach ($pelicula->actores as $actor)
                <li>{{$actor->nombre}}</li>
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