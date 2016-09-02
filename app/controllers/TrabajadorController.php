<?php

class TrabajadorController extends BaseController{

	public function getInicio($ruc){

		$empresa = Empresa::find($ruc);
		$trabajadores = $empresa->trabajadores;
		return View::make('trabajador.inicio')->with('trabajadores', $trabajadores)
			->with('empresa', $empresa);
	}

	public function postContratar(){
		
		$persona = $this->guardarPersona(Input::get('dni'), Input::get('nombre'), Input::get('apellidos'),
			Input::get('direccion'), Input::get('telefono'));

		$trabajador = new Trabajador;
		$trabajador->persona_dni = Input::get('dni');
		$trabajador->empresa_ruc = Input::get('empresa');
		$trabajador->cuenta = Input::get('cuenta');
		$trabajador->banco = strtoupper(Input::get('banco'));
		$trabajador->save();

		$mensaje = "EL TRABAJADOR FUE CONTTRATADO CON EXITO.";
		return Redirect::to('trabajador/inicio/'.Input::get('empresa'))->with('verde', $mensaje);
	}

	public function getVer($id){
		return "Por modificar";
	}

	public function getEditar($id){
		return "Por modificar";
	}

	public function getBorrar($id){
		return "Por modificar";
	}

	private function guardarPersona($dni, $nombre, $apellidos, $direccion, $telefono){

		$persona = new Persona;
		$persona->dni = $dni;
		$persona->nombre = strtoupper($nombre);
		$persona->apellidos = strtoupper($apellidos);
		$persona->direccion = strtoupper($direccion);
		$persona->telefono = strtoupper($telefono);
		$persona->save();

		return $persona;
	}
}