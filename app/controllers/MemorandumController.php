<?php

class MemorandumController extends BaseController {

	public function getInicio($ruc){

		$empresa = Empresa::find($ruc);
		if($empresa){
			$memorandums = Memorandum::where('empresa_ruc', '=', $ruc)->get();
			return View::make('memorandum.inicio')->with('memorandums', $memorandums)
				->with('empresa', $empresa);
		}else{
			return Redirect::to('usuario/panel');
		}
	}

	public function getNuevo($ruc){
		$empresa = Empresa::find($ruc);
		if($empresa){

			return View::make('memorandum.nuevo')->with('empresa', $empresa);
		}else{
			return Redirect::to('usuario/panel');
		}
	}

	public function postArea(){
		$usuario = Usuario::find(Input::get('usuario_id'));
		$empresa = Empresa::find(Input::get('empresa_ruc'));
		$area = Area::find($empresa->usuarios()->find($usuario->id)->area_id);
		return Response::json($area);
	}
}
