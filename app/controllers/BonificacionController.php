<?php

class BonificacionController extends \BaseController {

  public function index(){
    $bonificaciones = Bonificacion::all();
    return View::make('bonificacion.inicio')->with('bonificaciones', $bonificaciones);
  }

  public function store(){
    $bonificacion = new Bonificacion;
    $bonificacion->nombre = mb_strtoupper(Input::get('nombre'));
    $bonificacion->porcentaje = Input::get('porcentaje');
    $bonificacion->fijo = Input::get('fijo');
    $bonificacion->save();

    $mensaje = "NUEVO TIPO DE BONIFICACIÓN CREADO.";
    return Redirect::to('bonificacion')->with('verde', $mensaje);
  }

  public function destroy($id){
    if (Hash::check(Input::get('password'), Auth::user()->password)) {
        
      $bonificacion = Bonificacion::find($id);
      $bonificacion->delete();

      $mensaje = "SE BORRO EL TIPO DE BONIFICACIÓN";
      return Redirect::to('bonificacion')->with('naranja', $mensaje);
      
    }else{

      $mensaje = "LA CONTRASEÑA ES INCORRECTA, VUELVA A INTENTARLO.";
      return Redirect::to('bonificacion')->with('rojo', $mensaje);
    }
  }


}
