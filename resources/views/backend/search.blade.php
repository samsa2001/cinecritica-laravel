@extends('backend.layout')
@section('content')  
<h1>Busqueda</h1>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Resultado</th>
            <th>Imagen</th>
            <th>Popularidad</th>
        </tr>
    </thead>
    <tbody>
    @if(count($collection))
        @foreach($collection as $object)
            <tr>
            <td>{{$object->id}}</td>
            @if($object instanceof App\Models\Serie)
                <td>{{$object->titulo}} (serie)</td>
                <td><img src="https://image.tmdb.org/t/p/original{{$object->imagen}}" width="150"></td>
            @elseif($object instanceof App\Models\Pelicula)
                <td>{{$object->titulo}}</td>
                <td><img src="https://image.tmdb.org/t/p/original{{$object->imagen}}" width="150"></td>
            @else($object instanceof App\Models\Persona)
                <td>{{$object->nombre}}</td>
                <td><img src="https://image.tmdb.org/t/p/original{{$object->foto}}" width="150"></td>
            @endif
            <td>{{$object->popularidad}}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>


@endsection