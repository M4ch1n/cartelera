<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeliculaTurnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelicula_turno', function (Blueprint $table) {
            $table->integer('pelicula_id')->unsigned()->index();
            $table->foreign('pelicula_id')->references('id')->on('peliculas')->onDelete('cascade');
            $table->integer('turno_id')->unsigned()->index();
            $table->foreign('turno_id')->references('id')->on('turnos')->onDelete('cascade');
            $table->primary(['pelicula_id', 'turno_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelicula_turno');
    }
}
