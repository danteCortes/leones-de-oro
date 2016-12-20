<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaBonificaciones extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bonificaciones', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('nombre');
      $table->double('porcentaje')->nullable();
      $table->double('fijo')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('bonificaciones');
  }

}
