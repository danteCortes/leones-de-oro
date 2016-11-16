<?php

class AsistenciaController extends BaseController{

  public function getRegistrar($id){

    $trabajador = Trabajador::find($id);
    return View::make('asistencia.registrar')->with('trabajador', $trabajador);
  }

  public function getPosicion(){
    $latitud = Input::get('latitud');
    $longitud = Input::get('longitud');
    $cliente = Cliente::find(Input::get('cliente_ruc'));
    $trabajador = Trabajador::find('trabajador_id');
    if ($cliente) {
      $trabajador = $cliente->trabajadores()->find(Input::get('trabajador_id'));
      if($trabajador){
        if($latitud <= $trabajador->latitud+0.0002 && $latitud >= $trabajador->latitud-0.0002 &&
          $longitud <= $trabajador->longitud+0.0002 && $longitud >= $trabajador->longitud-0.0002){
          
          return $cliente;
        }else{
          return 0;
        }
      }
    }else{
      return 0;
    }
  }

  public function postRegistrar(){
    foreach (Turno::all() as $turno) {
      if ($turno->entrada ) {
        # code...
      }
    }
    $asistencia = Asistencia::where('fecha', '=', date('Y-m-d'))->where('cliente_ruc',
      '=', Input::get('cliente_ruc'))->first();
    return $asistencia;
    if ($asistencia) {
      
    }else{

      $asistencia = new Asistencia;
      $asistencia->cliente_ruc = Input::get('cliente_ruc');
      $asistencia->
    }
    return $asistencia;
    return Input::get('cliente_ruc');
  }
}