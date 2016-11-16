<?php

class TurnoController extends BaseController{

	public function index(){

		$turnos = Turno::all();
		return View::make('turno.inicio')->with('turnos', $turnos);
	}

	public function store(){
		
		$turno = new Turno;
		$turno->nombre = strtoupper(Input::get('nombre'));
		$turno->entrada = date('H:i:s', strtotime(Input::get('entrada')));
		$turno->salida = date('H:i:s', strtotime(Input::get('salida')));
		$turno->save();

		$mensaje = "NUEVO TURNO CREADO.";
		return Redirect::to('turno')->with('verde', $mensaje);
	}

	public function destroy($id){
		
		if (Hash::check(Input::get('password'), Auth::user()->password)) {
			
			$turno = Turno::find($id);
			$turno->delete();

			$mensaje = "SE BORRO EL TURNO.";
			return Redirect::to('turno')->with('naranja', $mensaje);
		}else{

			$mensaje = "LA CONTRASEÑA ES INCORRECTA, VUELVA A INTENTARLO.";
			return Redirect::to('turno')->with('rojo', $mensaje);
		}
	}
}