<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaClienteTrabajador extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cliente_trabajador', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('trabajador_id')->unsigned();
			$table->foreign('trabajador_id')->references('id')->on('trabajadores')
				->onUpdate('cascade')->onDelete('cascade');
			$table->string('cliente_ruc', 11);
			$table->foreign('cliente_ruc')->references('ruc')->on('clientes')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('cargo_id')->unsigned();
			$table->foreign('cargo_id')->references('id')->on('cargos')
				->onUpdate('cascade')->onDelete('cascade');
			$table->string('unidad')->nullable();
			$table->double('latitud')->nullable();
			$table->double('longitud')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cliente_trabajador');
	}

}
