<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\backend\PeliculaController;

class PopularidadPelis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'popularidadPelis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta los cambios para pelis';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Iniciando procesos de actualización...");

        // Ejecutar Películas
        $this->info("Actualizando Popularidad Películas...");
        app()->make(PeliculaController::class)->checkPopularity();
        
        $this->info("¡Todos los procesos han finalizado con éxito!");
    }
}
