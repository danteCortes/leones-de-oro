<?php

class AsistenciaController extends BaseController{

  public function getRegistrar($id){

    $trabajador = Trabajador::find($id);
    return View::make('asistencia.registrar')->with('trabajador', $trabajador);
  }

  public function getPosicion(){
    $latitud = Input::get('latitud');
    $longitud = Input::get('longitud');
    $punto = Punto::find(Input::get('punto'));
    $cliente = $punto->contrato->cliente;
    $trabajador = Trabajador::find(Input::get('trabajador_id'));
    //verificamos si el trabajador esta relacionado con ese punto.
    if ($trabajador->puntos()->find(Input::get('punto'))) {
      //si esta relacionado, verificamos que esta en el punto.
      if($latitud <= $punto->latitud+0.0002 && $latitud >= $punto->latitud-0.0002 &&
        $longitud <= $punto->longitud+0.0002 && $longitud >= $punto->longitud-0.0002){
        return $punto->contrato->cliente;
      }else{
        return 0;
      }
    }else{
      return 0;
    }
  }

  public function postRegistrar(){
    //verificamos si ya existe una asistencia abierta en este punto de trabajo.
    $asistencia = Asistencia::where('fecha', '=', date('Y-m-d'))->where('punto_id',
      '=', Input::get('punto_id'))->where('turno_id', '=', Input::get('turno_id'))->first();
    if ($asistencia) {
      //si la asistencia ya esta abierta para el dia de hoy, verificamos si se va a 
      //registrar entrada o salida.
      if(Input::get('registro') == 1){
        //Si se registra entrada, verificamos si no registró su entrada el dia de hoy.
        if($asistencia->trabajadores()->find(Input::get('trabajador_id'))){
          //si ya registro su entrada lo redirecciona a una pagina con el error.
          $mensaje = "YA REGISTRO SU ENTRADA EL DIA DE HOY A LAS ".date('h:i:s', 
            strtotime($asistencia->trabajadores()->find(Input::get('trabajador_id'))
            ->entrada));
          return Redirect::to('asistencia/registrar/'.Input::get('trabajador_id'))
            ->with('rojo', $mensaje);
        }else{
          //Si aun no registra su entrada, registramos su entrada para este dia este punto de 
          //trabajo.
          $asistencia->trabajadores()->attach(Input::get('trabajador_id'), 
          array('entrada'=>date('H:i:s')));
        }
      }else{
        //Si se registra salida, verificamos si registró entrada.
        if($asistencia->trabajadores()->find(Input::get('trabajador_id'))){
          //si ya registro su entrada verificamos si registro su salida.
          $salida = $asistencia->trabajadores()->find(Input::get('trabajador_id'));
          if ($salida->salida) {
            //si registró su salida redireccionamos al inicio con su mensaje correspondiente.
            $mensaje = "YA REGISTRO SU SALIDA EL DIA DE HOY A LAS ".$salida->salida;
            return Redirect::to('asistencia/registrar/'.Input::get('trabajador_id'))
              ->with('rojo', $mensaje);
          }else{
            //Si aún no registra su salida, registramos su salida.
            $asistencia->trabajadores()->updateExistingPivot(Input::get('trabajador_id'), 
            array('salida'=>date('H:i:s')));
          }
        }else{
          //Si aun no registra su entrada, registramos su entrada para este dia este punto de 
          //trabajo.
          $mensaje = "AUN NO REGISTRA SU ENTRADA EL DIA DE HOY.";
          return Redirect::to('asistencia/registrar/'.Input::get('trabajador_id'))
            ->with('rojo', $mensaje);
        }
      }

    }else{
      //Si no existe, creamos la asistencia para este dia y este punto de trabajo.
      $asistencia = new Asistencia;
      $asistencia->punto_id = Input::get('punto_id');
      $asistencia->turno_id = Input::get('turno_id');
      $asistencia->fecha = date('Y-m-d');
      $asistencia->save();
      //registramos la entrada del trabajador para esta asistencia.
      $asistencia->trabajadores()->attach(Input::get('trabajador_id'), 
        array('entrada'=>date('H:i:s')));
    }
    //nos redireccionamos a una ruta que nos mostrara el estado de nuestro registro.
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

  public function getError(){
    return View::make('asistencia.error');
  }
}