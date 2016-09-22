<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaRetenciones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('retenciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('contrato_id')->unsigned();
			$table->foreign('contrato_id')->references('id')->on('contratos')
				->onUpdate('cascade')->onDelete('cascade');
			$table->float('porcentaje');
			$table->integer('partes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('retenciones');
	}

}
