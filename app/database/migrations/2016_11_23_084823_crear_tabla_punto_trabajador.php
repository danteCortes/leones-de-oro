<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPuntoTrabajador extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('punto_trabajador', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('punto_id')->unsigned();
      $table->foreign('punto_id')->references('id')->on('puntos')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->integer('trabajador_id')->unsigned();
      $table->foreign('trabajador_id')->references('id')->on('trabajadores')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->integer('cargo_id')->unsigned();
      $table->foreign('cargo_id')->references('id')->on('cargos')
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
    Schema::drop('punto_trabajador');
  }

}
