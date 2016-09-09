<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LlenarTablaCargos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$cargo = new Cargo;
		$cargo->nombre = 'DESCANCERO';
		$cargo->save();

		$cargo = new Cargo;
		$cargo->nombre = 'LIMPIEZA';
		$cargo->save();

		$cargo = new Cargo;
		$cargo->nombre = 'SEGURIDAD';
		$cargo->save();

		$cargo = new Cargo;
		$cargo->nombre = 'CHOFER';
		$cargo->save();
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
