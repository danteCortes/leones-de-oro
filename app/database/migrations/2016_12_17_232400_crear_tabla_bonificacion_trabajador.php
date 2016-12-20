<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaBonificacionTrabajador extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bonificacion_trabajador', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('bonificacion_id')->unsigned();
      $table->foreign('bonificacion_id')->references('id')->on('bonificaciones')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->integer('trabajador_id')->unsigned();
      $table->foreign('trabajador_id')->references('id')->on('trabajadores')
        ->onUpdate('cascade')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('bonificacion_trabajador');
  }

}
