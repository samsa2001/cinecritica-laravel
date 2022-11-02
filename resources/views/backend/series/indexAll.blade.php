@extends('backend.layout')
@section('content')  
<h1>Tabla de contenidos</h1>
<a href="{{ route('series.create') }}" class="btn btn-green">Crear serie</a>
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
            <th>Creador</th>
            <th>Actores</th>
            <th>Numero episodios</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($series as $serie)
        <tr>
            <td>{{$serie->id}}</td>
            <td><a href="{{ route('series.show',$serie) }}">{{$serie->titulo}}</a></td> 
            <td><a href="{{ route('series.show',$serie) }}">{{$serie->slug}}</a></td> 
            <td>{{$serie->nota}}</td>
            <td>{{$serie->popularidad}}</td>
            <td><ul>
            @foreach ($serie->generos as $genero)
                <li>{{$genero->titulo}}</li>
            @endforeach
            </ul></td>
            <td class="block mx-auto"><img class="d-none d-md-block poster-serie" src="https://cdn1.cinecritica.com/media/series{{$serie->imagen}}" alt="Póster película {{$serie->title}}" width="100"></td>
            <td><ul>
            @foreach ($serie->creadores as $creador)
                <li>{{$creador->nombre}}</li>
            @endforeach
            </ul></td>
            <td><ul>
            @foreach ($serie->actores as $actor)
                <li><a href="{{ route('personas.show',$actor)  }}">{{$actor->nombre}}</a></li>
            @endforeach
            </ul></td>
            <td>{{$serie->numero}}</td>
        @endforeach
    </tbody>
</table>


@endsection