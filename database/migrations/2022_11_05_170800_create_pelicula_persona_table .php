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
        Schema::create('pelicula_persona2', function (Blueprint $table) {
            $table->foreignId('pelicula_id')->constrained('peliculas');
            $table->foreignId('persona_id')->constrained('personas');
            $table->string('role',25)->nullable();
            $table->string('personaje',400)->nullable();
            $table->smallInteger('orden')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelicula_persona');
    }
};