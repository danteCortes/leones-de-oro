<?php

class MemorandumController extends BaseController{

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
			$trabajadores = $empresa->trabajadores;
			$memorandum = new Memorandum;
			return View::make('memorandum.nuevo')->with('empresa', $empresa)
				->with('trabajadores', $trabajadores)->with('memorandum', $memorandum);
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
    $memorandum->trabajador_id = Input::get('trabajador_id');
    $memorandum->asunto = strtoupper(Input::get('asunto'));
    $memorandum->razon = Input::get('razon');
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
			  <img src='documentos/membretes/".$memorandum->empresa_ruc.".jpg' width=100%>
				<h1 class='titulo' align='left'>".$memorandum->codigo."</h1><br>
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
						<td>:".Trabajador::find($memorandum->trabajador_id)->persona->nombre." ".
						Trabajador::find($memorandum->trabajador_id)->persona->apellidos."</td>
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
				<p>Atte.</p><br><br><br><br><br><p align='center'>
				___________________________<br>".
				Usuario::find($memorandum->remite)->persona->nombre."<br>".
				Usuario::find($memorandum->remite)->persona->apellidos."<br>".
				Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
					->area_id)->nombre."</p>
			</body>
		</html>
		";

		define('BUDGETS_DIR', public_path('documentos/memorandums/'.$empresa->ruc));

		if (!is_dir(BUDGETS_DIR)){
		    mkdir(BUDGETS_DIR, 0755, true);
		}

		$nombre = $memorandum->numero;
		$ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

		$pdf = PDF::loadHtml($html);
		$pdf->setPaper('a4')->save($ruta);

		$mensaje = "EL MEMORANDUM SE GUARDO PERFECTAMENTE. AHORA PUEDE IMPRIMIRLO.";
		return Redirect::to('memorandum/mostrar/'.$memorandum->id)->with('verde', $mensaje);
	}

	public function getMostrar($id){
		$memorandum = Memorandum::find($id);
		return View::make('memorandum.mostrar')->with('memorandum', $memorandum);
	}

	public function postNumeracion(){

		$memorandum = new Memorandum;
    $memorandum->empresa_ruc = Input::get('empresa_ruc');
    $memorandum->asunto = '';
    $memorandum->codigo = '';
    $memorandum->numero = Input::get('numero')-1;
    $memorandum->fecha = '';
    $memorandum->redaccion = date('Y-m-d');
    $memorandum->contenido = '';

    if($memorandum->save()){
    	return 1;
    }else{
    	return 0;
    }
	}

	public function postTrabajador(){
		$empresa = Empresa::find(Input::get('empresa_ruc'));
		$trabajadores = $empresa->trabajadores;

		foreach($trabajadores as $trabajador){
			
			if(Input::get('trabajador_nombre_apellidos') == $trabajador->persona->nombre." ".
				$trabajador->persona->apellidos){
				return $trabajador;
			}
		}
		return 0;
	}

	public function getEditar($id){
		$memorandum = Memorandum::find($id);
		$empresa = $memorandum->empresa;
		$trabajadores = $empresa->trabajadores;
		return View::make('memorandum.editar')->with('memorandum', $memorandum)
			->with('empresa', $empresa)->with('trabajadores', $trabajadores);
	}

	public function putEditar($id){
		if(Input::get('contenido') == ''){
			$mensaje = "EL CONTENIDO DEL MEMORANDUM NO DEBE SER VACIO. INTENTE NUEVAMENTE.";
			return Redirect::to('memorandum/editar/'.$id)
				->with('rojo', $mensaje);
		}
		
		$memorandum = Memorandum::find($id);

		$remite = Usuario::find(Input::get('remite'));
		$empresa = $memorandum->empresa;
		$usuario = Usuario::find(Auth::user()->id);
		$area = Area::find($remite->empresas()->find($empresa->ruc)->area_id);

		$codigo = 'MEMORANDUM Nº '.$memorandum->numero.'-'.date('Y', strtotime($memorandum->redaccion))
		.'/'.$area->abreviatura.'/'.$empresa->nombre;

		$memorandum->usuario_id = Auth::user()->id;
    $memorandum->remite = $remite->id;
    $memorandum->area_id = $area->id;
    $memorandum->trabajador_id = Input::get('trabajador_id');
    $memorandum->asunto = strtoupper(Input::get('asunto'));
    $memorandum->razon = Input::get('razon');
    $memorandum->codigo = $codigo;
    $memorandum->fecha = strtoupper(Input::get('fecha'));
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
			  <img src='documentos/membretes/".$memorandum->empresa_ruc.".jpg' width=100%>
				<h1 class='titulo' align='left'>".$memorandum->codigo."</h1><br>
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
						<td>:".Trabajador::find($memorandum->trabajador_id)->persona->nombre." ".
						Trabajador::find($memorandum->trabajador_id)->persona->apellidos."</td>
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
				<p>Atte.</p><br><br><br><br><br><p align='center'>
				___________________________<br>".
				Usuario::find($memorandum->remite)->persona->nombre."<br>".
				Usuario::find($memorandum->remite)->persona->apellidos."<br>".
				Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
					->area_id)->nombre."</p>
			</body>
		</html>
		";

		define('BUDGETS_DIR', public_path('documentos/memorandums/'.$empresa->ruc));

		if (!is_dir(BUDGETS_DIR)){
		    mkdir(BUDGETS_DIR, 0755, true);
		}

		$nombre = $memorandum->numero;
		$ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

		$pdf = PDF::loadHtml($html);
		$pdf->setPaper('a4')->save($ruta);

		$mensaje = "EL MEMORANDUM SE EDITO PERFECTAMENTE. AHORA PUEDE IMPRIMIRLO.";
		return Redirect::to('memorandum/mostrar/'.$memorandum->id)->with('verde', $mensaje);
	}
}
