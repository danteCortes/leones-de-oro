<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaVariables extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('variables', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('empresa_ruc', 11);
      $table->foreign('empresa_ruc')->references('ruc')->on('empresas')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->string('nombre_anio')->nullable();
      $table->integer('inicio_memorandum')->unsigned()->nullable();
      $table->integer('inicio_carta')->unsigned()->nullable();
      $table->integer('inicio_informe')->unsigned()->nullable();
      $table->integer('anio')->unsigned();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('variables');
  }

}
