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
    $trabajador = Trabajador::find(Input::get('trabajador_id'));
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
    $asistencia = Asistencia::where('fecha', '=', date('Y-m-d'))->where('cliente_ruc',
      '=', Input::get('cliente_ruc'))->first();
    
    if ($asistencia) {
      if(Input::get('registro') == 1){
        $asistencia->trabajadores()->attach(Input::get('trabajador_id'), 
        array('entrada'=>date('H:i:s')));
      }else{
        $asistencia->trabajadores()->updateExistingPivot(Input::get('trabajador_id'), 
        array('salida'=>date('H:i:s')));
      }

    }else{

      $asistencia = new Asistencia;
      $asistencia->cliente_ruc = Input::get('cliente_ruc');
      $asistencia->turno_id = Input::get('turno_id');
      $asistencia->fecha = date('Y-m-d');
      $asistencia->save();

      $asistencia->trabajadores()->attach(Input::get('trabajador_id'), 
        array('entrada'=>date('H:i:s')));

    }
    
    return Redirect::to('asistencia/estado/'.Input::get('trabajador_id').'/'.$asistencia->id);
  }

  public function getEstado($trabajador_id, $asistencia_id){
    $trabajador = Trabajador::find($trabajador_id);
    $asistencia = $trabajador->asistencias()->find($asistencia_id);

    return View::make('asistencia.estado')->with('asistencia', $asistencia);
  }

  public function getInicio(){
    return View::make('asistencia.inicio');
  }
}