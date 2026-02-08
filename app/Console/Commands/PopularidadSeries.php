<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\backend\SerieController;

class Popularidad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'popularidadSeries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta los cambios para series';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Iniciando procesos de actualización...");
        // Ejecutar Series
        $this->info("Actualizando Populariodad Series...");
        app()->make(SerieController::class)->checkPopularity();

        $this->info("¡Todos los procesos han finalizado con éxito!");
    }
}
