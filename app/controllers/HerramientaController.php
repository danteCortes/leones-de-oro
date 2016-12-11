<?php

class HerramientaController extends BaseController{

  public function getInicio($ruc){
    $empresa = Empresa::find($ruc);
    return View::make('herramienta.inicio')->with('empresa', $empresa);
  }

  public function postNuevo(){
    $herramienta = [];
    $herramienta_empresa = [];

    foreach (Herramienta::all() as $registro) {
      if ($registro->nombre == mb_strtoupper(Input::get('nombre'))) {
        $herramienta = $registro;
        break;
      }
    }

    if (count($herramienta) == 0) {
      $herramienta = new Herramienta;
      $herramienta->nombre = mb_strtoupper(Input::get('nombre'));
      $herramienta->save();
    }

    foreach (HerramientaEmpresa::all() as $registro) {
      if ($registro->serie == mb_strtoupper(Input::get('serie'))) {
        $herramienta_empresa = $registro;
        break;
      }
    }
    if (count($herramienta_empresa) != 0) {
      $mensaje = "NO SE GUARDO LA HERRAMIENTA, YA EXISTE UNA HERRAMIENTA CON ESTE NUMERO DE 
        SERIE.";
      return Redirect::to('herramienta/inicio/'.Input::get('empresa'))
        ->with('rojo', $mensaje);
    }
    $herramienta_empresa = new HerramientaEmpresa;
    $herramienta_empresa->empresa_ruc = Input::get('empresa');
    $herramienta_empresa->herramienta_id = $herramienta->id;
    $herramienta_empresa->serie = mb_strtoupper(Input::get('serie'));
    $herramienta_empresa->marca = mb_strtoupper(Input::get('marca'));
    $herramienta_empresa->modelo = mb_strtoupper(Input::get('modelo'));
    $herramienta_empresa->descripcion = mb_strtoupper(Input::get('descripcion'));
    $herramienta_empresa->save();

    $mensaje = "SE GUARDO LA HERRAMIENTA SATISFACTORIAMENTE.";
    return Redirect::to('herramienta/inicio/'.Input::get('empresa'))
          ->with('verde', $mensaje);
  }

  public function deleteEliminar(){
    $herramienta_empresa = HerramientaEmpresa::where('serie', '=', Input::get('serie'))->first();
    if ($herramienta_empresa) {
      $herramienta_empresa->delete();
      $mensaje = "LA HERRAMIENTA FUE ELIMINADO DE LA EMPRESA";
      return Redirect::to('herramienta/inicio/'.Input::get('empresa'))->with('naranja', $mensaje);
    }else{
      $mensaje = "NO SE ENCONTRO UNA HERRAMIENTA CON ESTE NUMERO DE SERIE.";
      return Redirect::to('herramienta/inicio/'.Input::get('empresa'))->with('rojo', $mensaje);
    }
  }

  public function getReporte($ruc){
    $empresa = Empresa::find($ruc);

    $html = "
      <!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
          <title>REPORTE DE HERRAMIENTAS ".$empresa->nombre."</title>
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
              margin-top: 3cm;
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
          <h1 align='center'>REPORTE DE HERRAMIENTAS EN ALMACEN ".$empresa->nombre."</h1>
          <table class='borde-tabla'>
            <tr>
              <th>SERIE</th>
              <th>HERRAMIENTA</th>
              <th>MARCA</th>
              <th>MODELO</th>
              <th>DESCRICION</th>
              <th>TRABAJADORES</th>
            </tr>";
            foreach (HerramientaEmpresa::where('empresa_ruc', '=', $empresa->ruc)->get() as 
              $herramienta) {
              $html .= "
              <tr>
                <td>".$herramienta->serie."</td>
                <td>".$herramienta->herramienta->nombre."</td>
                <td>".$herramienta->marca."</td>
                <td>".$herramienta->modelo."</td>
                <td>".$herramienta->descripcion."</td>
                <td>";
                foreach ($herramienta->trabajadores as $trabajador) {
                  $html .= "*".$trabajador->persona->nombre." ".$trabajador->persona->apellidos."<br>";
                }
                $html .= "</td>
              </tr>";
            }
          $html .= "</table>
        </body>
      </html>";

    $pdf = PDF::loadHtml($html);
    return $pdf->setPaper('a4')->setOrientation('landscape')->stream();
  }

  public function getDotar($id){
    $trabajador = Trabajador::find($id);
    return View::make('herramienta.dotar')->with('trabajador', $trabajador);
  }

