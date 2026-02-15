@extends('backend.layout')
@section('title', $persona->nombre)
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
                @if (isset($persona->year_2))
                    {{intval($persona->year_2) - intval($persona->year_1) }}
                    <span class="small">({{$persona->year_1}} - {{$persona->year_2}})</span>
                @elseif (isset($persona->year_1))
                    {{intval(now()->format('Y')) - intval($persona->year_1)}}
                    <span class="small">({{$persona->year_1}} - ...)</span>
                @endif
            </td>
            <td>
                {{$persona->descripcion}}
            </td>
            <td><ul>
            @if ( count($persona->peliculas) > 0)
                <h5>Cine</h5>
                @foreach ($persona->peliculas as $pelicula)
                    <li><a href="{{ route('peliculas.show',$pelicula) }}"">{{$pelicula->titulo}}</a></li><hr>
                @endforeach
            @endif
            @if ( count($persona->series) > 0)
                <h5>TV</h5>
                @foreach ($persona->series as $serie)
                    <li><a href="{{ route('series.show',$serie) }}"">{{$serie->titulo}}</a></li><hr>
                @endforeach
            @endif
            </ul></td>
    </tbody>
</table>


@endsection