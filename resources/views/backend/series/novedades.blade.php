@extends('backend.layout')
@section('content')  
<h1>Tabla de contenidos</h1>
    <form action="{{ route('serie.addnovedades') }}" method="POST" enctype="multipart/form-data">
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
        @foreach ($series as $serie)
        <tr>
            <td>{{$serie['id']}}</td>
            <td>{{$serie['name']}}</td> 
            <td>Nota: {{$serie['vote_average']}}<br>
                N. Votos: {{$serie['vote_count']}}<br>
                Popularidad: {{$serie['popularity']}}
            </td>
            <td class="block mx-auto"><img class="d-none d-md-block poster-serie" src="https://image.tmdb.org/t/p/original{{$serie['poster_path']}}" width="300"></td>
            <td><input type="checkbox" name="serie[{{$serie['id']}}]" value="{{$serie['id']}}"></td>
        @endforeach
    </tbody>
</table>
        <input type="submit" value="Enviar" class="btn btn-slate my-3">
    </form>


@endsection