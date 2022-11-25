@extends ('backend.layout')
@section ('content')
    <h1>Crear un lista</h1>
    <form action="{{ route('listas.store') }}" method="post">
        @csrf
        @include("backend.listas._form")
    </form>
@endsection