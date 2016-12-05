<?php

class DescuentoController extends BaseController{

	public function index(){

		$descuentos = Descuento::all();
		return View::make('descuento.inicio')->with('descuentos', $descuentos);
	}

	public function store(){
		
		$descuento = new Descuento;
		$descuento->nombre = strtoupper(Input::get('nombre'));
		$descuento->save();

		$mensaje = "NUEVO TIPO DE DESCUENTO CREADO.";
		return Redirect::to('descuento')->with('verde', $mensaje);
	}

	public function destroy($id){

		if (Hash::check(Input::get('password'), Auth::user()->password)) {
				
			$descuento = Descuento::find($id);
			$descuento->delete();

			$mensaje = "SE BORRO EL TIPO DE DESCUENTO";
			return Redirect::to('descuento')->with('naranja', $mensaje);
			
		}else{

			$mensaje = "LA CONTRASEÑA ES INCORRECTA, VUELVA A INTENTARLO.";
			return Redirect::to('descuento')->with('rojo', $mensaje);
		}
	}
}