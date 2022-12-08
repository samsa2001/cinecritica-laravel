@extends('backend.layout')
@section('content')  
<h1>Tabla de contenidos</h1>
    <form action="{{ route('pelicula.addnovedades') }}" method="POST" enctype="multipart/form-data">
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Titulo</th>
            <th>Nota</th>
            <th>Póster</th>
            <th>Añadir</th>
        </tr>
    </thead>
    <tbody>
        @csrf
        @method("post")
        @foreach ($peliculas as $pelicula)
        <tr>
            <td>{{$pelicula['id']}}</td>
            <td>{{$pelicula['title']}}</td> 
            <td>Nota: {{$pelicula['vote_average']}}<br>
                N. Votos: {{$pelicula['vote_count']}}<br>
                Popularidad: {{$pelicula['popularity']}}
            </td>
            <td class="block mx-auto"><img class="d-none d-md-block poster-pelicula" src="https://image.tmdb.org/t/p/original{{$pelicula['poster_path']}}" width="300"></td>
            <td><input type="checkbox" name="peli[{{$pelicula['id']}}]" value="{{$pelicula['id']}}"></td>
        @endforeach
    </tbody>
</table>
        <input type="submit" value="Enviar" class="btn btn-slate my-3">
    </form>


@endsection