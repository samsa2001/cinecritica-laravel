@extends ('backend.layout')
@section ('content')
    <h1>lista: {{ $lista->titulo }}</h1>
    <div>
        {{ $lista->descripcion }}
    </div>

@endsection