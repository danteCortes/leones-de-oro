<?php

class ContratoController extends BaseController{

	//muestra la vista de inicio de todos los contratos de una empresa
	//del sistema con su respectivo cliente.
	public function getInicio($ruc){

		$empresa = Empresa::find($ruc);
		//verificamos si la empresa existe. 
		if($empresa){
			//Si existe muestra la vista con todos sus contratos.
			$contratos = $empresa->contratos;
			return View::make('contrato.inicio')->with('contratos', $contratos)
				->with('empresa', $empresa);
		}else{
			//Si no existe nos regresa al panel principal.
			return Redirect::to('usuario/panel');
		}
	}

	//Muestra la vista para guardar un nuevo contrato.
	public function getNuevo($ruc){
		//verificamos si la empresa existe
		$empresa = Empresa::find($ruc);
		if($empresa){
			//Si la empresa existe mostramos la vista para ingersar los datos del contrato
			//junto con los datos de la empresa y sus clientes.
			$clientes = $empresa->clientes;
			return View::make('contrato.nuevo')->with('empresa', $empresa)
				->with('clientes', $clientes);
		}else{
			//si no existe regresamos al panel principal.
			return Redirect::to('usuario/panel');

		}
	}

	public function postBuscarRuc(){
		$nombre = Input::get('nombre');
		$empresa = Empresa::find(Input::get('empresa_ruc'));
		$clientes = $empresa->clientes;
		foreach ($clientes as $cliente) {
			if ($cliente->nombre == $nombre) {
				return Response::json($cliente);
			}
		}
		return 0;
	}

	//Funcion para guardar un nevo contrato.
	public function postNuevo($ruc){
		//verificamos la empresa que va a hacer el contrato.
		$empresa = Empresa::find($ruc);
		//verificamos el cliente con el que haremos el contrato.
		$cliente = Cliente::find(Input::get('ruc'));
		if ($cliente) {
			//Si existe el cliente, verificamos si es cliente de la empresa.
			if ($cliente->empresas()->find($empresa->ruc)) {
				//si es cliente verificamos que el archivo contrato es un pdf.
				if ($this->extencion(Input::file('contrato'))) {
					//si es un pdf procedemos a guardar los datos del contrato en la tabla contratos.
					$contrato = $this->guardarContrato($ruc, $cliente->ruc, 
						$this->formatoFecha(Input::get('inicio')), $this->formatoFecha(Input::get('fin')),
						Input::get('total'), Input::get('igv'));
					//luego guardamos el nombre del documento en la tabla contrato_documento y
					//el documento con el nombre cambiado en la carpeta public/documentos/contratos.
					$this->guardarDocumento(Input::file('contrato'), $contrato->id, 8);
					//Por ultimo regresamos a la vista de inicio de contratos con el mensaje satisfactorio de 
					//contrato guardado.
					$mensaje = "EL CONTRATO FUE GUARDADO CON EXITO.";
					return Redirect::to('contrato/inicio/'.$empresa->ruc)->with('verde', $mensaje);
				}else{
					//Si no es un archivo pdf, regresamos a la vista de nuevo contrato especificando que 
					//el archivo no tiene la extencion correcta y lo vuelva a intentar.
					$mensaje = "HUBO UN ERROR EN LA EXTENCION DEL ARCHIVO, AL PARECER NO ES UN DOCUMENTO 
					PDF, VUELVA A INTENTARLO CON EL DOCUMENTO CORRECTO.";
					return Redirect::to('contrato/nuevo/'.$empresa->ruc)->with('rojo', $mensaje);
				}
			}else{
				//Si no es cliente de la empresa, regresamos a la vista de nuevo contrato con un 
				//mensaje describiendo el error de que el cliente no es cliente de la empresa y
				//deberia guardarlo primero antes de hacer un contrato con el cliente.
				$mensaje = "HUBO UN ERROR CON EL CLIENTE, AL PARECER ESTE CLIENTE NO ES PARTE DE LA
				CARTERA DE CLIENTES DE ESTA EMPRESA, AGREGELO COMO CLIENTE DE ESTA EMPRESA ANTES DE 
				HACER UN CONTRATO CON ESTE.";
				return Redirect::to('contrato/nuevo/'.$empresa->ruc)->with('rojo', $mensaje);
			}
		}else{
			//si no existe el cliente, regresamos a la vista de nuevo contrato con un mensaje
			//describiendo el error en el ruc del cliente.
			$mensaje = "HUBO UN ERROR EN BUSCAR AL CLIENTE, VERIFIQUE EL RUC O EL NOMBRE DEL CLIENTE.";
			return Redirect::to('contrato/nuevo/'.$empresa->ruc)->with('rojo', $mensaje);
		}
	}

