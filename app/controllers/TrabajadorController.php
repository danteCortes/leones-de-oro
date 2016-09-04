<?php

class TrabajadorController extends BaseController{

	public function getInicio($ruc){

		$empresa = Empresa::find($ruc);
		$trabajadores = $empresa->trabajadores;
		return View::make('trabajador.inicio')->with('trabajadores', $trabajadores)
			->with('empresa', $empresa);
	}

	public function postContratar(){

		$persona = Persona::find(Input::get('dni'));
		if ($persona) {

			$trabajador = $persona->trabajador;
			if ($trabajador) {
				$empresa = $trabajador->empresa;
				$mensaje = "EL TRABAJADOR ESTA CONTRATADO EN LA EMPRESA ".$empresa->nombre.
					". ELIMINELO DE ESA EMPRESA PARA CONTRATARLO EN ESTA EMPRESA.";
				return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
					->with('rojo', $mensaje);
			}else{
				$trabajador = $this->guardarTrabajador($persona->dni, Input::get('empresa'),
					Input::get('inicio'), Input::get('fin'), Input::get('cuenta'),
					Input::get('banco'));

				if ($this->guardarFoto(Input::file('foto'), $trabajador->id)) {
					
					if ($this->guardarContrato(Input::file('contrato'), $trabajador->id)) {
				
						$mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO.";
						return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
							->with('verde', $mensaje);
					}else{

						$mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE INGRESAR SU 
							CONTRATO.";
						return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
							->with('naranja', $mensaje);
					}
				}else{

					if ($this->guardarContrato(Input::file('contrato'), $trabajador->id)) {
				
						$mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE ACTUALIZAR SU
							FOTO.";
						return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
							->with('naranja', $mensaje);
					}else{

						$mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE ACTUALIZAR SU
							FOTO E INGRESAR SU CONTRATO.";
						return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
							->with('naranja', $mensaje);
					}
				}
			}
		}else{

			$persona = $this->guardarPersona(Input::get('dni'), Input::get('nombre'),
				Input::get('apellidos'), Input::get('direccion'), Input::get('telefono'));

			$trabajador = $this->guardarTrabajador($persona->dni, Input::get('empresa'),
				$this->formatoFecha(Input::get('inicio')), $this->formatoFecha(Input::get('fin')),
				Input::get('cuenta'), Input::get('banco'));

			if ($this->guardarFoto(Input::file('foto'), $trabajador->id)) {
					
				if ($this->guardarContrato(Input::file('contrato'), $trabajador->id)) {
			
					$mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO.";
					return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
						->with('verde', $mensaje);
				}else{

					$mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE INGRESAR SU 
						CONTRATO.";
					return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
						->with('naranja', $mensaje);
				}
			}else{

				if ($this->guardarContrato(Input::file('contrato'), $trabajador->id)) {
			
					$mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE ACTUALIZAR SU
						FOTO.";
					return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
						->with('naranja', $mensaje);
				}else{

					$mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE ACTUALIZAR SU
						FOTO E INGRESAR SU CONTRATO.";
					return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
						->with('naranja', $mensaje);
				}
			}
		}
	}

	public function getVer($id){
		$trabajador = Trabajador::find($id);
		return View::make('trabajador.mostrar')->with('trabajador', $trabajador);
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

		return Persona::find($dni);
	}

	private function guardarTrabajador($persona_dni, $empresa_ruc, $inicio, $fin, $cuenta, $banco){

		$trabajador = new Trabajador;
		$trabajador->persona_dni = $persona_dni;
		$trabajador->empresa_ruc = $empresa_ruc;
		$trabajador->inicio = $inicio;
		$trabajador->fin = $fin;
		$trabajador->cuenta = $cuenta;
		$trabajador->banco = $banco;
		$trabajador->foto = "usuario.jpg";
		$trabajador->save();

		return Trabajador::find($trabajador->id);
	}

	private function guardarFoto($foto, $trabajador_id){

		if ($foto) {
			
			$extencion = explode('.', trim($foto->getClientOriginalName()));
			$extencion = $extencion[count($extencion)-1];

			if ($extencion == 'jpg' || $extencion == 'JPG') {
				
				$foto->move("documentos/fotos", $trabajador_id.".".$extencion);

				$trabajador = Trabajador::find($trabajador_id);
				$trabajador->foto = $trabajador_id.".".$extencion;
				$trabajador->save();
				return true;
			}else{
				return false;
			}
		}
	}

	private function guardarContrato($contrato, $trabajador_id){

		if ($contrato) {
			
			$extencion = explode('.', trim($contrato->getClientOriginalName()));
			$extencion = $extencion[count($extencion)-1];

			if ($extencion == 'pdf' || $extencion == 'PDF') {
				
				$contrato->move("documentos/contratos", $trabajador_id.".".$extencion);

				$trabajador = Trabajador::find($trabajador_id);
				$trabajador->documentos()->attach(8, array('nombre'=>$trabajador->id.'contrato.'.$extencion));
				return true;
			}else{
				return false;
			}
		}
	}

	private function formatoFecha($fecha){
		return substr($fecha, 6, 4)."-".substr($fecha, 3, 2)."-".substr($fecha, 0, 2);
	}
}