<?php

class PrendaController extends BaseController{

	public function getInicio($ruc){
		$empresa = Empresa::find($ruc);
		return View::make('prenda.inicio')->with('empresa', $empresa);
	}

	public function postNuevo(){
		$empresa = Empresa::find(Input::get('empresa'));

		$prenda = new Prenda;
		$prenda->nombre = mb_strtoupper(Input::get('nombre'));
		$prenda->talla = mb_strtoupper(Input::get('talla'));
		$prenda->save();

		if (strlen(Input::get('talla')) > 3) {
			$talla = substr(Input::get('talla'), 0, 3);
		}else{
			$talla = Input::get('talla');
		}

		$codigo = substr(str_replace(".", "", $empresa->nombre), 0, 3).$prenda->id
			.substr(mb_strtoupper(Input::get('nombre')), 0, 3).mb_strtoupper($talla);
		$empresa->prendas()->attach($prenda->id, array('codigo'=>$codigo));

		$mensaje = "LA PRENDA SE GUARDO PARA ESTA EMPRESA.";
		return Redirect::to('prenda/inicio/'.$empresa->ruc)->with('verde', $mensaje);
	}

	public function getReporte($ruc){
		$empresa = Empresa::find($ruc);

		$html = "
			<!DOCTYPE html>
			<html>
				<head>
					<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
					<title>REPORTE DE PRENDAS ".$empresa->nombre."</title>
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
          <h1 align='center'>REPORTE DE PRENDAS EN ALMACEN ".$empresa->nombre."</h1>
          <table class='borde-tabla'>
          	<tr>
          		<th>CÓDIGO</th>
          		<th>PRENDA</th>
          		<th>TALLA</th>
          		<th>PRIMERA</th>
          		<th>SEGUNDA</th>
          	</tr>";
          	foreach ($empresa->prendas as $prenda) {
          		$html .= "
          		<tr>
          			<td>".$prenda->pivot->codigo."</td>
          			<td>".$prenda->nombre."</td>
          			<td>".$prenda->talla."</td>
          			<td>".$prenda->pivot->cantidad_p."</td>
          			<td>".$prenda->pivot->cantidad_s."</td>
          		</tr>";
          	}
          $html .= "</table>
				</body>
			</html>";

		$pdf = PDF::loadHtml($html);
    return $pdf->setPaper('a4')->stream();
	}

	public function postAgregar(){
		
    $prenda = EmpresaPrenda::where('codigo', '=', Input::get('codigo'))->first();
    $prenda->cantidad_p += Input::get('cantidad_p');
    $prenda->cantidad_s += Input::get('cantidad_s');
    $prenda->save();

    $mensaje = "SE AGREGO LAS CANTIDADES CORRESPONDIENTES EN EL STOCK DE LA EMPRESA.";
    return Redirect::to('prenda/inicio/'.Input::get('empresa'))->with('verde', $mensaje);
	}

  public function postQuitar(){
    $prenda = EmpresaPrenda::where('codigo', '=', Input::get('codigo'))->first();
    if ($prenda->cantidad_p >= Input::get('cantidad_p') && 
      $prenda->cantidad_s >= Input::get('cantidad_s')) {
      $prenda->cantidad_p -= Input::get('cantidad_p');
      $prenda->cantidad_s -= Input::get('cantidad_s');
      $prenda->save();
    }else{
      $mensaje = "ESTA INTENTANDO QUITAR CANTIDADES MAYORES A LAS DEL ALMACEN.";
      return Redirect::to('prenda/inicio/'.Input::get('empresa'))->with('rojo', $mensaje);
    }

    $mensaje = "SE QUITO LAS CANTIDADES CORRESPONDIENTES EN EL STOCK DE LA EMPRESA";
    return Redirect::to('prenda/inicio/'.Input::get('empresa'))->with('verde', $mensaje);
  }

