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
                    
                    <!-- Formulario de filtros -->
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">🔍 Filtrar Películas</h3>
                        <form action="{{ route('novedades.pelis') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Desde</label>
                                <input type="date" name="primary_release_date.gte" value="{{ $filters['primary_release_date.gte'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Hasta</label>
                                <input type="date" name="primary_release_date.lte" value="{{ $filters['primary_release_date.lte'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mínimo de Votos</label>
                                <input type="number" name="vote_count.gte" value="{{ $filters['vote_count.gte'] ?? '50' }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Calificación Mínima (1-10)</label>
                                <input type="number" name="vote_average.gte" value="{{ $filters['vote_average.gte'] ?? '6' }}" min="0" max="10" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">País de Origen (ej: US, ES)</label>
                                <input type="text" name="with_origin_country" value="{{ $filters['with_origin_country'] ?? 'US' }}" placeholder="US" class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Elenco (ID TMDB, opcional)</label>
                                <input type="text" name="with_cast" value="{{ $filters['with_cast'] ?? '' }}" placeholder="Dejar vacío" class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Equipo (ID TMDB, opcional)</label>
                                <input type="text" name="with_crew" value="{{ $filters['with_crew'] ?? '' }}" placeholder="Dejar vacío" class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-900">
                            </div>
                            <div class="md:col-span-2 lg:col-span-3 flex gap-2">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition">
                                    🔎 Buscar Películas
                                </button>
                                <a href="{{ route('novedades.pelis') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded transition">
                                    ↺ Resetear Filtros
                                </a>
                            </div>
                        </form>
                    </div>

                    <h3 class="text-lg font-semibold mb-6">📽️ Agregar Películas de la Base de Datos TMDB</h3>
                    
                    <form action="{{ route('pelicula.addnovedades') }}" method="POST" enctype="multipart/form-data">
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse border border-gray-300 text-gray-900">
                                <thead class="bg-gray-200 text-gray-900">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left font-bold">Id</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left font-bold">Título</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left font-bold">Información</th>
                                        <th class="border border-gray-300 px-4 py-2 text-center font-bold">Póster</th>
                                        <th class="border border-gray-300 px-4 py-2 text-center font-bold">Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @csrf
                                    @method("post")
                                    @foreach ($peliculas as $pelicula)
                                    <tr class="hover:bg-gray-100 text-gray-900">
                                        <td class="border border-gray-300 px-4 py-2 text-gray-900">
                                            <a href="https://www.themoviedb.org/movie/{{$pelicula['id']}}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                                                {{$pelicula['id']}}
                                            </a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-gray-900">{{$pelicula['title']}}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-900">
                                            <div>⭐ Nota: {{$pelicula['vote_average']}}</div>
                                            <div>🗳️ Votos: {{$pelicula['vote_count']}}</div>
                                            <div>📊 Popularidad: {{$pelicula['popularity']}}</div>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            @if($pelicula['poster_path'])
                                                <img src="https://image.tmdb.org/t/p/w200{{$pelicula['poster_path']}}" alt="{{$pelicula['title']}}" class=" mx-auto rounded">
                                            @else
                                                <span class="text-gray-500">Sin póster</span>
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
                            <button type="submit" class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-3 px-8 rounded shadow-md transition duration-200">
                                ✅ Agregar Películas Seleccionadas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>