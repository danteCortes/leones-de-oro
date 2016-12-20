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

  Route::resource('area', 'AreaController', array('only'=>array('index', 'store', 'destroy')));

  Route::resource('tipoMemorandum', 'TipoMemorandumController', array('only'=>array('index', 'store', 'destroy')));

  Route::controller('carta', 'CartaController');

  Route::controller('informe', 'InformeController');

  Route::controller('numeracion', 'NumeracionController');

  Route::controller('costo', 'CostoController');

  Route::resource('turno', 'TurnoController', array('only'=>array('index', 'store', 'destroy')));

  Route::resource('punto', 'PuntoController', array('only'=>array('store', 'destroy')));

  Route::controller('pago', 'PagoController');

  Route::resource('descuento', 'DescuentoController', array('only'=>array('index', 'store', 'destroy')));

  Route::controller('prenda', 'PrendaController');

  Route::controller('herramienta', 'HerramientaController');

  Route::resource('aseguradora', 'AseguradoraController', array('only'=>array('index', 'store', 'destroy')));

  Route::resource('bonificacion', 'BonificacionController', array('only'=>array('index', 'store', 'destroy')));

});

Route::controller('asistencia', 'AsistenciaController');

Route::controller('prueba', 'PruebaController');

Route::get('prueba2', function(){
  return URL::to('asistencia/registrar');
});