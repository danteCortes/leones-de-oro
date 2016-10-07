<?php

class AreaController extends \BaseController {

	public function index(){

		$areas = Area::all();
		return View::make('area.inicio')->with('areas', $areas);
	}

	public function store(){
		
		$area = new Area;
		$area->nombre = strtoupper(Input::get('nombre'));
		$area->abreviatura = strtoupper(Input::get('abreviatura'));
		$area->save();

		$mensaje = "NUEVA AREA CREADA.";
		return Redirect::to('area')->with('verde', $mensaje);
	}

	public function destroy($id){
		
		if (Hash::check(Input::get('password'), Auth::user()->password)) {
			
			$area = Area::find($id);
			$area->delete();

			$mensaje = "SE BORRO EL AREA.";
			return Redirect::to('area')->with('naranja', $mensaje);
		}else{

			$mensaje = "LA CONTRASEÑA ES INCORRECTA, VUELVA A INTENTARLO.";
			return Redirect::to('area')->with('rojo', $mensaje);
		}
	}
}
