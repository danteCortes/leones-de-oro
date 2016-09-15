<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaContratoDocumento extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contrato_documento', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('contrato_id')->unsigned();
			$table->foreign('contrato_id')->references('id')->on('contratos')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('documento_id')->unsigned();
			$table->foreign('documento_id')->references('id')->on('documentos')
				->onUpdate('cascade')->onDelete('cascade');
			$table->string('nombre');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contrato_documento');
	}

}
