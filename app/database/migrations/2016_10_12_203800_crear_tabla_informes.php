<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaInformes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('informes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('usuario_id')->unsigned()->nullable();
			$table->foreign('usuario_id')->references('id')->on('usuarios')
				->onUpdate('cascade')->onDelete('set null');
			$table->string('empresa_ruc', 11);
			$table->foreign('empresa_ruc')->references('ruc')->on('empresas')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('remite')->unsigned()->nullable();
			$table->foreign('remite')->references('id')->on('usuarios')
				->onUpdate('cascade')->onDelete('set null');
			$table->integer('area_id')->unsigned()->nullable();
			$table->foreign('area_id')->references('id')->on('areas')
				->onUpdate('cascade')->onDelete('set null');
			$table->string('anio');
			$table->string('fecha');
			$table->integer('numero')->unsigned();
			$table->string('codigo');
			$table->string('destinatario');
			$table->string('cargo');
			$table->string('asunto');
			$table->string('contenido', 23552);
			$table->date('redaccion');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('informes');
	}

}
