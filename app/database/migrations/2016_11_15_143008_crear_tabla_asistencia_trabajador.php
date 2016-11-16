<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAsistenciaTrabajador extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('asistencia_trabajador', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('asistencia_id')->unsigned();
      $table->foreign('asistencia_id')->references('id')->on('asistencias')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->integer('trabajador_id')->unsigned();
      $table->foreign('trabajador_id')->references('id')->on('trabajadores')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->time('entrada');
      $table->time('salida');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('asistencia_trabajador');
  }

}
