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

Route::resource('empresa', 'EmpresaController');

