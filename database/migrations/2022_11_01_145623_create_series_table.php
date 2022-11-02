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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',255);
            $table->double('nota', 3, 1)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('slug',191)->nullable();
            $table->string('imagen',255)->nullable();
            $table->integer('numero_votos')->nullable();
            $table->string('titulo_original',255)->nullable();
            $table->date('fecha')->nullable();
            $table->string('imdb_id',25)->nullable();
            $table->string('canal',60)->nullable();
            $table->smallInteger('year')->nullable();
            $table->string('tagline',255)->nullable();
            $table->string('certificacion',25)->nullable();
            $table->smallInteger('numero_episodios')->nullable();
            $table->smallInteger('numero_temporadas')->nullable();
            $table->smallInteger('duracion')->nullable();
            $table->boolean('en_produccion')->nullable();
            $table->date('fecha_ultimo')->nullable();
            $table->double('popularidad')->nullable();
            $table->string('tvdb_id',25)->nullable();
            $table->string('pais',255)->nullable();
            $table->string('idioma',255)->nullable();
            $table->string('video',255)->nullable();
            $table->string('imagen_principal',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series');
    }
};
