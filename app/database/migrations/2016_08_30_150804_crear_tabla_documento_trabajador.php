<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDocumentoTrabajador extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documento_trabajador', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('documento_id')->unsigned();
			$table->foreign('documento_id')->references('id')->on('documentos')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('trabajador_id')->unsigned();
			$table->foreign('trabajador_id')->references('id')->on('trabajadores')
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
		Schema::drop('documento_trabajador');
	}

}
