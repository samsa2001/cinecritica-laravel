@extends ('backend.layout')
@section ('content')
    <h1>Actualizar un post: {{ $post->titulo }}</h1>
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PATCH")
        @include("backend.posts._form",['task'=>'edit'])
    </form>
@endsection