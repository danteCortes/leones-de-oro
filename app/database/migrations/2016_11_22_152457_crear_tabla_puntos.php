<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPuntos extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('puntos', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('contrato_id')->unsigned();
      $table->foreign('contrato_id')->references('id')->on('contratos')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->string('nombre');
      $table->double('latitud')->nullable();
      $table->double('longitud')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('puntos');
  }

}
