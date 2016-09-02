<?php

class UsuarioController extends BaseController{

	public function __construct(){

        $this->beforeFilter('auth', array('except' => 'postLoguearse'));
    }

	public function postLoguearse(){
		
		$password = Input::get('password');
		$dni = Input::get('dni');
		$recordarme = Input::get('recordarme');
		if (Auth::attempt(array('persona_dni'=>$dni, 'password'=>$password), $recordarme)) {
			return Redirect::intended('usuario/panel');
		}else{
			$mensaje = "EL DNI O CONTRASEÑA SON ERRONEOS, INTENTE DE NUEVO.";
			return Redirect::to('/')->with('rojo', $mensaje);
		}
	}

	public function getPanel(){
		return View::make('inicio.panel');
	}

	public function getSalir(){
		Auth::logout();
		$mensaje = "CERRO SESION SATISFACTORIAMENTE, PUEDE CERRAR EL SISTEMA.";
		return Redirect::to('/')->with('verde', $mensaje);
	}

	public function getContrasenia(){
		return View::make('usuario.contrasenia');
	}

	public function postContrasenia(){
		if (Hash::check(Input::get('actual'), Auth::user()->password)) {
			if(Input::get('nueva') == Input::get('confirmar')){
				$usuario = Usuario::find(Auth::user()->id);
				$usuario->password = Hash::make(Input::get('nueva'));
				$usuario->save();
				Auth::logout();
				$mensaje = "SU CONTRASEÑA FUE CAMBIADA CON EXITO. INICIE SESION CON SU NUEVA CONTRASEÑA.";
				return Redirect::to('/')->with('verde', $mensaje);
			}else{
				$mensaje = "LAS NUEVAS CONTRASEÑAS NO COINCIDEN, PRUEBE DE NUEVO.";
				return Redirect::to('usuario/contrasenia')->with('rojo', $mensaje);
			}
		}else{
			$mensaje = "LA CONTRASEÑA ACTUAL ES INCORRECTA, PRUEBE DE NUEVO.";
			return Redirect::to('usuario/contrasenia')->with('rojo', $mensaje);
		}
	}
}