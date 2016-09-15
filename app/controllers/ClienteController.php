<?php

class ClienteController extends \BaseController {

	public function getInicio($ruc){
		
		$empresa = Empresa::find($ruc);
		$clientes = $empresa->clientes;
		return View::make('cliente.inicio')->with('clientes', $clientes)
			->with('empresa', $empresa);
	}

	public function postGuardar(){

		$cliente = Cliente::find(Input::get('ruc'));
		if (!$cliente) {
			$cliente = new Cliente;
			$cliente->ruc = Input::get('ruc');
			$cliente->nombre = strtoupper(Input::get('nombre'));
			$cliente->direccion = strtoupper(Input::get('direccion'));
			$cliente->telefono = Input::get('telefono');
			$cliente->contacto = strtoupper(Input::get('contacto'));
			$cliente->save();
		}

		$empresa = Empresa::find(Input::get('empresa'));

		if($empresa->clientes()->where('ruc', '=', Input::get('ruc'))->first()){
			
			$mensaje = "EL CLIENTE YA EXISTE EN ESTA EMPRESA, VERIFIQUE EL RUC";
			return Redirect::to('cliente/inicio/'.Input::get('empresa'))
				->with('rojo', $mensaje);
		}else{
			
			$empresa->clientes()->attach(Input::get('ruc'));

			$mensaje = "EL CLIENTE FUE AGREGADO A LA LISTA DE CLIENTES CON EXITO.";
			return Redirect::to('cliente/inicio/'.Input::get('empresa'))
				->with('verde', $mensaje);
		}

	}

	public function getMostrar($ruc){
		
		$cliente = Cliente::find($ruc);
		if ($cliente) {
			return View::make('cliente.mostrar')->with('cliente', $cliente);
		}else{
			return Redirect::to('cliente');
		}
	}

	public function putEditar($ruc){

		if ($ruc == Input::get('ruc')) {
			
			$cliente = Cliente::find($ruc);
			$cliente->nombre = strtoupper(Input::get('nombre'));
			$cliente->direccion = strtoupper(Input::get('direccion'));
			$cliente->telefono = Input::get('telefono');
			$cliente->contacto = strtoupper(Input::get('contacto'));
			$cliente->save();

			$mensaje = "EL CLIENTE FUE MODIFICADO CON EXITO.";
			return Redirect::to('cliente/inicio/'.Input::get('empresa'))
				->with('naranja', $mensaje);

		}else{

			$cliente = Cliente::find(Input::get('ruc'));
			if ($cliente) {

				$mensaje = "EL NUEVO RUC QUE DESEA INGRESAR YA ESTA EN USO CON OTRO CLIENTE.";
				return Redirect::to('cliente/inicio/'.Input::get('empresa'))
					->with('rojo', $mensaje);
			}else{

				$cliente = Cliente::find($ruc);
				$cliente->ruc = Input::get('ruc');
				$cliente->nombre = strtoupper(Input::get('nombre'));
				$cliente->direccion = strtoupper(Input::get('direccion'));
				$cliente->telefono = Input::get('telefono');
				$cliente->contacto = strtoupper(Input::get('contacto'));
				$cliente->save();

				$mensaje = "EL CLIENTE FUE MODIFICADO CON EXITO.";
				return Redirect::to('cliente/inicio/'.Input::get('empresa'))
					->with('naranja', $mensaje);
			}
		}
	}

	public function deleteBorrar($ruc){
		
		if (Hash::check(Input::get('password'), Auth::user()->password)) {
			$cliente = Cliente::find($ruc);
			if (count($cliente->empresas) > 1) {
				$cliente->empresas()->detach(Input::get('empresa'));
			}else{
				$cliente->delete();
			}
			
			$mensaje = "EL CLIENTE FUE ELIMINADO DEL REGISTRO DE CLIENTES.";
			return Redirect::to('cliente/inicio/'.Input::get('empresa'))->with('naranja', $mensaje);
		}else{
			$mensaje = "SU CONTRASEÑA ES INCORRECTA.";
			return Redirect::to('cliente/inicio/'.Input::get('empresa'))->with('rojo', $mensaje);
		}
	}


}
