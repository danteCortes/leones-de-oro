<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEmpresaPrenda extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empresa_prenda', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('empresa_ruc', 11);
			$table->foreign('empresa_ruc')->references('ruc')->on('empresas')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('prenda_id')->unsigned();
			$table->foreign('prenda_id')->references('id')->on('prendas')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('cantidad')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('empresa_prenda');
	}

}
