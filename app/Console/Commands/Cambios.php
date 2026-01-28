<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\backend\SerieController;
use App\Http\Controllers\backend\PeliculaController;
use App\Http\Controllers\backend\UtilsController;

class Cambios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cambios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta los cambios para series, pelis y utils';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Iniciando procesos de actualización...");

        // Ejecutar Series
        $this->info("Actualizando Series...");
        app()->make(SerieController::class)->cambiosDia();
        
        // Ejecutar Películas
        $this->info("Actualizando Películas...");
        app()->make(PeliculaController::class)->cambiosDia();
        
        // Ejecutar Utils
        $this->info("Actualizando Utils...");
        app()->make(UtilsController::class)->cambiosDia();
        
        // Ejecutar Películas
        $this->info("Actualizando Popularidad Películas...");
        app()->make(PeliculaController::class)->checkPopularity();
        
        // Ejecutar Utils
        $this->info("Actualizando Populariodad Series...");
        app()->make(UtilsController::class)->checkPopularity();

        $this->info("¡Todos los procesos han finalizado con éxito!");
    }
}
