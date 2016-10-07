<?php

class CargoController extends \BaseController {

	public function index(){

		$cargos = Cargo::all();
		return View::make('cargo.inicio')->with('cargos', $cargos);
	}

	public function store(){
		
		$cargo = new Cargo;
		$cargo->nombre = strtoupper(Input::get('nombre'));
		$cargo->save();

		$mensaje = "NUEVO CARGO CREADO.";
		return Redirect::to('cargo')->with('verde', $mensaje);
	}

	public function destroy($id){
		
		if (Hash::check(Input::get('password'), Auth::user()->password)) {
			
			$cargo = Cargo::find($id);
			$cargo->delete();

			$mensaje = "SE BORRO EL CARGO.";
			return Redirect::to('cargo')->with('naranja', $mensaje);
		}else{

			$mensaje = "LA CONTRASEÑA ES INCORRECTA, VUELVA A INTENTARLO.";
			return Redirect::to('cargo')->with('rojo', $mensaje);
		}
	}
}
