<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaConceptoTurno extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('concepto_turno', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('concepto_id')->unsigned();
      $table->foreign('concepto_id')->references('id')->on('conceptos')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->integer('turno_id')->unsigned();
      $table->foreign('turno_id')->references('id')->on('turnos')
        ->onUpdate('cascade')->onDelete('cascade');
      $table->double('sueldobasico');
      $table->double('asignacionfamiliar');
      $table->double('jornadanocturna');
      $table->double('sobretiempo1');
      $table->double('sobretiempo2');
      $table->double('descancero');
      $table->double('feriados');
      $table->double('asigfamiliar');
      $table->double('gratificaciones');
      $table->double('cts');
      $table->double('vacaciones');
      $table->double('essalud');
      $table->double('sctr');
      $table->double('ueas');
      $table->double('capacitacion');
      $table->double('movilidad');
      $table->double('refrigerio');
      $table->double('gastosgenerale');
      $table->double('utilidad');
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
    Schema::drop('concepto_turno');
  }

}
