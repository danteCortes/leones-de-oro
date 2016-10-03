<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaMemorandums extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('memorandums', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('usuario_id')->unsigned()->nullable();
			$table->foreign('usuario_id')->references('id')->on('usuarios')
				->onUpdate('cascade')->onDelete('set null');
			$table->integer('remite')->unsigned()->nullable();
			$table->foreign('remite')->references('id')->on('usuarios')
				->onUpdate('cascade')->onDelete('set null');
			$table->integer('area_id')->unsigned()->nullable();
			$table->foreign('area_id')->references('id')->on('areas')
				->onUpdate('cascade')->onDelete('set null');
			$table->string('empresa_ruc', 11);
			$table->foreign('empresa_ruc')->references('ruc')->on('empresas')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('trabajador_id')->unsigned()->nullable();
			$table->foreign('trabajador_id')->references('id')->on('trabajadores')
				->onUpdate('cascade')->onDelete('cascade');
			$table->string('asunto');
			$table->string('codigo');
			$table->integer('numero')->unsigned();
      $table->string('fecha');
			$table->date('redaccion');
			$table->string('contenido', 1024);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('memorandums');
	}

}
