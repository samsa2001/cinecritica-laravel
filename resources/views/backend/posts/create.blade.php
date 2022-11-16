@extends ('backend.layout')
@section ('content')
    <h1>Crear un post</h1>
    <form action="{{ route('post.store') }}" method="POST">
        @csrf
        @include("backend.post._form")
    </form>
@endsection