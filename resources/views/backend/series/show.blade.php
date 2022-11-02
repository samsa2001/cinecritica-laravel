@extends('backend.layout')
@section('content')  
<h1>{{$serie->titulo}}</h1>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Póster</th>
            <th>creador</th>
            <th>Actores</th>
            <th>Género</th>
            <th>Popularidad</th>
            <th>Temporadas</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$serie->id}}</td>
            <td class="block mx-auto"><img class="d-none d-md-block poster-serie" src="https://cdn1.cinecritica.com/media/series{{$serie->imagen}}" alt="Póster película {{$serie->title}}" width="100"></td>
            <td><ul>
            @foreach ($serie->creadores as $creador)
                <li>{{$creador->nombre}}</li>
            @endforeach
            </ul></td>
            <td><ul>
            @foreach ($serie->actores as $actor)
                <li><a href="{{ route('personas.show',$actor)}}">{{$actor->nombre}}</a></li>
            @endforeach
            </ul></td>
            <td><ul>
            @foreach ($serie->generos as $genero)
                <li>{{$genero->titulo}}</li>
            @endforeach
            </ul></td>
            <td>{{$serie->popularidad}}</td>
            <td><ul>
            @foreach ($serie->temporadas as $temporada)
                <li>{{$temporada->titulo}} - {{$temporada->episodios}} - {{$temporada->fecha}}</li>
            @endforeach
            </ul></td>
    </tbody>
</table>


@endsection