<?php

class ConfiguracionController extends BaseController{

	public function getInicio(){
		return View::make('configuracion.inicio');
	}

	public function getUsuario(){
		return View::make('configuracion.usuario');
	}

	public function postUsuario(){

		if (Input::get('password') == Input::get('confirmar')) {
			$persona = new Persona;
			$persona->dni = Input::get('dni');
			$persona->nombre = strtoupper(Input::get('nombre'));
			$persona->apellidos = strtoupper(Input::get('apellidos'));
			$persona->direccion = strtoupper(Input::get('direccion'));
			$persona->telefono = strtoupper(Input::get('telefono'));
			$persona->save();

			$usuario = new Usuario;
			$usuario->persona_dni = Input::get('dni');
			$usuario->empresa_ruc = Input::get('empresa');
			$usuario->password = Hash::make(Input::get('password'));
			$usuario->nivel = 0;
			$usuario->save();

			return Redirect::to('configuracion/terminar/'.$usuario->id);
			
		}else{
			$mensaje = "LAS CONTRASEÑAS NO COINCIDEN, INTENTELO DE NUEVO.";
			return Redirect::to('configuracion/usuario')->with('rojo', $mensaje);
		}
	}

	public function getTerminar($id){
		$usuario = Usuario::find($id);
		return View::make('configuracion.terminar')->with('usuario', $usuario);
	}
}