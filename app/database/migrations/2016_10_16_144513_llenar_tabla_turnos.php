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
    $turno->save();

    $turno = new Turno;
    $turno->nombre = 'NOCTURNO';
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
