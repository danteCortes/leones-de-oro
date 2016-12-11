<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEmpresaHerramientaTrabajador extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('empresa_herramienta_trabajador', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('empresa_herramienta_id')->unsigned();
      $table->foreign('empresa_herramienta_id')->references('id')->on('empresa_herramienta')
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
    Schema::drop('empresa_herramienta_trabajador');
  }

}
