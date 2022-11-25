@extends ('backend.layout')
@section ('content')
    <h1>Actualizar una lista: {{ $lista->titulo }}</h1>
    <form action="{{ route('listas.update', $lista->id) }}" method="post">
        @csrf
        @method("PATCH")
        @include("backend.listas._form",['task'=>'edit'])
    </form>
@endsection