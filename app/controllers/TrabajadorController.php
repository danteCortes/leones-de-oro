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
					
					if ($this->guardarDocumento(Input::file('contrato'), $trabajador->id, 8)) {
				
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

					if ($this->guardarDocumento(Input::file('contrato'), $trabajador->id, 8)) {
				
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
					
				if ($this->guardarDocumento(Input::file('contrato'), $trabajador->id, 8)) {
			
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

				if ($this->guardarDocumento(Input::file('contrato'), $trabajador->id, 8)) {
			
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
		$empresa = $trabajador->empresa;
		$clientes = $empresa->clientes;
		return View::make('trabajador.mostrar')->with('trabajador', $trabajador)
			->with('empresa', $empresa)->with('clientes', $clientes);
	}

	public function postDocumentar(){

		if ($this->guardarDocumento(Input::file('archivo'), Input::get('trabajador_id')
			,Input::get('documento_id'))) {
			
			$mensaje = "EL ARCHIVO FUE GUARDADO CON EXITO.";
			return Redirect::to('trabajador/ver/'.Input::get('trabajador_id'))
				->with('verde', $mensaje);
		}else{

			$mensaje = "HUBO UN ERROR AL GUARDAR EL ARCHIVO. EL FORMATO DEL ARCHIVO DEBE SER .pdf 
			INTENTE NUEVAMENTE.";
			return Redirect::to('trabajador/ver/'.Input::get('trabajador_id'))
				->with('rojo', $mensaje);
		}
	}

	public function getEditar($id){

		$trabajador = Trabajador::find($id);
		return View::make('trabajador.editar')->with('trabajador', $trabajador);
	}

	public function putEditar($id){

		$trabajador = Trabajador::find($id);
		$persona = $trabajador->persona;
		if ($this->actualizarPersona($persona->dni, Input::get('dni'), Input::get('nombre'),
			Input::get('apellidos'), Input::get('direccion'), Input::get('telefono'))) {

			$this->actualizarTrabajador($id, $this->formatoFecha(Input::get('inicio')),
				$this->formatoFecha(Input::get('fin')), Input::get('cuenta'), Input::get('banco'));
			
			$mensaje = "LOS DATOS DEL TRABAJADOR SE ACTUALIZARON CON EXITO.";
			return Redirect::to('trabajador/inicio/'.$trabajador->empresa->ruc)->with('verde', $mensaje);
		}else{

			$mensaje = "EL DNI YA ESTA SIENDO USADO POR OTRO TRABAJADOR, CORRIJA EL ERROR E INTENTE NUEVAMENTE.";
			return Redirect::to('trabajador/inicio/'.$trabajador->empresa->ruc)->with('rojo', $mensaje);
		}
	}

	public function putFoto($id){

		if ($this->guardarFoto(Input::file('foto'), $id)) {
			
			$mensaje = "LA FOTO FUE ACTUALIZADA CON EXITO.";
			return Redirect::to("trabajador/editar/".$id)->with('verde', $mensaje);
		}else{

			$mensaje = "LA FOTO DEBE TENER EXTENCION .jpg, INTENTELO NUEVAMENTE.";
			return Redirect::to("trabajador/editar/".$id)->with('rojo', $mensaje);
		}
	}

	public function deleteBorrar($id){

		$trabajador = Trabajador::find($id);
		$empresa = $trabajador->empresa;
		$persona = $trabajador->persona;
		$documentos = $trabajador->documentos;
		if (Hash::check(Input::get('password'), Auth::user()->password)) {
			
			foreach ($documentos as $documento) {

				File::delete('documentos/documentos/'.$documento->pivot->nombre);
			}
			if ($trabajador->foto != 'usuario.jpg') {
				File::delete('documentos/fotos/'.$trabajador->foto);
			}

			$persona->delete();

			$mensaje = "EL TRABAJADOR FUE BORRADO JUNTO A TODOS SUS DOCUMENTOS.";
			return Redirect::to('trabajador/inicio/'.$empresa->ruc)->with('naranja', $mensaje);
		}else{

			$mensaje = "LA CONTRASEÑA INGRESADA ES INCORRECTA. VUELVA A INTENTARLO..";
			return Redirect::to('trabajador/inicio/'.$empresa->ruc)->with('rojo', $mensaje);
		}
	}

	public function postBuscarRuc(){
		$nombre = Input::get('nombre');
		$trabajador = Trabajador::find(Input::get('trabajador_id'));
		$empresa = $trabajador->empresa;
		$clientes = $empresa->clientes;
		foreach ($clientes as $cliente) {
			if ($cliente->nombre == $nombre) {
				return Response::json($cliente->ruc);
			}
		}
		return 0;
	}

	public function postCargo(){

		$cliente = Cliente::find(Input::get('ruc'));
		$trabajador = Trabajador::find(Input::get('trabajador_id'));
		if ($cliente) {
			
			$cliente->trabajadores()->attach($trabajador->id, array('unidad'=>Input::get('unidad'),
				'cargo_id'=>Input::get('cargo')));

			$mensaje = "EL TRABAJADOR FUE ASIGNADO A ".$cliente->nombre.".";
			return Redirect::to('trabajador/ver/'.$trabajador->id)->with('verde', $mensaje);
		}else{

			$mensaje = "HUBO UN ERROR CON EL CLIENTE, VUELVA A INTENTARLO";
			return Redirect::to('trabajador/ver/'.$trabajador->id)->with('rojo', $mensaje);
		}
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
		$trabajador->cuenta = strtoupper($cuenta);
		$trabajador->banco = strtoupper($banco);
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
		}else{
			return false;
		}
	}

	private function guardarDocumento($archivo, $trabajador_id, $documento_id){

		if ($archivo) {
			
			$extencion = explode('.', trim($archivo->getClientOriginalName()));
			$extencion = $extencion[count($extencion)-1];

			if ($extencion == 'pdf' || $extencion == 'PDF') {

				$documento = Documento::find($documento_id);
				
				$archivo->move("documentos/documentos", $trabajador_id.$documento->nombre."."
					.$extencion);

				$trabajador = Trabajador::find($trabajador_id);
				if (!$trabajador->documentos()->find($documento_id)) {
					
					$trabajador->documentos()->attach($documento_id, array('nombre'=>$trabajador->id
						.$documento->nombre.'.'.$extencion));
				}
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	private function formatoFecha($fecha){

		return substr($fecha, 6, 4)."-".substr($fecha, 3, 2)."-".substr($fecha, 0, 2);
	}

	private function actualizarPersona($id, $dni, $nombre, $apellidos, $direccion, $telefono){

		if ($id == $dni) {
			
			$persona = Persona::find($id);
			$persona->dni = $dni;
			$persona->nombre = strtoupper($nombre);
			$persona->apellidos = strtoupper($apellidos);
			$persona->direccion = strtoupper($direccion);
			$persona->telefono = strtoupper($telefono);
			$persona->save();

			return true;
		}else{

			$persona = Persona::find($dni);
			if ($persona) {
				
				return false;
			}else{

				$persona = Persona::find($id);
				$persona->dni = $dni;
				$persona->nombre = strtoupper($nombre);
				$persona->apellidos = strtoupper($apellidos);
				$persona->direccion = strtoupper($direccion);
				$persona->telefono = strtoupper($telefono);
				$persona->save();

				return true;
			}
		}
	}

	private function actualizarTrabajador($id, $inicio, $fin, $cuenta, $banco){

		$trabajador = Trabajador::find($id);
		$trabajador->inicio = $inicio;
		$trabajador->fin = $fin;
		$trabajador->cuenta = strtoupper($cuenta);
		$trabajador->banco = strtoupper($banco);
		$trabajador->save();

		return Trabajador::find($trabajador->id);
	}
}