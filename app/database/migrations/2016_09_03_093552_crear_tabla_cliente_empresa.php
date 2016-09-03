<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaClienteEmpresa extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cliente_empresa', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('cliente_ruc');
			$table->foreign('cliente_ruc')->references('ruc')->on('clientes')
				->onUpdate('cascade')->onDelete('cascade');
			$table->string('empresa_ruc');
			$table->foreign('empresa_ruc')->references('ruc')->on('empresas')
				->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cliente_empresa');
	}

}
