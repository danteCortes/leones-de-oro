<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEmpresaHerramienta extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('empresa_herramienta', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('empresa_ruc', 11);
      $table->foreign('empresa_ruc')->references('ruc')->on('empresas')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->integer('herramienta_id')->unsigned();
      $table->foreign('herramienta_id')->references('id')->on('herramientas')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->string('serie')->unique();
      $table->string('marca');
      $table->string('modelo');
      $table->string('descripcion');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('empresa_herramienta');
  }

}