  public function postDotar(){
    $empresa_herramienta = HerramientaEmpresa::where('serie', '=', Input::get('serie'))->first();
    
    if ($empresa_herramienta) {
      $empresa_herramienta_trabajador = EmpresaHerramientaTrabajador::where(
        'empresa_herramienta_id', '=', $empresa_herramienta->id)->where('trabajador_id', '=', 
        Input::get('id'))->first();
      if ($empresa_herramienta_trabajador) {
        $mensaje = "<div class='alert alert-danger alert-dismissable'>
            <i class='fa fa-info'></i>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
              &times;</button>
            <b>Alerta!</b> ESTA HERRAMIENTA YA ESTÁ ASIGNADO A ESTE TRABAJADOR.
          </div>";
        $html = "<table class='table table-hover'>
          <tr>
            <th>Serie</th>
            <th>Herramienta</th>
            <th>Marca</th>
            <th>Modelo</th>
          </tr>";
          foreach(Trabajador::find(Input::get('id'))->herramientas as $herramienta){
            $html .= "<tr>
              <td>".$herramienta->serie."</td>
              <td>".$herramienta->herramienta->nombre."</td>
              <td>".$herramienta->marca."</td>
              <td>".$herramienta->modelo."</td>
            </tr>";
          }
          $html .= "</table>";
        $respuesta = array('mensaje' => $mensaje, 'html' => $html);
      }else{
        $empresa_herramienta_trabajador = new EmpresaHerramientaTrabajador;
        $empresa_herramienta_trabajador->empresa_herramienta_id = $empresa_herramienta->id;
        $empresa_herramienta_trabajador->trabajador_id = Input::get('id');
        $empresa_herramienta_trabajador->entrega = date('Y-m-d');
        $empresa_herramienta_trabajador->save();

        $mensaje = "<div class='alert alert-success alert-dismissable'>
            <i class='fa fa-info'></i>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
              &times;</button>
            <b>Alerta!</b> LA HERRAMIENTA SE ASIGNO AL TRABAJADOR CON EXITO.
          </div>";
        $html = "<table class='table table-hover'>
          <tr>
            <th>Serie</th>
            <th>Herramienta</th>
            <th>Marca</th>
            <th>Modelo</th>
          </tr>";
          foreach(Trabajador::find(Input::get('id'))->herramientas as $herramienta){
            $html .= "<tr>
              <td>".$herramienta->serie."</td>
              <td>".$herramienta->herramienta->nombre."</td>
              <td>".$herramienta->marca."</td>
              <td>".$herramienta->modelo."</td>
            </tr>";
          }
          $html .= "</table>";
        $respuesta = array('mensaje' => $mensaje, 'html' => $html);
      }
    }else{
      $mensaje = "<div class='alert alert-danger alert-dismissable'>
          <i class='fa fa-info'></i>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
            &times;</button>
          <b>Alerta!</b> NO EXISTE UNA HERRAMIENTA CON ESE NUMERO DE SERIE.
        </div>";
      $html = "<table class='table table-hover'>
        <tr>
          <th>Serie</th>
          <th>Herramienta</th>
          <th>Marca</th>
          <th>Modelo</th>
        </tr>";
        foreach(Trabajador::find(Input::get('id'))->herramientas as $herramienta){
          $html .= "<tr>
            <td>".$herramienta->serie."</td>
            <td>".$herramienta->herramienta->nombre."</td>
            <td>".$herramienta->marca."</td>
            <td>".$herramienta->modelo."</td>
          </tr>";
        }
        $html .= "</table>";
      $respuesta = array('mensaje' => $mensaje, 'html' => $html);
    }
    
    return $respuesta;
  }

