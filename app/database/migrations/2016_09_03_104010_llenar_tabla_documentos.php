<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LlenarTablaDocumentos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$documento = new Documento;
		$documento->nombre = 'DNI PROPIO';
		$documento->save();

		$documento = new Documento;
		$documento->nombre = 'ANTECEDENTES PENALES';
		$documento->save();

		$documento = new Documento;
		$documento->nombre = 'ANTECEDENTES JUDICIALES';
		$documento->save();

		$documento = new Documento;
		$documento->nombre = 'ANTECEDENTES POLICIALES';
		$documento->save();

		$documento = new Documento;
		$documento->nombre = 'DECLARACION DOMICILIARIA';
		$documento->save();

		$documento = new Documento;
		$documento->nombre = 'CONSTANCIA DE TRABAJO';
		$documento->save();

		$documento = new Documento;
		$documento->nombre = 'CERTIFICADO DE ESTUDIOS';
		$documento->save();

		$documento = new Documento;
		$documento->nombre = 'CONTRATO';
		$documento->save();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
	}

}
