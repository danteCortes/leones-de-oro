<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Código QR</title>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Mono' rel='stylesheet' type='text/css'>
  <style type="text/css">

    @media print{
      .no-print, .no-print *{
        display: none !important;
      }
    }

    .salir {
      font: 10px Tahoma, Arial, Verdana, sans-serif;
      color: #fff; background-color: #2E9AFE;
      cursor: pointer;
      border-radius: 7px 7px 7px 7px;
      -moz-border-radius: 7px 7px 7px 7px;
      -webkit-border-radius: 7px 7px 7px 7px;
      border-bottom: 5px solid #0174DF;
    }

    .salir:hover{
      color: #fff; background-color: #0080FF;
    }

    .imprimir{
      font: 700 1em Tahoma, Arial, Verdana, sans-serif;
      color: #fff; background-color: #04B45F;
      border-style: outset;
      cursor: pointer;
      border-radius: 7px 7px 7px 7px;
      -moz-border-radius: 7px 7px 7px 7px;
      -webkit-border-radius: 7px 7px 7px 7px;
      border-bottom: 5px solid #088A4B;
    }

    .imprimir:hover{
      color: #fff; background-color: #04B404;
    }

    .salir{
      width: auto; /* ie */
      overflow: visible; /* ie */
      padding: 3px 8px 2px 6px; /* ie */

    }

    button[type] {
      padding: 4px 8px 4px 6px; /* firefox */
    }
  </style>
</head>
<body >
  <h1 class="no-print">Codigo QR para {{$trabajador->persona->nombre}}
    {{$trabajador->persona->apellidos}}</h1>
  <div class="visible-print text-center">
    {{ QrCode::size(200)->generate(URL::to('asistencia/registrar/'.$trabajador->id)); }}
  </div>
  <button type="submit" class="imprimir no-print"  name="imprimir" onclick="window.print();">
    Imprimir
  </button>
  <a onclick="javascript:window.close();" href="#" style="padding-left:18%;  padding-right:15px;"
  class="no-print">
    <button type="submit" class="salir" name="imprimir">
      Salir
    </button>
  </a>
</body>
</html>