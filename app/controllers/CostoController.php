<?php

class CostoController extends BaseController{
  
  public function getInicio($ruc){
    $empresa = Empresa::find($ruc);
    if($empresa){
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
      $costo = $empresa->costos()->where('estado', '=', 1)->first();
      if ($costo) {
        return View::make('costo.nuevo')->with('empresa', $empresa)->with('costo', $costo)
          ->with('clientes', $clientes);
      }else{
        $costo = new Costo;
        return View::make('costo.nuevo')->with('empresa', $empresa)->with('costo', $costo)
          ->with('clientes', $clientes);
      }
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function postGuardarConcepto(){
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $costo = $empresa->costos()->where('estado', '=', 1)->first();

    if(count($costo) == 0){
      $costo = $this->nuevoCosto(Input::get('empresa_ruc'), '', '', '', 0, 0, 0, '', '', 1);
    }

    $concepto = $this->nuevoConcepto($costo->id, Input::get('nombre'), 
      0, 0, 0, 0);
    
    if (Input::get('diurno') != 0) {
      $this->nuevoConceptoTurno(1, $concepto->id, Input::get('diurno'), Input::get('rmv'), 
        Input::get('asignacionfamiliar'), 0, Input::get('txt_st'),
        Input::get('descansero'), Input::get('feriados'), Input::get('gratificaciones'),
        Input::get('cts'), Input::get('vacaciones'), Input::get('essalud'), Input::get('txt_sctr'),
        Input::get('ueas'), Input::get('capacitacion'), Input::get('movilidad'), Input::get('refrigerio'),
        Input::get('gastosgenerales'), Input::get('utilidad'), Input::get('txt_igv'));
    }else{
      $this->nuevoConceptoTurno(1, $concepto->id, Input::get('diurno'), 0, 
        Input::get('asignacionfamiliar'), 0, Input::get('txt_st'),
        Input::get('descansero'), Input::get('feriados'), Input::get('gratificaciones'),
        Input::get('cts'), Input::get('vacaciones'), Input::get('essalud'), Input::get('txt_sctr'),
        0, 0, 0, 0, 0, 0, Input::get('txt_igv'));
    }

    if (Input::get('nocturno') != 0) {
      $this->nuevoConceptoTurno(2, $concepto->id, Input::get('nocturno'), Input::get('rmv'), 
      Input::get('asignacionfamiliar'), Input::get('jornadanocturna'), Input::get('txt_st'),
      Input::get('descansero'), Input::get('feriados'), Input::get('gratificaciones'),
      Input::get('cts'), Input::get('vacaciones'), Input::get('essalud'), Input::get('txt_sctr'),
      Input::get('ueas'), Input::get('capacitacion'), Input::get('movilidad'), Input::get('refrigerio'),
      Input::get('gastosgenerales'), Input::get('utilidad'), Input::get('txt_igv'));
    }else{
      $this->nuevoConceptoTurno(2, $concepto->id, Input::get('nocturno'), 0, 
      Input::get('asignacionfamiliar'), Input::get('jornadanocturna'), Input::get('txt_st'),
      Input::get('descansero'), Input::get('feriados'), Input::get('gratificaciones'),
      Input::get('cts'), Input::get('vacaciones'), Input::get('essalud'), Input::get('txt_sctr'),
      0, 0, 0, 0, 0, 0, Input::get('txt_igv'));
    }

    foreach ($concepto->turnos as $turno) {
      $concepto = $this->actualizarConcepto($concepto->id, $turno->pivot->puestos, $turno->pivot->subtotal,
        $turno->pivot->igv, $turno->pivot->total);
    }

    $costo = $this->actualizarCosto($costo->id, $concepto->subtotal, $concepto->igv, $concepto->total);
    
    $diurno = $concepto->turnos()->find(1);
    $nocturno = $concepto->turnos()->find(2);
    
    $subtotaldiurno = $diurno->sueldobasico+$diurno->asignacionfamiliar+
      $diurno->jornadanocturna+$diurno->sobretiempo1+$diurno->sobretiempo2;
    $subtotalnocturno = $nocturno->sueldobasico+$nocturno->asignacionfamiliar+
      $nocturno->jornadanocturna+$nocturno->sobretiempo1+$nocturno->sobretiempo2;

    $remuneracionesdiurno = $subtotaldiurno+$diurno->descansero+$diurno->feriados;
    $remuneracionesnocturno = $subtotalnocturno+$nocturno->descansero+$nocturno->feriados;

    $beneficiossocialesdiurno = $diurno->gratificaciones+$diurno->cts+$diurno->vacaciones;
    $beneficiossocialesnocturno = $nocturno->gratificaciones+$nocturno->cts+$nocturno->vacaciones;

    $contribucionessocialesdiurno = $diurno->essalud+$diurno->sctr;
    $contribucionessocialesnocturno = $nocturno->essalud+$nocturno->sctr;

    $manodeobradiurno = $remuneracionesdiurno+$beneficiossocialesdiurno+
      $contribucionessocialesdiurno;
    $manodeobranocturno = $remuneracionesnocturno+$beneficiossocialesnocturno+
      $contribucionessocialesnocturno;

    $implementosdiurno = $diurno->ueas+$diurno->capacitacion;
    $implementosnocturno = $nocturno->ueas+$nocturno->capacitacion;

    $viaticosdiurno = $diurno->movilidad+$diurno->refrigerio;
    $viaticosnocturno = $nocturno->movilidad+$nocturno->refrigerio;

    $html = "
      <!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
          <title> ESTRUCTURA DE COSTO DETALLADO ".$concepto->id."</title>
          <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' 
            name='viewport'>
        </head>
        <body>
          <style type='text/css'>
            *{
              font-size: 9pt;
              font-family: Cambria, Georgia, serif;
            }
            @page{
              margin-top: 5.5cm;
              margin-left: 3cm;
              margin-right: 2.5cm;
              margin-bottom: 3cm;
            }
            .borde-tabla {
              width: 100%;
              border-collapse: collapse;
              border: 1px solid #000000;
            }
            th, td {
              text-align: left;
              border: 1px solid #000000;
            }
          </style>
          <table class='borde-tabla'>
            <tr>
              <th colspan='4' align='center'>ESTRUCTURA MENSUAL DE COSTOS S/.</th>
            </tr>
            <tr>
              <th colspan='4' align='left'>NOMBRE DEL PUESTO: ".$concepto->nombre."</th>
            </tr>
            <tr>
              <th colspan='4'>NUMERO DE PUESTOS: ".$concepto->numero."</th>
            </tr>
            <tr>
              <th>CONCEPTO</th>
              <th>APLICACIÓN</th>
              <th>TURNO DIA</th>
              <th>TURNO NOCHE</th>
            </tr>
            <tr>
              <th>REMUNERACIONES:</th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
            <tr>
              <td>S. Sueldo Básico Mensual Mínimo (S/. ".$this->formatoMoneda(Input::get('rmv')).")</td>
              <td></td>
              <td align=right>".$this->formatoMoneda($diurno->sueldobasico)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->sueldobasico)."</td>
            </tr>
            <tr>
              <td>AF. Asiganción Familiar</td>
              <td>S*0.10</td>
              <td align=right>".$this->formatoMoneda($diurno->asignacionfamiliar)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->asignacionfamiliar)."</td>
            </tr>
            <tr>
              <td>JN. Bonificación por Jornada nocturna</td>
              <td>S*0.35</td>
              <td align=right>".$this->formatoMoneda($diurno->jornadanocturna)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->jornadanocturna)."</td>
            </tr>
            <tr>
              <td>ST. Pago de Sobretiempos</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td> -2 Primeras Horas al 25%</td>
              <td>(((((S+AF)*1.25)/30)/8)*26)*2 pri hrs</td>
              <td align=right>".$this->formatoMoneda($diurno->sobretiempo1)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->sobretiempo1)."</td>
            </tr>
            <tr>
              <td> -2 Segundas Horas al 35%</td>
              <td>(((((S+AF)*1.35)/30)/8)*26)*2 seg hrs</td>
              <td align=right>".$this->formatoMoneda($diurno->sobretiempo2)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->sobretiempo2)."</td>
            </tr>
            <tr>
              <th>SUBTOTAL</th>
              <th></th>
              <th align=right>".$this->formatoMoneda($subtotaldiurno)."</th>
              <th align=right>".$this->formatoMoneda($subtotalnocturno)."</th>
            </tr>
            <tr>
              <td>D. Descansero</td>
              <td>Subtotal/6 dias</td>
              <td align=right>".$this->formatoMoneda($diurno->descansero)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->descansero)."</td>
            </tr>
            <tr>
              <td>F. Feriados</td>
              <td>(Subtotal+D)/30 dias</td>
              <td align=right>".$this->formatoMoneda($diurno->feriados)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->feriados)."</td>
            </tr>
            <tr>
              <th>TOTAL DE REMUNERACIONES</th>
              <th></th>
              <th align=right>".$this->formatoMoneda($remuneracionesdiurno)."</th>
              <th align=right>".$this->formatoMoneda($remuneracionesnocturno)."</th>
            </tr>
            <tr>
              <td>G. Gratificaciones</td>
              <td>(2*(Subtotal+AF)+D+2*F)/12 meses</td>
              <td align=right>".$this->formatoMoneda($diurno->gratificaciones)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->gratificaciones)."</td>
            </tr>
            <tr>
              <td>C.T.S.</td>
              <td>(Totalremuneraciones+G)*0.0833</td>
              <td align=right>".$this->formatoMoneda($diurno->cts)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->cts)."</td>
            </tr>
            <tr>
              <td>V. Vacaciones</td>
              <td>Totalremuneraciones*0.833</td>
              <td align=right>".$this->formatoMoneda($diurno->vacaciones)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->vacaciones)."</td>
            </tr>
            <tr>
              <th>TOTAL BENEFICIOS SOCIALES (BB.SS.)</th>
              <th></th>
              <th align=right>".$this->formatoMoneda($beneficiossocialesdiurno)."</th>
              <th align=right>".$this->formatoMoneda($beneficiossocialesnocturno)."</th>
            </tr>
            <tr>
              <td>EsSalud 9%</td>
              <td>(Totalremuneraciones+G+V)*0.09</td>
              <td align=right>".$this->formatoMoneda($diurno->essalud)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->essalud)."</td>
            </tr>
            <tr>
              <td>S.C.T.R. ".Input::get('txt_sctr')."%</td>
              <td>(Totalremuneraciones+G+V)*".(Input::get('txt_sctr')/100)."</td>
              <td align=right>".$this->formatoMoneda($diurno->sctr)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->sctr)."</td>
            </tr>
            <tr>
              <th>TOTAL CONTRIBUCIONES SOCIALES (CC.SS.)</th>
              <th></th>
              <th align=right>".$this->formatoMoneda($contribucionessocialesdiurno)."</th>
              <th align=right>".$this->formatoMoneda($contribucionessocialesnocturno)."</th>
            </tr>
            <tr>
              <th>TOTAL MANO DE OBRA (remuner+Benef.Soc+Contr.Soc)</th>
              <th></th>
              <th align=right>".$this->formatoMoneda($manodeobradiurno)."</th>
              <th align=right>".$this->formatoMoneda($manodeobranocturno)."</th>
            </tr>
            <tr>
              <td>Uniforme, Equipo, Armamento, Supervisión</td>
              <td></td>
              <td align=right>".$this->formatoMoneda($diurno->ueas)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->ueas)."</td>
            </tr>
            <tr>
              <td>Entrenamiento-Capacitación</td>
              <td></td>
              <td align=right>".$this->formatoMoneda($diurno->capacitacion)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->capacitacion)."</td>
            </tr>
            <tr>
              <th>TOTAL IMPLEMENTOS</th>
              <th></th>
              <th align=right>".$this->formatoMoneda($implementosdiurno)."</th>
              <th align=right>".$this->formatoMoneda($implementosnocturno)."</th>
            </tr>
            <tr>
              <td>Movilidad</td>
              <td></td>
              <td align=right>".$this->formatoMoneda($diurno->movilidad)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->movilidad)."</td>
            </tr>
            <tr>
              <td>Refrigerio</td>
              <td></td>
              <td align=right>".$this->formatoMoneda($diurno->refrigerio)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->refrigerio)."</td>
            </tr>
            <tr>
              <th>COSTO POR UN PUESTO DE 12 HORAS</th>
              <th></th>
              <th align=right>".$this->formatoMoneda($manodeobradiurno+$implementosdiurno
                +$viaticosdiurno)."</th>
              <th align=right>".$this->formatoMoneda($manodeobranocturno+$implementosnocturno
                +$viaticosnocturno)."</th>
            </tr>
            <tr>
              <td>Gastos Generales ".Input::get('gastosgenerales')."% </td>
              <td></td>
              <td align=right>".$this->formatoMoneda($diurno->gastosgenerale)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->gastosgenerale)."</td>
            </tr>
            <tr>
              <td>Utilidad</td>
              <td></td>
              <td align=right>".$this->formatoMoneda($diurno->utilidad)."</td>
              <td align=right>".$this->formatoMoneda($nocturno->utilidad)."</td>
            </tr>
            <tr>
              <th>TOTAL DE GASTOS GENERALES + UTILIDAD</th>
              <th></th>
              <th align=right>".$this->formatoMoneda($diurno->gastosgenerale+$diurno->utilidad)."</th>
              <th align=right>".$this->formatoMoneda($nocturno->gastosgenerale+$nocturno->utilidad)."</th>
            </tr>
            <tr>
              <th>COSTO DEL SERVICIO POR 12 HORAS DIURNO Y 12 HORAS NOCTURNO</th>
              <th></th>
              <th align=right>".$this->formatoMoneda($manodeobradiurno+$implementosdiurno
                +$viaticosdiurno+$diurno->gastosgenerale+$diurno->utilidad)."</th>
              <th align=right>".$this->formatoMoneda($manodeobranocturno+$implementosnocturno
                +$viaticosnocturno+$nocturno->gastosgenerale+$nocturno->utilidad)."</th>
            </tr>
            <tr>
              <th>COSTO DEL SERVICIO POR ".$diurno->puestos." PUESTOS DIURNO Y ".$nocturno->puestos
                ." PUESTOS NOCTURNO</th>
              <th></th>
              <th align=right>".$this->formatoMoneda($diurno->subtotal)."</th>
              <th align=right>".$this->formatoMoneda($nocturno->subtotal)."</th>
            </tr>
            <tr>
              <th>COSTO DEL SERVICIO POR ";
              if(Input::get('nocturno') == 0 || Input::get('diurno') == 0){
                $html .= "12";
              }else{
                $html .= "24";
              }
            $html .= " HORAS</th>
              <th></th>
              <th colspan='2' align=right>".$this->formatoMoneda($concepto->subtotal)."</th>
            </tr>
            <tr>
              <th>IGV ";
              if($concepto->igv == 0){
                $html .= "EXONERADO POR LEY Nº 27037";
              }
            $html .= "</th>
              <th></th>
              <th colspan='2' align=right>".$this->formatoMoneda($concepto->igv)."</th>
            </tr>
            <tr>
              <th>COSTO DEL SERVICIO MENSUAL</th>
              <th></th>
              <th colspan='2' align=right>".$this->formatoMoneda($concepto->total)."</th>
            </tr>
          </table>
        </body>
      </html>";

    define('BUDGETS_DIR', public_path('documentos/costos/'.$empresa->ruc.'/detalles'));

    if (!is_dir(BUDGETS_DIR)){
        mkdir(BUDGETS_DIR, 0755, true);
    }

    $nombre = $concepto->id;
    $ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

    $pdf = PDF::loadHtml($html);
    $pdf->setPaper('a4')->save($ruta);

    return Redirect::to('costo/nuevo/'.$empresa->ruc);
    
    // $respuesta = "";
    //   foreach($costo->conceptos as $concepto){
    //   $respuesta .= "<tr>
    //       <td><button type='button' class='btn btn-warning btn-xs btnQuitar' target='_blank' value='".$concepto->id."'>Quitar</button></td>
    //       <td><button type='button' class='btn btn-info btn-xs btnVer' target='_blank' value='".$concepto->id."'>Ver</button></td>
    //       <td>".$concepto->numero." AVP</td>
    //       <td>".$concepto->nombre."</td>
    //       <th style='text-align: right;'>";
    //         if(strpos($concepto->total, '.') === false){
    //           $respuesta .= $concepto->total.".00";
    //         }elseif(strlen(substr($concepto->total, strpos($concepto->total, '.'))) == 3){
    //           $respuesta .= $concepto->total;
    //         }else{
    //           $respuesta .= $concepto->total."0";
    //         }
    //       $respuesta .= "</th>
    //     </tr>";
    //   }
    //   $respuesta .= "<tr>
    //     <th colspan='4' style='text-align: right;'>SUBTOTAL MENSUAL</th>
    //     <th style='text-align: right;'>";
    //       if(strpos($costo->subtotal, '.') === false){
    //         $respuesta .= $costo->subtotal.".00";
    //       }else{
    //         if(strlen(substr($costo->subtotal, strpos($costo->subtotal, '.'))) == 3){
    //           $respuesta .= $costo->subtotal;
    //         }else{
    //           $respuesta .= $costo->subtotal."0";
    //         }
    //       }
    //   $respuesta .= "</th>
    //   </tr>
    //   <tr>";
    //     if($costo->igv != 0){
    //       $respuesta .= "<th colspan='4' style='text-align: right;'>IGV</th>";
    //     }else{
    //       $respuesta .= "<th colspan='4' style='text-align: right;'>IGV EXONERADO POR LEY Nº 27037</th>";
    //     }
    //   $respuesta .= "<th style='text-align: right;'>";
    //       if(strpos($costo->igv, '.') === false){
    //         $respuesta .= $costo->igv.".00";
    //       }else{
    //         if(strlen(substr($costo->igv, strpos($costo->igv, '.'))) == 3){
    //           $respuesta .= $costo->igv;
    //         }else{
    //           $respuesta .= $costo->igv."0";
    //         }
    //       }
    //   $respuesta .= "</th>
    //   </tr>
    //   <tr>
    //     <th colspan='4' style='text-align: right;'>TOTAL</th>
    //     <th style='text-align: right;'>";
    //       if(strpos($costo->total, '.') === false){
    //         $respuesta .= $costo->total.".00";
    //       }else{
    //         if(strlen(substr($costo->total, strpos($costo->total, '.'))) == 3){
    //           $respuesta .= $costo->total;
    //         }else{
    //           $respuesta .= $costo->total."0";
    //         }
    //       }
    //   $respuesta .= "</th>
    //   </tr>";
    
    // echo $respuesta;
  }

  public function postNuevo($ruc){
    if(Input::get('saludo') == ''){
      $mensaje = "EL SALUDO DE LA ESTRUCTURA DE COSTOS NO DEBE SER VACIO. INTENTE NUEVAMENTE.";
      return Redirect::to('costo/nuevo/'.$ruc)
        ->with('rojo', $mensaje);
    }
    if(Input::get('despedida') == ''){
      $mensaje = "LA DESPEDIDA DE LA ESTRUCTURA DE COSTOS NO DEBE SER VACIO. INTENTE NUEVAMENTE.";
      return Redirect::to('costo/nuevo/'.$ruc)
        ->with('rojo', $mensaje);
    }
    $costo = Empresa::find($ruc)->costos()->where('estado', '=', 1)->first();
    
    if ($costo) {
      
      $costo = Costo::find($costo->id);
      $costo->cliente = mb_strtoupper(Input::get('destinatario'));
      $costo->lugar = Input::get('lugar');
      $costo->saludo = Input::get('saludo');
      $costo->despedida = Input::get('despedida');
      $costo->fecha = mb_strtoupper(Input::get('fecha'));
      $costo->estado = 0;
      $costo->save();

      $html = "
        <!DOCTYPE html>
        <html>
          <head>
            <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <title> ESTRUCTURA DE COSTO ".$costo->id."</title>
            <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' 
              name='viewport'>
          </head>
          <body>
            <style type='text/css'>
              *{
                font-size: 12pt;
                font-family: Cambria, Georgia, serif;
              }
              @page{
                margin-top: 5cm;
                margin-left: 3cm;
                margin-right: 2.5cm;
                margin-bottom: 3cm;
              }
              .borde-tabla {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #000000;
              }
              th, td {
                text-align: left;
                border: 1px solid #000000;
              }
            </style>
            <h1 align=center>ESTRUCTURA DE COSTOS</h1>
            <p>Señores:<br><b>".$costo->cliente."</b></p>
            <p>".$costo->lugar."</p>
            <p>".$costo->saludo."</p>
            <table class='borde-tabla'>
              <tr>
                <th align=center>CANT.</th>
                <th align=center>CONCEPTO</th>
                <th align=center>COSTO TOTAL MENSUAL</th>
              </tr>";
            foreach ($costo->conceptos as $concepto) {
              $html .= "
              <tr>
                <td>".$concepto->numero." AVP</td>
                <td>".$concepto->nombre."</td>
                <td align=right>".$this->formatoMoneda($concepto->total)."</td>
              </tr>";
            }
            $html .= "
              <tr>
                <th colspan='2'>SUBTOTAL</th>
                <th align=right>".$this->formatoMoneda($costo->subtotal)."</th>
              </tr>
              <tr>
                <th colspan='2'>IGV";
              if($costo->igv == 0){
                $html .= " EXONERADO POR LEY Nº 27037";
              }
              $html .= "</th>
                <th align=right>".$this->formatoMoneda($costo->igv)."</th>
              </tr>
              <tr>
                <th colspan='2'>TOTAL</th>
                <th align=right>".$this->formatoMoneda($costo->total)."</th>
              </tr>
            </table><br>
            <p>".$costo->despedida."</p>
            <p>".$costo->fecha."</p>
          </body>
        </html>";

      define('BUDGETS_DIR', public_path('documentos/costos/'.$ruc.'/'));

      if (!is_dir(BUDGETS_DIR)){
          mkdir(BUDGETS_DIR, 0755, true);
      }

      $nombre = $costo->id;
      $ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

      $pdf = PDF::loadHtml($html);
      $pdf->setPaper('a4')->save($ruta);

      $mensaje = "LA ESTRUCTURA DE COSTOS SE GUARDO EXITOSAMENTE.";
      return Redirect::to('costo/mostrar/'.$costo->id)->with('verde', $mensaje);
    }else{
      $mensaje = "NO SE GUARDO LA ESTRUCTURA DE COSTOS, INGRESE CONCEPTOS PARA QUE SEA VALIDO.";
      return Redirect::to('costo/nuevo/'.$ruc)->with('rojo', $mensaje);
    }
  }

  public function getMostrar($id){
    $costo = Costo::find($id);
    return View::make('costo.mostrar')->with('costo', $costo);
  }

  public function deleteBorrar($id){
    $costo = Costo::find($id);
    $ruc = $costo->empresa_ruc;
    if(Hash::check(Input::get('password'), Auth::user()->password)){
      File::delete('documentos/costos/'.$ruc.'/'.$costo->id.'.pdf');
      foreach ($costo->conceptos as $concepto) {
        File::delete('documentos/costos/'.$ruc.'/detalles/'.$concepto->id.'.pdf');
      }
      $costo->delete();
      $mensaje = "LA ESTRUCTURA DE COSTOS FUE ELIMINADO CORRECTAMENTE.";
      return Redirect::to('costo/inicio/'.$ruc)->with('naranja', $mensaje);
    }else{
      $mensaje = "LA CONTRASEÑA ES INCORRECTA, INTENTE NUEVAMENTE.";
      return Redirect::to('costo/inicio/'.$ruc)->with('rojo', $mensaje);
    }
  }

  public function postCancelar(){
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $costo = $empresa->costos()->where('estado', '=', 1)->first();
    if ($costo) {
      $costo = Costo::find($costo->id);
      $ruc = $costo->empresa_ruc;
      File::delete('documentos/costos/'.$ruc.'/'.$costo->id.'.pdf');
      foreach ($costo->conceptos as $concepto) {
        File::delete('documentos/costos/'.$ruc.'/detalles/'.$concepto->id.'.pdf');
      }
      $costo->delete();
      return 1;
    }else{
      return 0;
    }
  }

  public function getVerConcepto($id){
    $concepto = Concepto::find($id);
    return View::make('costo.concepto')->with('concepto', $concepto);
  }

  public function postQuitarConcepto(){
    $concepto = Concepto::find(Input::get('concepto_id'));
    $costo = $concepto->costo;
    File::delete('documentos/costos/'.$costo->empresa_ruc.'/detalles/'.$concepto->id.'.pdf');
    if(count($costo->conceptos) == 1){
      $costo->delete();
      $respuesta = "";
    }else{
      $costo = $this->actualizarCosto($costo->id, -$concepto->subtotal, -$concepto->igv, 
        -$concepto->total);
      $concepto->delete();
      $respuesta = "";
        foreach($costo->conceptos as $concepto){
        $respuesta .= "<tr>
            <td><button type='button' class='btn btn-warning btn-xs' target='_blank' id='btnQuitar' value='".$concepto->id."'>Quitar</button></td>
            <td><button type='button' class='btn btn-info btn-xs' target='_blank' id='btnVer' value='".$concepto->id."'>Ver</button></td>
            <td>".$concepto->numero." AVP</td>
            <td>".$concepto->nombre."</td>
            <th style='text-align: right;'>";
              if(strpos($concepto->total, '.') === false){
                $respuesta .= $concepto->total.".00";
              }elseif(strlen(substr($concepto->total, strpos($concepto->total, '.'))) == 3){
                $respuesta .= $concepto->total;
              }else{
                $respuesta .= $concepto->total."0";
              }
            $respuesta .= "</th>
          </tr>";
        }
        $respuesta .= "<tr>
          <th colspan='4' style='text-align: right;'>SUBTOTAL MENSUAL</th>
          <th style='text-align: right;'>";
            if(strpos($costo->subtotal, '.') === false){
              $respuesta .= $costo->subtotal.".00";
            }else{
              if(strlen(substr($costo->subtotal, strpos($costo->subtotal, '.'))) == 3){
                $respuesta .= $costo->subtotal;
              }else{
                $respuesta .= $costo->subtotal."0";
              }
            }
        $respuesta .= "</th>
        </tr>
        <tr>";
          if($costo->igv != 0){
            $respuesta .= "<th colspan='4' style='text-align: right;'>IGV</th>";
          }else{
            $respuesta .= "<th colspan='4' style='text-align: right;'>IGV EXONERADO POR LEY Nº 27037</th>";
          }
        $respuesta .= "<th style='text-align: right;'>";
            if(strpos($costo->igv, '.') === false){
              $respuesta .= $costo->igv.".00";
            }else{
              if(strlen(substr($costo->igv, strpos($costo->igv, '.'))) == 3){
                $respuesta .= $costo->igv;
              }else{
                $respuesta .= $costo->igv."0";
              }
            }
        $respuesta .= "</th>
        </tr>
        <tr>
          <th colspan='4' style='text-align: right;'>TOTAL</th>
          <th style='text-align: right;'>";
            if(strpos($costo->total, '.') === false){
              $respuesta .= $costo->total.".00";
            }else{
              if(strlen(substr($costo->total, strpos($costo->total, '.'))) == 3){
                $respuesta .= $costo->total;
              }else{
                $respuesta .= $costo->total."0";
              }
            }
        $respuesta .= "</th>
        </tr>";
    }

    echo $respuesta;
  }

  /*Funciones privadas********************************************************************/

  private function nuevoCosto($empresa_ruc, $cliente, $lugar, $saludo, $subtotal, $igv, $total,
    $despedida, $fecha, $estado){

    $costo = new Costo;
    $costo->empresa_ruc = $empresa_ruc;
    $costo->cliente = $cliente;
    $costo->lugar = $lugar;
    $costo->saludo = $saludo;
    $costo->subtotal = $subtotal;
    $costo->igv = $igv;
    $costo->total = $total;
    $costo->despedida = $despedida;
    $costo->fecha = $fecha;
    $costo->estado = $estado;
    $costo->save();

    return Costo::find($costo->id);
  }

  private function nuevoConcepto($costo_id, $nombre, $numero, $subtotal, $igv, $total){
    $concepto = new Concepto;
    $concepto->costo_id = $costo_id;
    $concepto->nombre = mb_strtoupper($nombre);
    $concepto->numero = $numero;
    $concepto->subtotal = $subtotal;
    $concepto->igv = $igv;
    $concepto->total = $total;
    $concepto->save();

    return Concepto::find($concepto->id);
  }

  private function nuevoConceptoTurno($turno_id, $concepto_id, $puestos, $sueldobasico, 
    $asignacionfamiliar, $jornadanocturna, $sobretiempo, $descansero, $feriados,
    $gratificaciones, $cts, $vacaciones, $essalud, $sctr, $ueas, $capacitacion, $movilidad, 
    $refrigerio, $gastosgenerales, $utilidad, $igv){

    if ($asignacionfamiliar) {
      $asignacionfamiliar = $sueldobasico*0.1;
    }else{
      $asignacionfamiliar = 0;
    }

    if ($jornadanocturna) {
      $jornadanocturna = $sueldobasico*0.35;
    }else{
      $jornadanocturna = 0;
    }

    if ($sobretiempo) {
      if ($sobretiempo > 0 && $sobretiempo <=2) {
        $sobretiempo1 = round(((((($sueldobasico + $asignacionfamiliar)*1.25)/30)/8)*26)*$sobretiempo*100)/100;
        $sobretiempo2 = 0;
      }elseif ($sobretiempo >2 && $sobretiempo <=4) {
        $sobretiempo1 = round(((((($sueldobasico + $asignacionfamiliar)*1.25)/30)/8)*26)*2*100)/100;
        $sobretiempo2 = round(((((($sueldobasico + $asignacionfamiliar)*1.35)/30)/8)*26)*($sobretiempo-2)*100)/100;;
      }
    }else{
      $sobretiempo1 = 0;
      $sobretiempo2 = 0;
    }

    $subtotal = $sueldobasico+$asignacionfamiliar+$jornadanocturna+$sobretiempo1+$sobretiempo2;

    if($descansero){
      $descansero = round($subtotal*100/6)/100;
    }else{
      $descansero = 0;
    }

    if($feriados){
      $feriados = round((($subtotal+(round(($subtotal-$jornadanocturna)*100/6)/100)-$jornadanocturna)/30)*100)/100;
    }else{
      $feriados = 0;
    }

    $remuneraciones = $descansero + $feriados + $subtotal;

    if($gratificaciones){
      $gratificaciones = round((2*($subtotal-$asignacionfamiliar)+$descansero+(2*$feriados))/12*100)/100;
    }else{
      $gratificaciones = 0;
    }

    if($cts){
      $cts = round(($remuneraciones + $gratificaciones)*0.0833*100)/100;
    }else{
      $cts = 0;
    }

    if($vacaciones){
      $vacaciones = round($remuneraciones*0.0833*100)/100;
    }else{
      $vacaciones = 0;
    }

    $beneficiossociales = $gratificaciones+$cts+$vacaciones;

    if($essalud){
      $essalud = round(($remuneraciones+$gratificaciones+$vacaciones)*0.09*100)/100;
    }else{
      $essalud = 0;
    }

    if($sctr){
      $sctr = round(($remuneraciones+$gratificaciones+$vacaciones)*$sctr)/100;
    }else{
      $sctr = 0;
    }

    $contribucionessociales = $essalud + $sctr;
    $manodeobra = $remuneraciones + $beneficiossociales + $contribucionessociales;

    if(!$ueas){
      $ueas = 0;
    }

    if(!$capacitacion){
      $capacitacion = 0;
    }
    $implementos = $ueas + $capacitacion;

    if(!$movilidad){
      $movilidad = 0;
    }

    if(!$refrigerio){
      $refrigerio = 0;
    }

    $movilidad_refrigerio = $movilidad + $refrigerio;
    $total12horas = $manodeobra + $implementos + $movilidad_refrigerio;

    if(!$gastosgenerales){
      $gastosgenerales = 0;
    }else{
      $gastosgenerales = round($total12horas*$gastosgenerales)/100;
    }

    if(!$utilidad){
      $utilidad = 0;
    }

    $gastosgenerales_utilidad = $gastosgenerales + $utilidad;
    $subtotalconcepto = ($total12horas + $gastosgenerales_utilidad)*$puestos;

    if($igv){
      $igv = round($subtotalconcepto*$igv)/100;
    }else{
      $igv = 0;
    }
    
    $total = $subtotalconcepto + $igv;

    Concepto::find($concepto_id)->turnos()->attach($turno_id, array('puestos'=>$puestos, 
      'sueldobasico'=>$sueldobasico, 'asignacionfamiliar'=>$asignacionfamiliar, 'jornadanocturna'
      =>$jornadanocturna, 'sobretiempo1'=>$sobretiempo1, 'sobretiempo2'=>$sobretiempo2, 'descansero'
      =>$descansero, 'feriados'=>$feriados, 'gratificaciones'=>$gratificaciones, 'cts'=>$cts,
      'vacaciones'=>$vacaciones, 'essalud'=>$essalud, 'sctr'=>$sctr, 'ueas'=>$ueas, 'capacitacion'=>
      $capacitacion, 'movilidad'=>$movilidad, 'refrigerio'=>$refrigerio, 'gastosgenerale'=>
      $gastosgenerales, 'utilidad'=>$utilidad, 'subtotal'=>$subtotalconcepto, 'igv'=>$igv,
      'total'=>$total));
  }

  private function actualizarConcepto($id, $numero, $subtotal, $igv, $total){
    $concepto = Concepto::find($id);
    $concepto->numero += $numero;
    $concepto->subtotal += $subtotal;
    $concepto->igv += $igv;
    $concepto->total += $total;
    $concepto->save();

    return Concepto::find($id);
  }

  private function actualizarCosto($id, $subtotal, $igv, $total){

    $costo = Costo::find($id);
    $costo->subtotal += $subtotal;
    $costo->igv += $igv;
    $costo->total += $total;
    $costo->save();

    return Costo::find($id);
  }

  private function formatoMoneda($numero){
    if(strpos($numero, '.') === false){
      $formato = $numero.".00";
    }elseif(strlen(substr($numero, strpos($numero, '.'))) == 3){
      $formato = $numero;
    }else{
      $formato = $numero."0";
    }
    return $formato;
  }
}