<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCartas extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('cartas', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('usuario_id')->unsigned()->nullable();
      $table->foreign('usuario_id')->references('id')->on('usuarios')
        ->onUpdate('cascade')->onDelete('set null');
      $table->string('empresa_ruc', 11);
      $table->foreign('empresa_ruc')->references('ruc')->on('empresas')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->string('anio');
      $table->string('fecha');
      $table->integer('numero')->unsigned();
      $table->string('codigo');
      $table->string('destinatario');
      $table->string('lugar');
      $table->string('asunto')->nullable();
      $table->string('referencia')->nullable();
      $table->string('contenido', 1024);
      $table->date('redaccion');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('cartas');
  }

}
