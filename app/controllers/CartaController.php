<?php

class CartaController extends BaseController{

	public function getInicio($ruc){

		$empresa = Empresa::find($ruc);
		if($empresa){
			$cartas = Carta::where('empresa_ruc', '=', $ruc)->get();
			return View::make('carta.inicio')->with('cartas', $cartas)
				->with('empresa', $empresa);
		}else{
			return Redirect::to('usuario/panel');
		}
	}

	public function getNuevo($ruc){
		$empresa = Empresa::find($ruc);
		if($empresa){
			$carta = new Carta;
			return View::make('carta.nuevo')->with('empresa', $empresa)->with('carta', $carta);
		}else{
			return Redirect::to('usuario/panel');
		}
	}
}