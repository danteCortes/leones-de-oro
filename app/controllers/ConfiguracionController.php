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
			//Verificamos si la persona ya existe con ese dni.
			$persona = Persona::find(Input::get('dni'));
			if($persona){
				//Si la persona existe guardamos sus datos como usuario.
				$usuario = new Usuario;
				$usuario->persona_dni = Input::get('dni');
				$usuario->password = Hash::make(Input::get('password'));
				$usuario->nivel = 0;
				$usuario->save();
			}else{
				//Si no existe guardamos sus datos como persona y como usuario.
				$persona = new Persona;
				$persona->dni = Input::get('dni');
				$persona->nombre = mb_strtoupper(Input::get('nombre'));
				$persona->apellidos = mb_strtoupper(Input::get('apellidos'));
				$persona->direccion = mb_strtoupper(Input::get('direccion'));
				$persona->telefono = mb_strtoupper(Input::get('telefono'));
				$persona->save();

				$usuario = new Usuario;
				$usuario->persona_dni = Input::get('dni');
				$usuario->password = Hash::make(Input::get('password'));
				$usuario->nivel = 0;
				$usuario->save();
			}
			//Mostramos la vista de configuracion terminada.
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