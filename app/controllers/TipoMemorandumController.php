<?php

class TipoMemorandumController extends \BaseController {

  public function index(){

    $tipos = TipoMemorandum::all();
    return View::make('tipomemorandum.inicio')->with('tipos', $tipos);
  }

  public function store(){
    
    $tipo = new TipoMemorandum;
    $tipo->nombre = strtoupper(Input::get('nombre'));
    $tipo->save();

    $mensaje = "NUEVO TIPO DE MEMORANDUM CREADO.";
    return Redirect::to('tipoMemorandum')->with('verde', $mensaje);
  }

  public function destroy($id){
    
    if (Hash::check(Input::get('password'), Auth::user()->password)) {
      
      $tipo = TipoMemorandum::find($id);
      $tipo->delete();

      $mensaje = "SE BORRO EL TIPO DE MEMORANDUM.";
      return Redirect::to('tipoMemorandum')->with('naranja', $mensaje);
    }else{

      $mensaje = "LA CONTRASEÑA ES INCORRECTA, VUELVA A INTENTARLO.";
      return Redirect::to('tipoMemorandum')->with('rojo', $mensaje);
    }
  }
}