  public function postRecoger(){
    $empresa_herramienta = HerramientaEmpresa::where('serie', '=', Input::get('serie'))->first();
    
    if ($empresa_herramienta) {
      $empresa_herramienta_trabajador = EmpresaHerramientaTrabajador::where(
        'empresa_herramienta_id', '=', $empresa_herramienta->id)->where('trabajador_id', '=', 
        Input::get('id'))->first();
      if ($empresa_herramienta_trabajador) {
        $empresa_herramienta_trabajador->delete();
        $mensaje = "<div class='alert alert-success alert-dismissable'>
            <i class='fa fa-info'></i>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
              &times;</button>
            <b>Alerta!</b> SE RETIRÓ LA ASIGNACION DE LA HERRAMIENTA AL TRABAJADOR CON EXITO.
          </div>";
        $html = "<table class='table table-hover'>
          <tr>
            <th>Serie</th>
            <th>Herramienta</th>
            <th>Marca</th>
            <th>Modelo</th>
          </tr>";
          foreach(Trabajador::find(Input::get('id'))->herramientas as $herramienta){
            $html .= "<tr>
              <td>".$herramienta->serie."</td>
              <td>".$herramienta->herramienta->nombre."</td>
              <td>".$herramienta->marca."</td>
              <td>".$herramienta->modelo."</td>
            </tr>";
          }
          $html .= "</table>";
        $respuesta = array('mensaje' => $mensaje, 'html' => $html);
      }else{
        $mensaje = "<div class='alert alert-danger alert-dismissable'>
          <i class='fa fa-info'></i>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
            &times;</button>
          <b>Alerta!</b> EL TRABAJADOR NO TIENE ASIGNADO LA HERRAMIENTA QUE BUSCA.
        </div>";
        $html = "<table class='table table-hover'>
          <tr>
            <th>Serie</th>
            <th>Herramienta</th>
            <th>Marca</th>
            <th>Modelo</th>
          </tr>";
          foreach(Trabajador::find(Input::get('id'))->herramientas as $herramienta){
            $html .= "<tr>
              <td>".$herramienta->serie."</td>
              <td>".$herramienta->herramienta->nombre."</td>
              <td>".$herramienta->marca."</td>
              <td>".$herramienta->modelo."</td>
            </tr>";
          }
          $html .= "</table>";
        $respuesta = array('mensaje' => $mensaje, 'html' => $html);
      }
    }else{
      $mensaje = "<div class='alert alert-danger alert-dismissable'>
        <i class='fa fa-info'></i>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
          &times;</button>
        <b>Alerta!</b> NO EXISTE UNA HERRAMIENTA CON ESE NUMERO DE SERIE.
      </div>";
      $html = "<table class='table table-hover'>
        <tr>
          <th>Serie</th>
          <th>Herramienta</th>
          <th>Marca</th>
          <th>Modelo</th>
        </tr>";
        foreach(Trabajador::find(Input::get('id'))->herramientas as $herramienta){
          $html .= "<tr>
            <td>".$herramienta->serie."</td>
            <td>".$herramienta->herramienta->nombre."</td>
            <td>".$herramienta->marca."</td>
            <td>".$herramienta->modelo."</td>
          </tr>";
        }
        $html .= "</table>";
      $respuesta = array('mensaje' => $mensaje, 'html' => $html);
    }

    return $respuesta;
  }

  public function getVer($id){
    $trabajador = Trabajador::find($id);
    $html = "<!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
          <title>CONTROL DE HERRAMIENTAS DEL PERSONAL DE VIGILANCIA DESTACADO</title>
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
              margin-top: 3cm;
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
          <h1 align='center'>CONTROL DE UNIFORMES DEL PERSONAL DE VIGILANCIA DESTACADO</h1>
          <P>Apellidos y nombres: ".$trabajador->persona->apellidos." ".
            $trabajador->persona->nombre."</p>
          <p>Dirección Domiciliaria: ".$trabajador->persona->direccion."</p>
          <p>Nº Documento de Identidad: ".$trabajador->persona->dni."</p>
          <p>Teléfono: ".$trabajador->persona->telefono."</p>
          <p>Unidad Destacada: ";
          foreach ($trabajador->puntos as $punto) {
            $html .= $punto->contrato->cliente->nombre." - ".$punto->nombre.", ";
          }
          $html .= "</p>
          <table class='borde-tabla'>
            <tr>
              <th>SERIE</th>
              <th>HERRAMIENTA</th>
              <th>MARCA</th>
              <th>MODELO</th>
              <th>DESCRIPCIÓN</th>
              <th>ENTREGA</th>
            </tr>";
            foreach ($trabajador->herramientas as $herramienta) {
              $html .= "
              <tr>
                <td>".$herramienta->serie."</td>
                <td>".$herramienta->herramienta->nombre."</td>
                <td>".$herramienta->marca."</td>
                <td>".$herramienta->modelo."</td>
                <td>".$herramienta->descripcion."</td>
                <td>".date('d-m-Y', strtotime($herramienta->pivot->entrega))."</td>
              </tr>";
            }
          $html .= "</table>
        </body>
      </html>";
    $pdf = PDF::loadHtml($html);
    return $pdf->setPaper('a4')->stream();
  }
}