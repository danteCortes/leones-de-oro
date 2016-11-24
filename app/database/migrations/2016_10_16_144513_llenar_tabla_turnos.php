<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LlenarTablaTurnos extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $turno = new Turno;
    $turno->nombre = 'DIURNO';
    $turno->entrada = '8:00:00';
    $turno->salida = '20:00:00';
    $turno->save();

    $turno = new Turno;
    $turno->nombre = 'NOCTURNO';
    $turno->entrada = '20:00:00';
    $turno->salida = '8:00:00';
    $turno->save();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    //
  }

}
