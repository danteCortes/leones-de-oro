<?php

class PagoController extends BaseController{

  //Funcion para mostrar la vista que genera el reporte de asistencia.
  public function getReporte($ruc){
    $empresa = Empresa::find($ruc);
    return View::make('pago.reporte')->with('empresa', $empresa);
  }

  //Funcion para exportar la asistencia de un mes de una empresa a pdf
  public function getPdf(){
    return "planilla de pagos";
    function diferencia($entero){
      $hora = (int)($entero/3600);
      $minutos = (int)($entero/60);
      $segundos = ($entero%3600)%60;
      return $minutos."Min";
    }
    $mes = explode('/', Input::get('fecha'))[0];
    $anio = explode('/', Input::get('fecha'))[1];

    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $trabajadores = $empresa->trabajadores;

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
                                if ($registro->pivot->salida) {
                                  $salida = explode(':', $registro->pivot->salida);
                                  $salida = $salida[0]*3600 + $salida[1]*60 + $salida[2];
                                }else{
                                  $salida = $entrada;
                                }
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

  private function tiempoasegundos($tiempo){
    return explode(':', $tiempo)[0]*3600+explode(':', $tiempo)[1]*60+explode(':', $tiempo)[2];
  }

  private function diasdelmes($mes){
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
    return $dias;
  }
}