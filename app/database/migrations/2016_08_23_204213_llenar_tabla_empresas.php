<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LlenarTablaEmpresas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$empresa = new Empresa;
		$empresa->ruc = '20489468795';
		$empresa->nombre = 'E.S.S.P. LEONES DE ORO S.R.L.';
		$empresa->save();

		$empresa = new Empresa;
		$empresa->ruc = '20529007869';
		$empresa->nombre = 'EMPRESA DE SERVICIOS MULTIPLES LEOMIL S.R.L.';
		$empresa->save();

		$empresa = new Empresa;
		$empresa->ruc = '20529113898';
		$empresa->nombre = 'P&R SEGURIDAD INTEGRAL S.R.L.';
		$empresa->save();
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
