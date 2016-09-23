<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LlenarTablaAreas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$area = new Area;
		$area->nombre = 'GERENTE GENERAL';
		$area->abreviatura = 'GG';
		$area->save();

		$area = new Area;
		$area->nombre = 'JEFE DE OPERACIONES';
		$area->abreviatura = 'JO';
		$area->save();
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