	//Función para ver los contratos y sus caracteristicas como adendas y retenciones.
	public function getMostrar($id){
		//Buscamos el contrato por medio del argumento pasado $id y mostramos la vista mostrar
		//contrato con los datos del contrato.
		$contrato = Contrato::find($id);
		return View::make('contrato.mostrar')->with('contrato', $contrato);
	}

	//funcion para darle formato a la fecha de dd-mm-yyyy a yyyy-mm-dd para 
	//guardarlo en la base de datos.
	private function formatoFecha($fecha){
		return substr($fecha, 6, 4)."-".substr($fecha, 3, 2)."-".substr($fecha, 0, 2);
	}

	//Funcion para saber si la extencion de un archivo es pdf. devuelve verdadero o falso.
	private function extencion($archivo){
		//separamos el nombre del archivo original en subcadenas separadas por el punto.
		$extencion = explode('.', trim($archivo->getClientOriginalName()));
		//obtenemos la ultima subcadena despues del ultimo punto la que seria la extencion 
		//del archivo.
		$extencion = $extencion[count($extencion)-1];
		//verificamos si esta subcadena es pdf o PDF
		if ($extencion == 'pdf' || $extencion == 'PDF') {
			//si es pdf o PDF retirnamos true.
			return true;
		}else{
			//si no se pdf o PDF retornamos false.
			return false;
		}
	}

	//Función para guardar un registro en la tabla contratos y retornar el mismo contrato.
	private function guardarContrato($empresa_ruc, $cliente_ruc, $inicio, $fin, $total, $igv){
		$contrato = new Contrato;
		$contrato->empresa_ruc = $empresa_ruc;
		$contrato->cliente_ruc = $cliente_ruc;
		$contrato->inicio = $inicio;
		$contrato->fin = $fin;
		$contrato->total = $total;
		$contrato->igv = $igv;
		$contrato->save();
		return Contrato::find($contrato->id);
	}

	//Función para guardar los documentos de un contrato.
	private function guardarDocumento($archivo, $contrato_id, $documento_id){
		//obtenemos la extencion del archivo original.
		$extencion = explode('.', trim($archivo->getClientOriginalName()));
		$extencion = $extencion[count($extencion)-1];
		//obtenemos el tipo de documento que se va a guardar.
		$documento = Documento::find($documento_id);
		//guardamos el documento en la carpeta public/documentos/contratos con su nombre cambiado.
		$archivo->move("documentos/contratos", $contrato_id.$documento->nombre."."
			.$extencion);
		//obtenemos los datos del contrato.
		$contrato = contrato::find($contrato_id);
		//verificamos si el contrato ya tiene guardado un documento del mismo tipo en la 
		//tabla contrato_documento.
		if (!$contrato->documentos()->find($documento_id)) {
			//Si no lo tiene guardamos el nuevo registro del documento con el contrato y el
			//nombre del documento segun el tipo.
			$contrato->documentos()->attach($documento_id, array('nombre'=>$contrato->id
				.$documento->nombre.'.'.$extencion));
		}
	}

}