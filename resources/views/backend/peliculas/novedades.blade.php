<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novedades de Películas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-6">📽️ Agregar Películas de la Base de Datos TMDB</h3>
                    
                    <form action="{{ route('pelicula.addnovedades') }}" method="POST" enctype="multipart/form-data">
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Id</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Título</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Información</th>
                                        <th class="border border-gray-300 px-4 py-2 text-center">Póster</th>
                                        <th class="border border-gray-300 px-4 py-2 text-center">Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @csrf
                                    @method("post")
                                    @foreach ($peliculas as $pelicula)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a href="https://www.themoviedb.org/movie/{{$pelicula['id']}}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                                                {{$pelicula['id']}}
                                            </a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">{{$pelicula['title']}}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-sm">
                                            <div>⭐ Nota: {{$pelicula['vote_average']}}</div>
                                            <div>🗳️ Votos: {{$pelicula['vote_count']}}</div>
                                            <div>📊 Popularidad: {{$pelicula['popularity']}}</div>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            @if($pelicula['poster_path'])
                                                <img src="https://image.tmdb.org/t/p/w200{{$pelicula['poster_path']}}" alt="{{$pelicula['title']}}" class="h-32 mx-auto rounded">
                                            @else
                                                <span class="text-gray-400">Sin póster</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <input type="checkbox" name="peli[{{$pelicula['id']}}]" value="{{$pelicula['id']}}" class="w-5 h-5">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                ✅ Agregar Películas Seleccionadas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>