<?php

class PagoController extends BaseController{

  //Funcion para mostrar la vista que genera el reporte de asistencia.
  public function getReporte($ruc){
    $empresa = Empresa::find($ruc);
    return View::make('pago.reporte')->with('empresa', $empresa);
  }

  //Funcion para exportar la asistencia de un mes de una empresa a pdf
  public function getPdf(){
    set_time_limit(600);

    $mes = explode('/', Input::get('fecha'))[0];
    $anio = explode('/', Input::get('fecha'))[1];

    $asistencias = Asistencia::where('fecha', '>=', $anio.'-'.$mes.'-01')
      ->where('fecha', '<=', $anio.'-'.$mes.'-'.$this->diasdelmes($mes))->get();

    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $trabajadores = Trabajador::with('persona')->where('empresa_ruc', '=', Input::get('empresa_ruc'))->get();
    //$trabajadores = $empresa->trabajadores;

    //$trabajadores = $trabajadores->chunk(20);

    return View::make('trabajador.pagos')->with('trabajadores', $trabajadores)->with('fecha', 
      Input::get('fecha'))->with('empresa', $empresa);

    $html = "<!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
          <title> PLANILLA DE PAGOS".Input::get('fecha')."</title>
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
              margin-left: 0.5cm;
              margin-right: 0.5cm;
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
            th{
              text-align: center;
            }
          </style>
          <h1 align='center'>PLANILLA DE PAGOS ".Input::get('fecha')." ".$empresa->nombre."</h1>
          <table class='borde-tabla'>
            <tr>
              <th rowspan='3'>DNI</th>
              <th rowspan='3'>TRABAJADOR</th>
              <th colspan='6'>REMUNERACIONES</th>
              <th colspan='9'>DESCUENTOS</th>
              <th rowspan='3'>TOTAL</th>
            </tr>
            <tr>
              <th rowspan='2'>SUELDO BASICO</th>
              <th rowspan='2'>ASIGNACIÓN FAMILIAR</th>
              <th colspan='2' rowspan='2'>HORAS EXTRAS</th>
              <th colspan='2'>BONIFICACIONES</th>
              <th colspan='3'>AFP</th>
              <th rowspan='2'>ONP</th>
              <th colspan='3'>FALTAS</th>
              <th colspan='2' rowspan='2'>TARDANZAS</th>
            </tr>
            <tr>
              <th>BE1</th>
              <th>BE2</th>
              <th>FONDO</th>
              <th>PRIMA</th>
              <th>FLUJO</th>
              <th>JUSTIFICADAS</th>
              <th>INJUSTIFICADAS</th>
              <th>SALUD</th>
            </tr>";
            foreach ($trabajadores as $trabajador) {
              $html .= "
              <tr>
                <td>".$trabajador->persona_dni."</td>
                <td>".$trabajador->persona->nombre." ".$trabajador->persona->apellidos."</td>
                <td>".$trabajador->sueldo."</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>";
            }

          $html .= "</table>
        </body>
      </html>";

    $pdf = PDF::loadHtml($html);

    //$pdf = PDF::loadView('trabajador.pagos', array('fecha'=>Input::get('fecha'), 
     // 'empresa'=>$empresa, 'trabajadores'=>$trabajadores));
    define('BUDGETS_DIR', public_path('documentos/asistencias/'.$empresa->ruc));

    if (!is_dir(BUDGETS_DIR)){
        mkdir(BUDGETS_DIR, 0755, true);
    }

    $ruta = BUDGETS_DIR.'/otro.pdf';

    $pdf->setPaper('a4')->setOrientation('landscape')
      ->save($ruta);

      return "inicio: ".$inicio."fin: ".date('H:i:s');

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