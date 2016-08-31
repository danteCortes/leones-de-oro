<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LlenarTablaPrendas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('prendas', function(Blueprint $table)
		{
			$prenda = new Prenda;
			$prenda->nombre = "PANTALON";
			$prenda->talla = "M";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "PANTALON";
			$prenda->talla = "L";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "PANTALON";
			$prenda->talla = "XL";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "CAMISA";
			$prenda->talla = "M";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "CAMISA";
			$prenda->talla = "L";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "CAMISA";
			$prenda->talla = "XL";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "BIRRETE";
			$prenda->talla = "M";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "BIRRETE";
			$prenda->talla = "L";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "BIRRETE";
			$prenda->talla = "XL";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "CORBATA";
			$prenda->talla = "UNICA";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "CHOMPA";
			$prenda->talla = "UNICA";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "CAPOTIN";
			$prenda->talla = "UNICA";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "BORCEQUIES";
			$prenda->talla = "40";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "BORCEQUIES";
			$prenda->talla = "41";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "BORCEQUIES";
			$prenda->talla = "42";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "BORCEQUIES";
			$prenda->talla = "43";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "VARA";
			$prenda->talla = "UNICA";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "LINTERNA";
			$prenda->talla = "UNICA";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "CINTURON";
			$prenda->talla = "UNICA";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "RADIO/CELURAR";
			$prenda->talla = "UNICA";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "SILBATO";
			$prenda->talla = "UNICA";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "CHAQUETA";
			$prenda->talla = "M";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "CHAQUETA";
			$prenda->talla = "L";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "POLO";
			$prenda->talla = "M";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "POLO";
			$prenda->talla = "L";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "ZAPATILLAS";
			$prenda->talla = "36";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "ZAPATILLAS";
			$prenda->talla = "37";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "ZAPATILLAS";
			$prenda->talla = "38";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "ZAPATILLAS";
			$prenda->talla = "39";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "ZAPATILLAS";
			$prenda->talla = "40";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "ZAPATILLAS";
			$prenda->talla = "41";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "ZAPATILLAS";
			$prenda->talla = "42";
			$prenda->save();

			$prenda = new Prenda;
			$prenda->nombre = "BOTAS DE JEBE";
			$prenda->talla = "UNICA";
			$prenda->save();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('prendas', function(Blueprint $table)
		{
			//
		});
	}

}
