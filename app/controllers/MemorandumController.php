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
	
	public function postNuevo(){
		if(Input::get('contenido') == ''){
			$mensaje = "EL CONTENIDO DEL MEMORANDUM NO DEBE SER VACIO. INTENTE NUEVAMENTE.";
			return Redirect::to('memorandum/nuevo/'.Input::get('empresa_ruc'))
				->with('rojo', $mensaje);
		}

		$remite = Usuario::find(Input::get('remite'));
		$empresa = Empresa::find(Input::get('empresa_ruc'));
		$usuario = Usuario::find(Auth::user()->id);
		$area = Area::find($remite->empresas()->find($empresa->ruc)->area_id);

		if(Memorandum::where('empresa_ruc', '=', $empresa->ruc)->orderBy('numero', 'desc')
		  ->first()){
  			$nro = Memorandum::where('empresa_ruc', '=', $empresa->ruc)->orderBy('numero', 'desc')
  				->first()->numero + 1;
    }else{
      $nro = 1;
    }

		$codigo = 'MEMORANDUM Nº '.$nro.'-'.date('Y').'/'.$area->abreviatura.'/'.$empresa->nombre;
    
    $memorandum = new Memorandum;
    $memorandum->usuario_id = Auth::user()->id;
    $memorandum->remite = $remite->id;
    $memorandum->area_id = $area->id;
    $memorandum->empresa_ruc = $empresa->ruc;
    $memorandum->destinatario = strtoupper(Input::get('destinatario'));
    $memorandum->asunto = strtoupper(Input::get('asunto'));
    $memorandum->codigo = $codigo;
    $memorandum->numero = $nro;
    $memorandum->fecha = strtoupper(Input::get('fecha'));
    $memorandum->redaccion = date('Y-m-d');
    $memorandum->contenido = Input::get('contenido');
    $memorandum->save();

    $html = "
		<!DOCTYPE html>
		<html>
		<head>
			<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	  	<title>".$memorandum->codigo."</title>
	  	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' 
	  		name='viewport'>
		</head>
		<body>
		<style type='text/css'>
	  .titulo{
	    font-size: 20px;
	    font-family: monospace;
	  }
	  .borde{
	   border: 1px solid #000;
	   padding-left: 10px;
	   margin-left: 30%;
	  }
	  .cuerpo{
	    font-size: 14px;
	    font-family: monospace;
	  }
	  </style>
		<h1 class='titulo' align='center'>".$memorandum->codigo."</h1><br>
		<table>
			<tr valign=top>
				<td width=100 height=50><b>DE</b></td>
				<td>:".Usuario::find($memorandum->remite)->persona->nombre." ".
					Usuario::find($memorandum->remite)->persona->apellidos."<br> <b>".
					Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
						->area_id)->nombre."</b></td>
			</tr>
			<tr valign=top>
				<td height=30><b>A</b></td>
				<td>:".$memorandum->destinatario."</td>
			</tr>
			<tr valign=top>
				<td height=30><b>ASUNTO</b></td>
				<td>:".$memorandum->asunto."</td>
			</tr>
			<tr valign=top>
				<td height=30><b>FECHA</b></td>
				<td>:".$memorandum->fecha."</td>
			</tr>
		</table><hr>
		<p width=300>".$memorandum->contenido."
		</p>
		</body>
		</html>
		";

		define('BUDGETS_DIR', public_path('documentos/memorandums/'.$empresa->ruc)); // I define this in a constants.php file

		if (!is_dir(BUDGETS_DIR)){
		    mkdir(BUDGETS_DIR, 0755, true);
		}

		$outputName = $memorandum->numero; // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
		$pdfPath = BUDGETS_DIR.'/'.$outputName.'.pdf';
		File::put($pdfPath, PDF::load($html, 'A4', 'portrait')->output());

		$mensaje = "EL MEMORANDUM SE CREO CON EXITO.";
		return Redirect::to('memorandum/inicio/'.$empresa->ruc)->with('verde', $mensaje);
	}
}
