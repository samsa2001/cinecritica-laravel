@extends ('backend.layout')
@section ('content')
    <h1>Post: {{ $post->titulo }}</h1>
    <div>
        {!! $post->contenido !!}
    </div>

@endsection