<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrativo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Bienvenida -->
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-2">Bienvenido, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Panel de administración de CineCrítica</p>
                </div>
            </div>

            <!-- Grid de opciones -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Gestión de Películas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg mb-4">🎬 Películas</h4>
                        <div class="space-y-2">
                            <a href="{{ route('peliculas.index') }}" class="block text-blue-600 hover:text-blue-800">
                                → Ver todas las películas
                            </a>
                            <a href="{{ route('peliculas.create') }}" class="block text-blue-600 hover:text-blue-800">
                                → Crear película
                            </a>
                            <a href="{{ route('novedades.pelis') }}" class="block text-blue-600 hover:text-blue-800">
                                → Ver novedades
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Series -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg mb-4">📺 Series</h4>
                        <div class="space-y-2">
                            <a href="{{ route('series.index') }}" class="block text-blue-600 hover:text-blue-800">
                                → Ver todas las series
                            </a>
                            <a href="{{ route('series.create') }}" class="block text-blue-600 hover:text-blue-800">
                                → Crear serie
                            </a>
                            <a href="{{ route('novedades.series') }}" class="block text-blue-600 hover:text-blue-800">
                                → Ver novedades
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Personas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg mb-4">👤 Personas</h4>
                        <div class="space-y-2">
                            <a href="{{ route('personas.index') }}" class="block text-blue-600 hover:text-blue-800">
                                → Ver todas las personas
                            </a>
                            <a href="{{ route('personas.create') }}" class="block text-blue-600 hover:text-blue-800">
                                → Crear persona
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Posts -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg mb-4">📝 Blog</h4>
                        <div class="space-y-2">
                            <a href="{{ route('posts.index') }}" class="block text-blue-600 hover:text-blue-800">
                                → Ver todos los posts
                            </a>
                            <a href="{{ route('posts.create') }}" class="block text-blue-600 hover:text-blue-800">
                                → Crear post
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Listas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg mb-4">⭐ Listas</h4>
                        <div class="space-y-2">
                            <a href="{{ route('listas.index') }}" class="block text-blue-600 hover:text-blue-800">
                                → Ver todas las listas
                            </a>
                            <a href="{{ route('listas.create') }}" class="block text-blue-600 hover:text-blue-800">
                                → Crear lista
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Herramientas y Utilidades -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg mb-4">🔧 Utilidades</h4>
                        <div class="space-y-2">
                            <a href="{{ route('proveedores.index') }}" class="block text-blue-600 hover:text-blue-800">
                                → Gestionar proveedores
                            </a>
                            <a href="{{ route('cambios.pelis') }}" class="block text-blue-600 hover:text-blue-800">
                                → Cambios hoy (películas)
                            </a>
                            <a href="{{ route('cambios.series') }}" class="block text-blue-600 hover:text-blue-800">
                                → Cambios hoy (series)
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Información adicional -->
            <div class="mt-6 bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="font-semibold mb-2">ℹ️ Información</h4>
                    <p class="text-gray-700">
                        Este dashboard te permite gestionar todo el contenido de CineCrítica. 
                        Puedes crear, editar y eliminar películas, series, personas y posts.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