  public function deleteEliminar(){
    $prenda = EmpresaPrenda::where('codigo', '=', Input::get('codigo'))->first();
    if ($prenda->cantidad_p == 0 && $prenda->cantidad_s == 0) {
      $empresa_prenda_trabajador_usuario = EmpresaPrendaTrabajadorUsuario::where('empresa_ruc',
        '=', $prenda->empresa_ruc)->where('prenda_id', '=', $prenda->prenda_id)->get();
      if (count($empresa_prenda_trabajador_usuario) != 0) {
        $mensaje = "AUN HAY TRABAJADORES QUE TIENEN ESTA PRENDA.";
        return Redirect::to('prenda/inicio/'.Input::get('empresa'))->with('rojo', $mensaje);
      }else{
        $prenda = Prenda::find($prenda->prenda_id);
        $prenda->delete();
        $mensaje = "LA PRENDA SE ELIMINO DE LA LISTA EXITOSAMENTE.";
        return Redirect::to('prenda/inicio/'.Input::get('empresa'))->with('verde', $mensaje);
      }
    }else{
      $mensaje = "AUN EXISTE STOCK DE ESTA PRENDA EN EL ALMACEN DE LA EMPRESA.";
      return Redirect::to('prenda/inicio/'.Input::get('empresa'))->with('rojo', $mensaje);
    }
  }

  public function getDotar($id){
    $trabajador = Trabajador::find($id);
    return View::make('prenda.dotar')->with('trabajador', $trabajador);
  }

  public function postDotar($ruc, $id){
    $empresa = Empresa::find($ruc);
    $trabajador = Trabajador::find($id);
    $prenda = EmpresaPrenda::where('codigo', '=', Input::get('codigo'))->first();
    if ($prenda->cantidad_p >= Input::get('cantidad_p') && $prenda->cantidad_s >= 
      Input::get('cantidad_s')) {
      $prenda->cantidad_p -= Input::get('cantidad_p');
      $prenda->cantidad_s -= Input::get('cantidad_s');
      $prenda->save();

      $empresa_prenda_trabajador_usuario = EmpresaPrendaTrabajadorUsuario::where('empresa_ruc',
        '=', $ruc)->where('prenda_id', '=', $prenda->prenda_id)->where('trabajador_id', '=', 
        $id)->first();

      if ($empresa_prenda_trabajador_usuario) {
        $empresa_prenda_trabajador_usuario->cantidad_p += Input::get('cantidad_p');
        $empresa_prenda_trabajador_usuario->cantidad_s += Input::get('cantidad_s');
        $empresa_prenda_trabajador_usuario->usuario_id = Auth::user()->id;
        $empresa_prenda_trabajador_usuario->save();
      }else{
        $empresa_prenda_trabajador_usuario = new EmpresaPrendaTrabajadorUsuario;
        $empresa_prenda_trabajador_usuario->empresa_ruc = $ruc;
        $empresa_prenda_trabajador_usuario->prenda_id = $prenda->prenda_id;
        $empresa_prenda_trabajador_usuario->trabajador_id = $id;
        $empresa_prenda_trabajador_usuario->usuario_id = Auth::user()->id;
        $empresa_prenda_trabajador_usuario->cantidad_p = Input::get('cantidad_p');
        $empresa_prenda_trabajador_usuario->cantidad_s = Input::get('cantidad_s');
        $empresa_prenda_trabajador_usuario->save();
      }

      return Redirect::to('prenda/dotar/'.$id);
    }else{
      $mensaje = "NO HAY SUFICIENTE STOCK PARA DOTAR DE LAS PRENDAS AL TRABAJADOR";
      return Redirect::to('prenda/dotar/'.$id)->with('rojo', $mensaje);
    }
  }

