<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModificarTablaTrabajadores extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('trabajadores', function(Blueprint $table)
		{
			$table->integer('aseguradora_id')->unsigned()->nullable()->after('empresa_ruc');
      $table->foreign('aseguradora_id')->references('id')->on('aseguradoras')
        ->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('trabajadores', function(Blueprint $table)
		{
			$table->dropColumn('aseguradora_id');
		});
	}

}
