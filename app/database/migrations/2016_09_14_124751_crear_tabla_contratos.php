<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaContratos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contratos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('empresa_ruc', 11);
			$table->foreign('empresa_ruc')->references('ruc')->on('empresas')
				->onUpdate('cascade')->onDelete('cascade');
			$table->string('cliente_ruc', 11);
			$table->foreign('cliente_ruc')->references('ruc')->on('clientes')
				->onUpdate('cascade')->onDelete('cascade');
			$table->date('inicio');
			$table->date('fin');
			$table->double('subtotal', 15, 2);
			$table->double('igv', 15, 2);
			$table->double('total', 15, 2);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contratos');
	}

}
