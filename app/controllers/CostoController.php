<?php

class CostoController extends BaseController{
  
  public function getInicio($ruc){
    $empresa = Empresa::find($ruc);
    if($empresa){
      $clientes = Cliente::all();
      $costos = Costo::where('empresa_ruc', '=', $ruc)->get();
      return View::make('costo.inicio')->with('costos', $costos)
        ->with('empresa', $empresa);
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function getNuevo($ruc){
    $empresa = Empresa::find($ruc);
    if($empresa){
      $clientes = $empresa->clientes()->get();
      $costo = new Costo;
      return View::make('costo.nuevo')->with('empresa', $empresa)->with('costo', $costo)
        ->with('clientes', $clientes);
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function postBuscarRuc(){
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $cliente = $empresa->clientes()->find(Input::get('ruc'));
    if($cliente){
      return $cliente;
    }else{
      return 0;
    }
  }

  public function postBuscarNombre(){
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $cliente = $empresa->clientes()->where('nombre', '=', Input::get('nombre'))->first();
    if($cliente){
      return $cliente;
    }else{
      return 0;
    }
  }
}