<?php

class DocumentoController extends \BaseController {

	public function index(){

		$documentos = Documento::all();
		return View::make('documento.inicio')->with('documentos', $documentos);
	}

	public function store(){
		
		$documento = new Documento;
		$documento->nombre = strtoupper(Input::get('nombre'));
		$documento->save();

		$mensaje = "NUEVO TIPO DE DOCUMENTO CREADO.";
		return Redirect::to('documento')->with('verde', $mensaje);
	}

	public function destroy($id){

		if (Hash::check(Input::get('password'), Auth::user()->password)) {

			if ($id != 8) {
				
				$documento = Documento::find($id);
				$documentos = $documento->trabajadores;
				foreach ($documentos as $registro) {
					
					File::delete('documentos/documentos/'.$registro->pivot->nombre);
				}

				$documento->delete();

				$mensaje = "SE BORRO EL TIPO DE DOCUMENTO";
				return Redirect::to('documento')->with('naranja', $mensaje);
			}else{

				$mensaje = "ESTE DOCUMENTO ES OBLIGATORIO PARA TODOS LOS TRABAJADORES, NO SE 
				PUEDE ELIMINAR.";
				return Redirect::to('documento')->with('rojo', $mensaje);
			}
			
		}else{

			$mensaje = "LA CONTRASEÑA ES INCORRECTA, VUELVA A INTENTARLO.";
			return Redirect::to('documento')->with('rojo', $mensaje);
		}
	}


}
