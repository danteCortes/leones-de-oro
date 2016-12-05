<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDescuentoTrabajador extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('descuento_trabajador', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('descuento_id')->unsigned();
			$table->foreign('descuento_id')->references('id')->on('descuentos')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('trabajador_id')->unsigned();
			$table->foreign('trabajador_id')->references('id')->on('trabajadores')
				->onUpdate('cascade')->onDelete('cascade');
			$table->date('fecha');
			$table->double('monto');
			$table->string('descripcion')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('descuento_trabajador');
	}

}
