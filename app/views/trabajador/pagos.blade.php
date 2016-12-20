<?php
  function dias($fecha){
    $mes = substr($fecha, 0, 2);
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
  function segundos($hora){
    $hora = explode(':', $hora);
    return $hora[0]*3600+$hora[1]*60+$hora[2];
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title> PLANILLA DE PAGOS {{$fecha}}</title>
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
      .moneda{
        text-align: right;
      }
    </style>
    <h1 align='center'>PLANILLA DE PAGOS {{$fecha}} {{$empresa->nombre}}</h1>
    <table class='borde-tabla'>
      <tr>
        <th rowspan='3'>DNI</th>
        <th rowspan='3'>TRABAJADOR</th>
        <th colspan='{{4+count(Bonificacion::all())}}'>REMUNERACIONES</th>
        <th colspan='{{8+count(Descuento::all())}}'>DESCUENTOS</th>
        <th rowspan='3'>TOTAL</th>
      </tr>
      <tr>
        <th rowspan='2'>SB</th>
        <th rowspan='2'>AF</th>
        <th colspan='2' rowspan='2'>HORAS EXTRAS</th>
        <th colspan='{{count(Bonificacion::all())}}'>BONIFICACIONES</th>
        <th colspan='{{count(Descuento::all())}}'>DESCUENTOS</th>
        <th colspan='3'>AFP</th>
        <th rowspan='2'>ONP</th>
        <th colspan='2' rowspan='2'>FALTAS</th>
        <th colspan='2' rowspan='2'>TARDANZAS</th>
      </tr>
      <tr>
        @foreach(Bonificacion::all() as $bonificacion)
        <th>{{$bonificacion->nombre}}</th>
        @endforeach
        @foreach(Descuento::all() as $descuento)
        <th>{{$descuento->nombre}}</th>
        @endforeach
        <th>FONDO</th>
        <th>PRIMA</th>
        <th>FLUJO</th>
      </tr>
      @foreach ($trabajadores as $trabajador)
        <tr>
          <td>{{$trabajador->persona_dni}}</td>
          <td>{{$trabajador->persona->nombre}} {{$trabajador->persona->apellidos}}</td>
          <td class='moneda'>{{number_format($trabajador->sueldo, '2', '.', ' ') }}</td>
          <td class='moneda'>
            <?php $af = 0; ?>
            @if($trabajador->af)
              <?php $af = 85; ?>
            @endif
            {{number_format($af, 2, '.', ' ')}}
          </td>
          <td class='moneda'>
            @if($trabajador->he)
              {{count($trabajador->asistencias)*$trabajador->he}}
            @endif
          </td>
          <td class='moneda'>
            <?php $he = 0; ?>
            @if($trabajador->he)
              @if($trabajador->he > 0 && $trabajador->he <= 2)
                {{number_format(($trabajador->sueldo/240)*1.25*$trabajador->he*
                  count($trabajador->asistencias))}}
                <?php $he = ($trabajador->sueldo/240)*1.25*$trabajador->he*count($trabajador->asistencias); ?>
              @else($trabajador->he > 2)
                {{number_format((($trabajador->sueldo/240)*1.25*2*count($trabajador->asistencias)) +
                  (($trabajador->sueldo/240)*1.35*($trabajador->he-2)*count($trabajador->asistencias)), 2, '.', ' ')}}
                <?php $he = (($trabajador->sueldo/240)*1.25*2*count($trabajador->asistencias)) +
                  (($trabajador->sueldo/240)*1.35*($trabajador->he-2)*count($trabajador->asistencias)); ?>
              @endif
            @endif
          </td>
          <?php $bonificaciones = 0; ?>
          @foreach(Bonificacion::all() as $bonificacion)
          <td class='moneda'>
            @foreach($trabajador->bonificaciones as $trabajador_bonificacion)
              @if($trabajador_bonificacion->pivot->bonificacion_id == $bonificacion->id)
                @if($trabajador_bonificacion->porcentaje)
                  {{number_format($trabajador->sueldo*$trabajador_bonificacion->porcentaje/100
                    , 2, '.', ' ')}}
                  <?php $bonificaciones += $trabajador->sueldo*$trabajador_bonificacion->porcentaje/100; ?>
                @elseif($trabajador_bonificacion->fijo)
                  {{number_format($trabajador_bonificacion->fijo, 2, '.', ' ')}}
                  <?php $bonificaciones += $trabajador_bonificacion->fijo; ?>
                @endif
                <?php break; ?>
              @endif
            @endforeach
          </td>
          @endforeach
          <?php $desc = 0; ?>
          @foreach(Descuento::all() as $descuento)
          <td class='moneda'>
            @foreach($trabajador->descuentos as $trabajador_descuento)
              @if($trabajador_descuento->pivot->descuento_id == $descuento->id)
                {{number_format($trabajador_descuento->pivot->monto, 2, '.', ' ')}}
                <?php $desc += $trabajador_descuento->pivot->monto; ?>
                <?php break; ?>
              @endif
            @endforeach
          </td>
          @endforeach
          <?php $aseguradora = 0; ?>
          <td class='moneda'>
            @if($trabajador->aseguradora)
              @if($trabajador->aseguradora->fondo)
                {{number_format($trabajador->aseguradora->fondo*$trabajador->sueldo/100, 2, '.', ' ')}}
                <?php $aseguradora += $trabajador->aseguradora->fondo*$trabajador->sueldo/100; ?>
              @else
                0.00
              @endif
            @else
              0.00
            @endif
          </td>
          <td class='moneda'>
            @if($trabajador->aseguradora)
              @if($trabajador->aseguradora->prima)
                {{number_format($trabajador->aseguradora->prima*$trabajador->sueldo/100, 2, '.', ' ')}}
                <?php $aseguradora += $trabajador->aseguradora->prima*$trabajador->sueldo/100; ?>
              @else
                0.00
              @endif
            @else
              0.00
            @endif
          </td>
          <td class='moneda'>
            @if($trabajador->aseguradora)
              @if($trabajador->aseguradora->flujo)
                {{number_format($trabajador->aseguradora->flujo*$trabajador->sueldo/100, 2, '.', ' ')}}
                <?php $aseguradora += $trabajador->aseguradora->flujo*$trabajador->sueldo/100; ?>
              @else
                0.00
              @endif
            @else
              0.00
            @endif
          </td>
          <td class='moneda'>
            @if($trabajador->aseguradora)
              @if($trabajador->aseguradora->fijo)
                {{number_format($trabajador->aseguradora->fijo*$trabajador->sueldo/100, 2, '.', ' ')}}
                <?php $aseguradora += $trabajador->aseguradora->fijo*$trabajador->sueldo/100; ?>
              @else
                0.00
              @endif
            @else
              0.00
            @endif
          </td>
          <td class='moneda'>{{dias($fecha)-count($trabajador->asistencias)}}</td>
          <td class='moneda'>
            <?php $faltas = 0; ?>
            {{number_format($trabajador->sueldo/dias($fecha)*
              (dias($fecha)-count($trabajador->asistencias)), 2, '.', ' ')}}
            <?php $faltas = $trabajador->sueldo/dias($fecha)*(dias($fecha)-count($trabajador->asistencias)); ?>
          </td>
          <td class='moneda'>
            <?php $acumulado = 0; ?>
            @foreach($trabajador->asistencias as $asistencia)
              @if(segundos($asistencia->turno->entrada) < segundos($asistencia->pivot->entrada))
                @if(segundos($asistencia->pivot->entrada) - segundos($asistencia->turno->entrada) > 900)
                  <?php $acumulado += (int)((segundos($asistencia->pivot->entrada)-
                    segundos($asistencia->turno->entrada)-900)/60); ?>
                @endif
              @endif
            @endforeach
            {{$acumulado}}
          </td>
          <td class='moneda'>
            <?php $tardanza = 0; ?>
            @if($trabajador->he)
              @if($trabajador->he > 2)
                <?php $tardanza = ($trabajador->sueldo/240)*1.35*($acumulado/60); ?>
              @endif
            @endif
            {{number_format($tardanza, 2, '.', ' ')}}
          </td>
          <td class='moneda'>
            {{number_format($trabajador->sueldo+$af+$he+$bonificaciones-$aseguradora-$faltas-$tardanza-$desc, 2, '.', ' ')}}
          </td>
        </tr>
      @endforeach
    </table>
  </body>
</html>
