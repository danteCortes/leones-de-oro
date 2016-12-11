<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEmpresaPrendaTrabajadorUsuario extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empresa_prenda_trabajador_usuario', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('empresa_ruc', 11);
			$table->foreign('empresa_ruc')->references('ruc')->on('empresas')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('prenda_id')->unsigned();
			$table->foreign('prenda_id')->references('id')->on('prendas')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('trabajador_id')->unsigned();
			$table->foreign('trabajador_id')->references('id')->on('trabajadores')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('usuario_id')->unsigned()->nullable();
			$table->foreign('usuario_id')->references('id')->on('usuarios')
				->onUpdate('cascade')->onDelete('set null');
			$table->integer('cantidad_p')->unsigned();
			$table->integer('cantidad_s')->unsigned();
			$table->date('entrega');
			$table->date('devolucion')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('empresa_prenda_trabajador_usuario');
	}

}
