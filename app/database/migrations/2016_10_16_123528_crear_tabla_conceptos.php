<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaConceptos extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('conceptos', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('costo_id')->unsigned();
      $table->foreign('costo_id')->references('id')->on('costos')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->string('nombre');
      $table->integer('numero')->unsigned();
      $table->double('subtotal');
      $table->double('igv');
      $table->double('total');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('conceptos');
  }

}
