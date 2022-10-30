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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();      
            $table->string('nombre',191)->nullable(); 
            $table->string('foto',155)->nullable(); 
            $table->string('slug',191)->nullable(); 
            $table->date('fecha_1')->nullable(); 
            $table->date('fecha_2')->nullable();
            $table->integer('year_1')->nullable();
            $table->integer('year_2')->nullable();
            $table->integer('popularidad')->nullable();
            $table->text('descripcion')->nullable();
            $table->smallInteger('genero')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
};
