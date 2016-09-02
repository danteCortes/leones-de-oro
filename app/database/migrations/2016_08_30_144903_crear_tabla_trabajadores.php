<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaTrabajadores extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trabajadores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('persona_dni', 8);
			$table->foreign('persona_dni')->references('dni')->on('personas')
				->onUpdate('cascade')->onDelete('cascade');
			$table->string('empresa_ruc', 11);
			$table->foreign('empresa_ruc')->references('ruc')->on('empresas')
				->onUpdate('cascade')->onDelete('cascade');
			$table->string('cuenta')->nullable();
			$table->string('banco')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trabajadores');
	}

}
