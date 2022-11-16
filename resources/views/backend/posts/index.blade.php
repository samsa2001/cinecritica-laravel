@extends('backend.layout')
@section('content')  
<h1>Tabla de contenidos</h1>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Titulo</th>
            <th>Slug</th>
            <th>Contenido</th>
            <th>Categoria</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
        <tr>
            <td>{{$post->id}}</td>
            <td>{{$post->titulo}}</td> 
            <td>{{$post->slug}}</td> 
            <td>{!! $post->contenido   !!}</td>
            <td>{{$post->categoria->nombre}}</td>
            <td>{{$post->fecha}}</td>
            <td class="flex flex-row">
                <a href="{{ route('posts.show',$post) }}" class="btn btn-small btn-green mr-1">Ver</a> 
                <a href="{{ route('posts.edit',$post) }}" class="btn btn-small btn-slate mx-1">Editar</a> 
                <form action="{{ route('posts.destroy',$post) }}" method="post">
                  @method("DELETE")
                  @csrf
                  <button type="submit" class="btn btn-small btn-red ml-1">Borrar</button>
                </form>
            </td>
        @endforeach
    </tbody>
</table>
{{ $posts -> links() }}


@endsection