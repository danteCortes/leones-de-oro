<?php

class ClienteController extends \BaseController {

	public function index(){
		
		$clientes = Cliente::all();
		return View::make('cliente.inicio')->with('clientes', $clientes);
	}

	public function store(){

		$cliente = new Cliente;
		$cliente->ruc = Input::get('ruc');
		$cliente->nombre = strtoupper(Input::get('nombre'));
		$cliente->direccion = strtoupper(Input::get('direccion'));
		$cliente->telefono = Input::get('telefono');
		$cliente->contacto = strtoupper(Input::get('contacto'));
		$cliente->save();

		$mensaje = "EL CLIENTE FUE AGREGADO A LA LISTA DE CLIENTES CON EXITO.";
		return Redirect::to('cliente')->with('verde', $mensaje);
	}

	public function show($id){
		
		$cliente = Cliente::find($id);
		if ($cliente) {
			return View::make('cliente.mostrar')->with('cliente', $cliente);
		}else{
			return Redirect::to('cliente');
		}
	}

	public function update($id){

		$cliente = Cliente::find($id);
		$cliente->ruc = Input::get('ruc');
		$cliente->nombre = strtoupper(Input::get('nombre'));
		$cliente->direccion = strtoupper(Input::get('direccion'));
		$cliente->telefono = Input::get('telefono');
		$cliente->contacto = strtoupper(Input::get('contacto'));
		$cliente->save();

		$mensaje = "EL CLIENTE FUE MODIFICADO CON EXITO.";
		return Redirect::to('cliente')->with('naranja', $mensaje);
	}

	public function destroy($id){
		
		if (Hash::check(Input::get('password'), Auth::user()->password)) {
			$cliente = Cliente::find($id);
			$cliente->delete();

			$mensaje = "EL CLIENTE FUE ELIMINADO DEL REGISTRO DE CLIENTES.";
			return Redirect::to('cliente')->with('naranja', $mensaje);
		}else{
			$mensaje = "SU CONTRASEÑA ES INCORRECTA.";
			return Redirect::to('cliente')->with('rojo', $mensaje);
		}
	}


}
