<?php

class AseguradoraController extends \BaseController {

	public function index()
	{
		$aseguradoras = Aseguradora::all();
		return View::make('aseguradora.inicio')->with('aseguradoras', $aseguradoras);
	}

	public function store()
	{
		$aseguradora = new Aseguradora;
		$aseguradora->nombre = mb_strtoupper(Input::get('nombre'));
		if (Input::get('chbOnp') == 1) {
			$aseguradora->fijo = Input::get('fijo');
		}else{
			$aseguradora->fondo = Input::get('fondo');
			$aseguradora->prima = Input::get('prima');
			$aseguradora->flujo = Input::get('flujo');
		}
		$aseguradora->save();

		$mensaje = "LA ASEGURADORA FUE INGRESADO CON EXITO.";
		return Redirect::to('aseguradora')->with('verde', $mensaje);
	}

	public function destroy($id)
	{
		if (Hash::check(Input::get('password'), Auth::user()->password)) {
			
			$aseguradora = Aseguradora::find($id);
			$aseguradora->delete();

			$mensaje = "SE BORRO LA ASEGURADORA.";
			return Redirect::to('aseguradora')->with('naranja', $mensaje);
		}else{

			$mensaje = "LA CONTRASEÑA ES INCORRECTA, VUELVA A INTENTARLO.";
			return Redirect::to('aseguradora')->with('rojo', $mensaje);
		}
	}


}
