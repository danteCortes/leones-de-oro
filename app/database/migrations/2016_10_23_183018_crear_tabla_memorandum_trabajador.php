<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaMemorandumTrabajador extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('memorandum_trabajador', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('memorandum_id')->unsigned();
      $table->foreign('memorandum_id')->references('id')->on('memorandums')
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
    Schema::drop('memorandum_trabajador');
  }

}
