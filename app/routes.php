<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

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

	$html = "
	<html>
    <head>
      <meta charset='utf-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <title>CAS</title>
    </head>
	<body>"
            . "<p>Put your html here, or generate ñ it with your favourite "
            . "templating system.</p>"
            . "</body></html>";

	return PDF::load($html, 'A4', 'portrait')->show();
});