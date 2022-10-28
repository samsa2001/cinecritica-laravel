<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peliculas', function (Blueprint $table) {
            $table->id();   
            $table->string('titulo',255);
            $table->double('nota', 3, 1)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('slug',191)->nullable();
            $table->string('imagen',255)->nullable();
            $table->integer('numero_votos')->nullable();
            $table->string('titulo_original',255)->nullable();
            $table->integer('presupuesto')->nullable();
            $table->integer('recaudacion')->nullable();
            $table->date('fecha')->nullable();
            $table->string('imdb_id',25)->nullable();
            $table->string('productora',60)->nullable();
            $table->smallInteger('duracion')->nullable();
            $table->smallInteger('year')->nullable();
            $table->string('tagline',255)->nullable();
            $table->string('certificacion',25)->nullable();
            $table->double('popularidad')->nullable();
            $table->string('video',255)->nullable();
            $table->string('pais',255)->nullable();
            $table->string('idioma',255)->nullable();
            $table->string('imagen_principal',255)->nullable();
            $table->smallInteger('director_id')->nullable();
            // $table->foreignId('director_id')->nullable()->constrained();//->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peliculas');
    }
};
