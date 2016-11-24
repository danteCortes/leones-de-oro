<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAsistencias extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('asistencias', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('punto_id')->unsigned();
      $table->foreign('punto_id')->references('id')->on('puntos')
        ->onUpdate('cascade')->onDetele('cascade');
      $table->integer('turno_id')->unsigned();
      $table->foreign('turno_id')->references('id')->on('turnos')
        ->onUpdate('cascade')->onDetele('cascade');
      $table->date('fecha');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('asistencias');
  }

}
