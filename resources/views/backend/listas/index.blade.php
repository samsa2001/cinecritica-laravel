@extends('backend.layout')
@section('content')

<h1>Tabla de contenidos</h1>
<a href="{{ route('listas.create') }}" class="btn btn-small btn-green mr-1">Crear lista</a>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Titulo</th>
            <th>Slug</th>
            <th>Descripcion</th>
            <th>Usuario</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listas as $lista)
        <tr>
            <td>{{$lista->id}}</td>
            <td>{{$lista->titulo}}</td>
            <td>{{$lista->slug}}</td>
            <td>{{ $lista->descripcion }}</td>
            <td>{{ $lista->user->name }}</td>
            <td>{{$lista->updated_at}}</td>
            <td class="flex flex-row">
                <a href="{{ route('listas.show',$lista) }}" class="btn btn-small btn-green mr-1">Ver</a>
                <a href="{{ route('listas.edit',$lista) }}" class="btn btn-small btn-slate mx-1">Editar</a>
                <form action="{{ route('listas.destroy',$lista) }}" method="post">
                    @method("DELETE")
                    @csrf
                    <button type="submit" class="btn btn-small btn-red ml-1">Borrar</button>
                </form>
            </td>
            @endforeach
    </tbody>
</table>
{{ $listas -> links() }}


@endsection