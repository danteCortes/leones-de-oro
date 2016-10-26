<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarTablaConceptoTurno extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('concepto_turno', function(Blueprint $table)
    {
      $table->renameColumn('asigfamiliar', 'igv')->after('utilidad');
      $table->integer('puestos')->unsigned()->after('turno_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('concepto_turno', function(Blueprint $table)
    {
      $table->renameColumn('igv', 'asigfamiliar')->after('feriados');
      $table->dropColumn('puestos');
    });
  }

}
