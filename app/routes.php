<?php

Route::get('/', function(){
	
	$usuario = Usuario::all()->first();

	if ($usuario) {
		if (Auth::user()) {
			return Redirect::to('usuario/panel');
		}else{
			return View::make('inicio.login');
		}
	}else{
		return Redirect::to('configuracion/inicio');
	}
});

Route::controller('configuracion', 'ConfiguracionController');

Route::controller('usuario', 'UsuarioController');

Route::group(array('before' => 'auth'), function(){
	
	Route::resource('empresa', 'EmpresaController', array('except'=>array('create', 'show', 'edit')));

	Route::controller('cliente', 'ClienteController');

	Route::controller('trabajador', 'TrabajadorController');

	Route::resource('documento', 'DocumentoController', array('only'=>array('index', 'store', 'destroy')));

	Route::resource('cargo', 'CargoController', array('only'=>array('index', 'store', 'destroy')));

	Route::controller('contrato', 'ContratoController');

	Route::controller('memorandum', 'MemorandumController');
});

Route::get('prueba', function(){
	header("Location: http://dacruzvi.webcindario.com"); 
	$memorandum = Memorandum::find(14);

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
	<h1 class='titulo' align='center'>".$memorandum->codigo."</h1><br>
	<table>
		<tr valign=top>
			<td width=100 height=50><b>DE</b></td>
			<td>:".Usuario::find($memorandum->remite)->persona->nombre." ".
				Usuario::find($memorandum->remite)->persona->apellidos."<br> <b>".
				Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()
					->find($memorandum->remite)->area_id)->nombre."</b></td>
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
	<p>Atte.</p><br><br><br><br><br><p align='center'>
	___________________________<br>".
	Usuario::find($memorandum->remite)->persona->nombre."<br>".
	Usuario::find($memorandum->remite)->persona->apellidos."<br>".
	Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
					->area_id)->nombre."</p>
	</body>
	</html>
	";

	define('BUDGETS_DIR', public_path('documentos/memorandums/'.$memorandum->empresa_ruc));

	if (!is_dir(BUDGETS_DIR)){
	    mkdir(BUDGETS_DIR, 0755, true);
	}

	$nombre = $memorandum->numero;
	$ruta = 'documentos/memorandums/'.$memorandum->empresa_ruc.'/'.$nombre.'.pdf';
	

	$pdf = PDF::loadHtml($html);
	return $pdf->setPaper('a4')->save($ruta)->download($memorandum->codigo.'.pdf') ;
});