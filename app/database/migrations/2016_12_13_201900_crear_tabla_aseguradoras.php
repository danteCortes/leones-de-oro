<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAseguradoras extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('aseguradoras', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->float('fijo')->nullable();
			$table->float('fondo')->nullable();
			$table->float('prima')->nullable();
			$table->float('flujo')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('aseguradoras');
	}

}
