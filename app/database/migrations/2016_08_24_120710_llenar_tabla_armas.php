<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LlenarTablaArmas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$arma = new Arma;
		$arma->calibre = '9';
		$arma->tipo = 'PISTOLA';
		$arma->save();

		$arma = new Arma;
		$arma->calibre = '12';
		$arma->tipo = 'RETROCARGA';
		$arma->save();

		$arma = new Arma;
		$arma->calibre = '38';
		$arma->tipo = 'REVOLVER';
		$arma->save();
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
