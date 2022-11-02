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
        Schema::create('serie_temporadas', function (Blueprint $table) {
            $table->id();
            $table->integer('serie_id');
            $table->string('titulo',255)->nullable();
            $table->string('slug',191)->nullable();
            $table->smallInteger('numero')->nullable();
            $table->smallInteger('episodios')->nullable();
            $table->date('fecha')->nullable();
            $table->string('imagen',191)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serie_temporadas');
    }
};
