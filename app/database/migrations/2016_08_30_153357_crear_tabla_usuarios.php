<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUsuarios extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('persona_dni', 8);
			$table->foreign('persona_dni')->references('dni')->on('personas')
				->onUpdate('cascade')->onDelete('cascade');
			$table->string('password');
			$table->rememberToken();
			$table->tinyInteger('nivel');
			$table->boolean('caja');
			$table->string('contrasenia');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usuarios');
	}

}