  public function postRecoger(){
    $prenda = EmpresaPrenda::where('codigo', '=', Input::get('codigo'))->first();
    if ($prenda) {

      $empresa_prenda_trabajador_usuario = EmpresaPrendaTrabajadorUsuario::where('empresa_ruc',
        '=', Input::get('ruc'))->where('prenda_id', '=', $prenda->prenda_id)
        ->where('trabajador_id', '=', Input::get('id'))->first();
      if ($empresa_prenda_trabajador_usuario) {

        if ($empresa_prenda_trabajador_usuario->cantidad_p >= Input::get('cantidad_p') &&
          $empresa_prenda_trabajador_usuario->cantidad_s >= Input::get('cantidad_s')) {
          
          $prenda->cantidad_p += Input::get('cantidad_p');
          $prenda->cantidad_s += Input::get('cantidad_s');
          $prenda->save();

          $empresa_prenda_trabajador_usuario->cantidad_p -= Input::get('cantidad_p');
          $empresa_prenda_trabajador_usuario->cantidad_s -= Input::get('cantidad_s');
          $empresa_prenda_trabajador_usuario->usuario_id = Auth::user()->id;
          $empresa_prenda_trabajador_usuario->save();

          if ($empresa_prenda_trabajador_usuario->cantidad_p == 0 &&
            $empresa_prenda_trabajador_usuario->cantidad_s == 0) {
            $empresa_prenda_trabajador_usuario->delete();
          }

          $html = "<table class='table table-hover'>
            <tr>
              <th>Código</th>
              <th>Prenda</th>
              <th>Primera</th>
              <th>Segunda</th>
            </tr>";
            foreach(Trabajador::find(Input::get('id'))->prendas as $prenda){
              $html .= "<tr>
                <td>".Trabajador::find(Input::get('id'))->empresa->prendas->find($prenda->id)->pivot->codigo."</td>
                <td>".$prenda->nombre." ".$prenda->talla."</td>
                <td>".$prenda->pivot->cantidad_p."</td>
                <td>".$prenda->pivot->cantidad_s."</td>
              </tr>";
            }
            $html .= "</table>";
          $respuesta = array('respuesta' => 1, 'html' => $html);
        }else{
          $html = "<div class='alert alert-danger alert-dismissable'>
              <i class='fa fa-info'></i>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
                &times;</button>
              <b>Alerta!</b> EL TRABAJADOR NO TIENE ESTA CANTIDAD DE ESTAS PRENDAS.
            </div>";
          $respuesta = array('respuesta' => 0, 'html' => $html);
        }
      }else{
        $html = "<div class='alert alert-danger alert-dismissable'>
            <i class='fa fa-info'></i>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
              &times;</button>
            <b>Alerta!</b> ESTA PRENDA NO PERTENECE A ESTE TRABAJADOR.
          </div>";
        $respuesta = array('respuesta' => 0, 'html' => $html);
      }
    }else{
      //Si no existe una prenda regresamos a la vista con un mensaje de error.
      $html = "<div class='alert alert-danger alert-dismissable'>
          <i class='fa fa-info'></i>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
            &times;</button>
          <b>Alerta!</b> ESTA PRENDA NO EXISTE.
        </div>";
      $respuesta = array('respuesta' => 0, 'html' => $html);
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
          <title>REPORTE DE PRENDAS ".$trabajador->persona->nombre." "
            .$trabajador->persona->nombre."</title>
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
          <h1 align='center'>REPORTE DE PRENDAS DE ".$trabajador->persona->nombre." "
            .$trabajador->persona->apellidos."</h1>
          <table class='borde-tabla'>
            <tr>
              <th>CÓDIGO</th>
              <th>PRENDA</th>
              <th>TALLA</th>
              <th>PRIMERA</th>
              <th>SEGUNDA</th>
            </tr>";
            foreach ($trabajador->prendas as $prenda) {
              $html .= "
              <tr>
                <td>".$trabajador->empresa->prendas()->find($prenda->id)->codigo."</td>
                <td>".$prenda->nombre."</td>
                <td>".$prenda->talla."</td>
                <td>".$prenda->pivot->cantidad_p."</td>
                <td>".$prenda->pivot->cantidad_s."</td>
              </tr>";
            }
          $html .= "</table>
        </body>
      </html>";
    $pdf = PDF::loadHtml($html);
    return $pdf->setPaper('a4')->stream();
  }

}