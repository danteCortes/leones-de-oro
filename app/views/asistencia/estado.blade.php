<?php
  $entrada = explode(':', $asistencia->entrada);
  $entrada = $entrada[0]*3600 + $entrada[1]*60 + $entrada[2];
  if ($asistencia->salida != null) {
    $salida = explode(':', $asistencia->salida);
    $salida = $salida[0]*3600 + $salida[1]*60 + $salida[2];
  }
  $entradaLegal = explode(':', Turno::find($asistencia->turno_id)->entrada);
  $entradaLegal = $entradaLegal[0]*3600 + $entradaLegal[1]*60 + $entradaLegal[2];
  $salidaLegal = explode(':', Turno::find($asistencia->turno_id)->salida);
  $salidaLegal = $salidaLegal[0]*3600 + $salidaLegal[1]*60 + $salidaLegal[2];
  function diferencia($entero){
    $hora = (int)($entero/3600);
    $minutos = (int)(($entero%3600)/60);
    $segundos = ($entero%3600)%60;
    return $hora."Hrs ".$minutos."Min ".$segundos."Seg ";
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Estado del Registro</title>
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?=URL::to('bootstrap/css/bootstrap.min.css')?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, 
      user-scalable=no">
    <style>
      h1{
        font-size: 15px;
      }
    </style>
  </head>
  <body>
    <div class="container-fluid">
      <div class="page-header">
        <h1>{{Trabajador::find($asistencia->trabajador_id)->persona->nombre}}
          {{Trabajador::find($asistencia->trabajador_id)->persona->apellidos}}</h1>
      </div>
      <div class="row">
        <div class="col-xs-12">
          Fecha: {{date('d-m-Y', strtotime($asistencia->fecha))}}
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          Entrada: {{date('h:i:s A', strtotime($asistencia->entrada))}}
        </div>
      </div>
      @if($asistencia->salida != null)
        <div class="row">
          <div class="col-xs-12">
            Salida: {{date('h:i:s A', strtotime($asistencia->salida))}}
          </div>
        </div>
      @endif
      <div class="row">
        <div class="col-xs-12">
          @if($asistencia->salida == null)
            @if($entrada <= $entradaLegal)
              <div class="alert alert-success col-xs-12">Su registro de Entrada fue satisfactorio a las 
                {{$asistencia->entrada}}.</div>
            @else
              @if($entrada - $entradaLegal <= 900)
                <div class="alert alert-success col-xs-12">Su registro de Entrada fue satisfactorio a las 
                {{$asistencia->entrada}}.</div>
              @else
              <div class="alert alert-danger col-xs-12">Su registro de Entrada tiene una tardanza de 
                {{diferencia($entrada-$entradaLegal-900)}}</div>
              @endif
            @endif
          @else
            @if($salida >= $salidaLegal)
              <div class="alert alert-success col-xs-12">Su registro de Salida fue satisfactorio a las 
                {{$asistencia->salida}}.</div>
            @else
              <div class="alert alert-danger col-xs-12">Su registro de salida fue de
                {{diferencia($salidaLegal-$salida)}} antes de la hora indicada.</div>
            @endif
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <a class="btn btn-success" onclick="javascript:window.close();" href="<?=URL::to('asistencia/inicio')?>">Salir</a>
        </div>
      </div>
    </div>
    <!-- jQuery 2.2.3 -->
    <script src="<?=URL::to('plugins/jQuery/jquery-2.2.3.min.js')?>"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="<?=URL::to('bootstrap/js/bootstrap.min.js')?>"></script>
  </body>
</html>