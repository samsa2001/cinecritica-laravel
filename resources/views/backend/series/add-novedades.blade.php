<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resultado: Series Agregadas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center">
                                <span class="text-2xl mr-4">✅</span>
                                <div>
                                    <h3 class="text-lg font-bold text-green-900">Series Agregadas Exitosamente</h3>
                                    <p class="text-green-800 mt-2">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($seriesAgregadas) && count($seriesAgregadas) > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">📺 Series Agregadas ({{ count($seriesAgregadas) }})</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full border-collapse border border-gray-300 text-gray-900">
                                    <thead class="bg-green-100 text-gray-900">
                                        <tr>
                                            <th class="border border-gray-300 px-4 py-2 text-left font-bold">ID</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left font-bold">Título</th>
                                            <th class="border border-gray-300 px-4 py-2 text-center font-bold">Año</th>
                                            <th class="border border-gray-300 px-4 py-2 text-center font-bold">Calificación</th>
                                            <th class="border border-gray-300 px-4 py-2 text-center font-bold">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($seriesAgregadas as $serie)
                                        <tr class="hover:bg-green-50 text-gray-900">
                                            <td class="border border-gray-300 px-4 py-2">{{ $serie->id }}</td>
                                            <td class="border border-gray-300 px-4 py-2 font-semibold">{{ $serie->nombre }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $serie->año ?? 'N/A' }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center">⭐ {{ $serie->calificacion ?? 'N/A' }}</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center">
                                                <a href="{{ route('series.show', $serie->id) }}" class="text-blue-600 hover:text-blue-800 underline">Ver</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if(isset($seriesYaExistentes) && count($seriesYaExistentes) > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">⚠️ Series que Ya Existían ({{ count($seriesYaExistentes) }})</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full border-collapse border border-gray-300 text-gray-900">
                                    <thead class="bg-yellow-100 text-gray-900">
                                        <tr>
                                            <th class="border border-gray-300 px-4 py-2 text-left font-bold">ID</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left font-bold">Título</th>
                                            <th class="border border-gray-300 px-4 py-2 text-center font-bold">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($seriesYaExistentes as $id)
                                        <tr class="hover:bg-yellow-50 text-gray-900">
                                            <td class="border border-gray-300 px-4 py-2">{{ $id }}</td>
                                            <td class="border border-gray-300 px-4 py-2">-</td>
                                            <td class="border border-gray-300 px-4 py-2 text-center">
                                                <a href="https://www.themoviedb.org/tv/{{ $id }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">Ver en TMDB</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('novedades.series') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition">
                            ← Volver a Novedades
                        </a>
                        <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded transition">
                            🏠 Ir al Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
