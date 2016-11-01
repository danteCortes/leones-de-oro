<?php

class NumeracionController extends BaseController{

	public function getInicio(){
		$empresas = Empresa::all();
		return View::make('numeracion.inicio')->with('empresas', $empresas);
	}

	public function postCartas($ruc){
		if (Hash::check(Input::get('password'), Auth::user()->password)) {
			
			$empresa = Empresa::find($ruc);
			$variable = $empresa->variables()->where('anio', '=', date('Y'))->first();
			$cartas = $empresa->cartas;

			if ($variable) {
				foreach ($cartas as $carta) {
					File::delete('documentos/cartas/'.$ruc.'/'.$carta->numero.'.pdf');
		    	$carta->delete();
				}
				$variable->inicio_carta = Input::get('numeracion');
				$variable->save();
			}else{
				$variable = new Variable;
		    $variable->empresa_ruc = Input::get('empresa_ruc');
		    $variable->inicio_carta = Input::get('numeracion');
		    $variable->anio = date('Y');
		    $variable->save();
			}

			$mensaje = "SE CAMBIO EL INICIO DE LA NUMERACION EN LAS CARTAS.";
			return Redirect::to('numeracion/inicio')->with('verde', $mensaje);
		}else{
			$mensaje = "SU CONTRASEÑA ES ERRONEA, INTENTE NUEVAMENTE.";
			return Redirect::to('numeracion/inicio')->with('rojo', $mensaje);
		}
	}

	public function postMemorandums($ruc){
		if (Hash::check(Input::get('password'), Auth::user()->password)) {
			
			$empresa = Empresa::find($ruc);
			$variable = $empresa->variables()->where('anio', '=', date('Y'))->first();
			$memorandums = $empresa->memorandums;

			if ($variable) {
				foreach ($memorandums as $memorandum) {
					File::delete('documentos/memorandums/'.$ruc.'/'.$memorandum->numero.'.pdf');
		    	$memorandum->delete();
				}
				$variable->inicio_memorandum = Input::get('numeracion');
				$variable->save();
			}else{
				$variable = new Variable;
		    $variable->empresa_ruc = Input::get('empresa_ruc');
		    $variable->inicio_memorandum = Input::get('numeracion');
		    $variable->anio = date('Y');
		    $variable->save();
			}

			$mensaje = "SE CAMBIO EL INICIO DE LA NUMERACION EN LOS MEMORANDUMS.";
			return Redirect::to('numeracion/inicio')->with('verde', $mensaje);
		}else{
			$mensaje = "SU CONTRASEÑA ES ERRONEA, INTENTE NUEVAMENTE.";
			return Redirect::to('numeracion/inicio')->with('rojo', $mensaje);
		}
	}

	public function postInformes($ruc){
		if (Hash::check(Input::get('password'), Auth::user()->password)) {
			
			$empresa = Empresa::find($ruc);
			$variable = $empresa->variables()->where('anio', '=', date('Y'))->first();
			$informes = $empresa->informes;

			if ($variable) {
				foreach ($informes as $informe) {
					File::delete('documentos/informes/'.$ruc.'/'.$informe->numero.'.pdf');
		    	$informe->delete();
				}
				$variable->inicio_informe = Input::get('numeracion');
				$variable->save();
			}else{
				$variable = new Variable;
		    $variable->empresa_ruc = Input::get('empresa_ruc');
		    $variable->inicio_memorandum = Input::get('numero');
		    $variable->anio = date('Y');
		    $variable->save();
			}

			$mensaje = "SE CAMBIO EL INICIO DE LA NUMERACION EN LOS INFORMES.";
			return Redirect::to('numeracion/inicio')->with('verde', $mensaje);
		}else{
			$mensaje = "SU CONTRASEÑA ES ERRONEA, INTENTE NUEVAMENTE.";
			return Redirect::to('numeracion/inicio')->with('rojo', $mensaje);
		}
	}

	public function postAnio($ruc){
		if (Hash::check(Input::get('password'), Auth::user()->password)) {
			
			$empresa = Empresa::find($ruc);
			$variable = $empresa->variables()->where('anio', '=', date('Y'))->first();

			if ($variable) {
				$variable->nombre_anio = mb_strtoupper(Input::get('anio'));
				$variable->save();
			}else{
				$variable = new Variable;
		    $variable->empresa_ruc = Input::get('empresa_ruc');
		    $variable->nombre_anio = mb_strtoupper(Input::get('anio'));
		    $variable->anio = date('Y');
		    $variable->save();
			}

			$mensaje = "SE CAMBIO EL NOMBRE DEL AÑO PARA ESTA EMPRESA.";
			return Redirect::to('numeracion/inicio')->with('verde', $mensaje);
		}else{
			$mensaje = "SU CONTRASEÑA ES ERRONEA, INTENTE NUEVAMENTE.";
			return Redirect::to('numeracion/inicio')->with('rojo', $mensaje);
		}
	}
}