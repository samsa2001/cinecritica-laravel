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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();   
            $table->string('titulo',255);
            $table->text('contenido')->nullable();
            $table->string('slug',191)->nullable();
            $table->string('imagen',255)->nullable();
            $table->date('fecha')->nullable();
            $table->integer('categoria_id');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
