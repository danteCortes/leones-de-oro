<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCostos extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('costos', function(Blueprint $table)
    {
      $table->increments('id');
      $table->string('empresa_ruc', 11);
      $table->foreign('empresa_ruc')->references('ruc')->on('empresas')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->string('cliente')->nullable();
      $table->string('lugar')->nullable();
      $table->string('saludo')->nullable();
      $table->double('subtotal')->nullable();
      $table->double('igv')->nullable();
      $table->double('total')->nullable();
      $table->string('despedida')->nullable();
      $table->string('fecha')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('costos');
  }

}
