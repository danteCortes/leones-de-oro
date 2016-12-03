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

  //Funcion para mostrar la vista que genera el reporte de asistencia.
  public function getReporte($ruc){
    $empresa = Empresa::find($ruc);
    return View::make('asistencia.reporte')->with('empresa', $empresa);
  }

  //Funcion para exportar la asistencia de un mes de una empresa a pdf
  public function getPdf(){
    function diferencia($entero){
      $hora = (int)($entero/3600);
      $minutos = (int)($entero/60);
      $segundos = ($entero%3600)%60;
      return $minutos."Min";
    }
    $mes = explode('/', Input::get('fecha'))[0];
    $anio = explode('/', Input::get('fecha'))[1];

    switch ($mes) {
      case '1':
      case '3':
      case '5':
      case '7':
      case '8':
      case '10':
      case '12':
        $dias = 31;
        break;

      case '4':
      case '6':
      case '9':
      case '11':
        $dias = 30;
        break;

      case '2':
        $dias = 29;
        break;
      
      default:
        break;
    }

    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $asistencias = Asistencia::where('fecha', '>=', $anio.'-'.$mes.'-01')
      ->where('fecha', '<=', $anio.'-'.$mes.'-'.$dias)->get();

    $html = "<!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
          <title> REPORTE DE ASISTENCIA ".Input::get('fecha')."</title>
          <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' 
            name='viewport'>
        </head>
        <body>
          <style type='text/css'>
            h1{
              font-size: 12pt;
              font-family: Cambria, Georgia, serif;
            }
            h2{
              font-size: 11pt;
              font-family: Cambria, Georgia, serif;
            }
            h3{
              font-size: 10pt;
              font-family: Cambria, Georgia, serif;
            }
            @page{
              margin-top: 1cm;
              margin-left: 1cm;
              margin-right: 1cm;
              margin-bottom: 1cm;
            }
            .borde-tabla {
              width: 100%;
              border-collapse: collapse;
              border: 1px solid #000000;
            }
            th, td {
              font-size: 8pt;
              font-family: Cambria, Georgia, serif;
              text-align: left;
              border: 1px solid #000000;
            }
          </style>
          <h1 align='center'>REPORTE DE ASISTENCIA ".Input::get('fecha')." ".$empresa->nombre."</h1>";
          foreach ($empresa->contratos as $contrato) {
            $html .= "<h2>CLIENTE: ".$contrato->cliente->nombre."</h2>";
            foreach ($contrato->puntos as $punto) {
              $html .= "<h3>PUNTO DE TRABAJO: ".$punto->nombre."</h3>
                <table class='borde-tabla'>
                  <tr>
                    <th>Trabajador</th>";
                    for ($i=1; $i <= $dias; $i++) { 
                      $html .= "<th>".$i."</th>";
                    }
                  $html .= "</tr>";
                  foreach ($punto->trabajadores as $trabajador) {
                    $html .= "<tr>
                      <td>".$trabajador->persona->nombre." ".$trabajador->persona->apellidos."</td>";
                      for ($i=1; $i <= $dias; $i++) { 
                        $html .= "<td>"; 
                        foreach ($asistencias as $asistencia) {
                          if (date('d', strtotime($asistencia->fecha)) == $i && 
                            $asistencia->punto_id == $punto->id) {
                            foreach ($asistencia->trabajadores as $registro) {
                              if ($registro->id == $trabajador->id) {
                                $entradaLegal = explode(':', Turno::find($asistencia->turno_id)->entrada);
                                $entradaLegal = $entradaLegal[0]*3600 + $entradaLegal[1]*60 + $entradaLegal[2];
                                $salidaLegal = explode(':', Turno::find($asistencia->turno_id)->salida);
                                $salidaLegal = $salidaLegal[0]*3600 + $salidaLegal[1]*60 + $salidaLegal[2];
                                $entrada = explode(':', $registro->pivot->entrada);
                                $entrada = $entrada[0]*3600 + $entrada[1]*60 + $entrada[2];
                                $salida = explode(':', $registro->pivot->salida);
                                $salida = $salida[0]*3600 + $salida[1]*60 + $salida[2];
                                $tardanza = 0;
                                if ($entrada > $entradaLegal) {
                                  $tardanza += $entrada-$entradaLegal;
                                }
                                if ($salida < $salidaLegal) {
                                  $tardanza += $salidaLegal-$salida;
                                }
                                $html .= $registro->pivot->entrada."<br>".$registro->pivot->salida.
                                "<br>".diferencia($tardanza);
                              }
                            }
                            break;
                          }
                        }
                        $html .= "</td>";
                      }
                    $html .= "</tr>";
                  }
                $html .= "</table><br>";
            }
          }

           $html .= "
        </body>
      </html>";

    $pdf = PDF::loadHtml($html);
    
    return $pdf->setPaper('a4')->setOrientation('landscape')
    ->download("REPORTE DE ASISTENCIA "
      .Input::get('fecha')." ".$empresa->nombre.".pdf");
  }
}