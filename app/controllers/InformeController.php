<?php

class InformeController extends BaseController{

  public function getInicio($ruc){

    $empresa = Empresa::find($ruc);
    if($empresa){
      $informes = Informe::where('empresa_ruc', '=', $ruc)->get();
      return View::make('informe.inicio')->with('informes', $informes)
        ->with('empresa', $empresa);
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function getNuevo($ruc){
    $empresa = Empresa::find($ruc);
    if($empresa){
      $informe = new Informe;
      return View::make('informe.nuevo')->with('empresa', $empresa)->with('informe', $informe);
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function postAnio(){
    $variable = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first();

    if($variable){
      //actualizamos el registro con el nuevo dato.
      $variable->nombre_anio = mb_strtoupper(Input::get('nombre'));
      $variable->save();
    }else{
      //Creamos un nuevo registro con el año y la empresa
      $variable = new Variable;
      $variable->empresa_ruc = Input::get('empresa_ruc');
      $variable->nombre_anio = mb_strtoupper(Input::get('nombre'));
      $variable->anio = date('Y');
      $variable->save();
    }
    return Redirect::to('informe/nuevo/'.Input::get('empresa_ruc'));
  }

  public function postNumeracion(){
    $variable = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first();

    if($variable){
      //actualizamos el registro con el nuevo dato.
      $variable->inicio_informe = Input::get('numero');
      $variable->save();
    }else{
      //Creamos un nuevo registro con el año y la empresa
      $variable = new Variable;
      $variable->empresa_ruc = Input::get('empresa_ruc');
      $variable->inicio_informe = Input::get('numero');
      $variable->anio = date('Y');
      $variable->save();
    }
    return Redirect::to('informe/nuevo/'.Input::get('empresa_ruc'));
  }

  public function postNuevo(){

    set_time_limit(300);

    if(Input::get('contenido') == ''){
      $mensaje = "EL CONTENIDO DE LA CARTA NO DEBE SER VACIO. INTENTE NUEVAMENTE.";
      return Redirect::to('informe/nuevo/'.Input::get('empresa_ruc'))
        ->with('rojo', $mensaje);
    }

    if(Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first()){

      if(!Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
        ->where('anio', '=', date('Y'))->first()->anio){

        $mensaje = "NO SE CONFIGURO EL NOMBRE DEL AÑO, RECUERDE QUE ESTO SOLO SE HACE UNA VEZ AL 
        AÑO. INTENTE NUEVAMENTE.";
        return Redirect::to('informe/nuevo/'.Input::get('empresa_ruc'))
          ->with('rojo', $mensaje);
      }else{
        $anio = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
        ->where('anio', '=', date('Y'))->first()->nombre_anio;
      }

      if(!Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first()->inicio_informe){

        $mensaje = "NO SE CONFIGURO LA NUMERACION DE LOS INFORMES, RECUERDE QUE ESTO SOLO SE HACE UNA VEZ AL 
        AÑO. INTENTE NUEVAMENTE.";
        return Redirect::to('informe/nuevo/'.Input::get('empresa_ruc'))
          ->with('rojo', $mensaje);
      }else{
        if(Informe::where('empresa_ruc', '=', Input::get('empresa_ruc'))
          ->orderBy('numero', 'desc')->first()){
          $nro = Informe::where('empresa_ruc', '=', Input::get('empresa_ruc'))
            ->orderBy('numero', 'desc')->first()->numero + 1;
        }else{
          $nro = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
            ->where('anio', '=', date('Y'))->first()->inicio_informe;
        }
      }
    }else{
      $mensaje = "NO SE CONFIGURO EL NOMBRE DEL AÑO, RECUERDE QUE ESTO SOLO SE HACE UNA VEZ AL 
      AÑO. INTENTE NUEVAMENTE.";
      return Redirect::to('informe/nuevo/'.Input::get('empresa_ruc'))
        ->with('rojo', $mensaje);
    }

    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $usuario = Usuario::find(Auth::user()->id);

    $codigo = 'INFORME Nº '.$nro.'-'.date('Y').'/'.$empresa->nombre;
    
    $informe = new Informe;
    $informe->usuario_id = Auth::user()->id;
    $informe->empresa_ruc = $empresa->ruc;
    $informe->remite = mb_strtoupper(Input::get('remite'));
    $informe->cargo_remite = mb_strtoupper(Input::get('cargo_remite'));
    $informe->anio = $anio;
    $informe->fecha = mb_strtoupper(Input::get('fecha'));
    $informe->numero = $nro;
    $informe->codigo = $codigo;
    $informe->destinatario = mb_strtoupper(Input::get('destinatario'));
    $informe->cargo_destinatario = mb_strtoupper(Input::get('cargo_destinatario'));
    $informe->asunto = mb_strtoupper(Input::get('asunto'));
    $informe->contenido = Input::get('contenido');
    $informe->redaccion = date('Y-m-d');
    $informe->save();

    $html = "
    <!DOCTYPE html>
    <html>
      <head>
        <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>".$informe->codigo."</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' 
          name='viewport'>
      </head>
      <body>
        <style type='text/css'>
          .titulo{
            font-size: 9pt;
            text-decoration: underline;
          }
          .borde{
           border: 1px solid #000;
           padding-left: 10px;
           margin-left: 30%;
          }
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
        </style>
        <h1 align='center'>".$informe->anio."</h1><br>
        <p class='titulo' align='left'><b>".$informe->codigo."</b></p>
        <table>
          <tr valign=top>
            <td height=30><b>PARA</b></td>
            <td><b>:".$informe->destinatario."<br>".
            $informe->cargo_destinatario."</b></td>
          </tr>
          <tr valign=top>
            <td width=100 height=50><b>DE</b></td>
            <td><b>:".$informe->remite."<br>".
            $informe->cargo_remite."</b></td>
          </tr>
          <tr valign=top>
            <td height=30><b>ASUNTO</b></td>
            <td><b>:".$informe->asunto."</b></td>
          </tr>
          <tr valign=top>
            <td height=30><b>FECHA</b></td>
            <td><b>:".$informe->fecha."</b></td>
          </tr>
        </table><hr>
        <p width=300>".$informe->contenido."
        </p>
        <p align='center'>Atentamente,</p>
      </body>
    </html>
    ";

    $html = str_replace("&ndash;", "-", $html);

    define('BUDGETS_DIR', public_path('documentos/informes/'.$empresa->ruc));

    if (!is_dir(BUDGETS_DIR)){
        mkdir(BUDGETS_DIR, 0755, true);
    }

    $nombre = $informe->numero;
    $ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

    $pdf = PDF::loadHtml($html);
    $pdf->setPaper('a4')->save($ruta);

    $mensaje = "EL INFORME SE GUARDO PERFECTAMENTE. AHORA PUEDE IMPRIMIRLO.";
    return Redirect::to('informe/mostrar/'.$informe->id)->with('verde', $mensaje);
  }

  public function getMostrar($id){
    $informe = Informe::find($id);
    return View::make('informe.mostrar')->with('informe', $informe);
  }

  public function getEditar($id){
    $informe = Informe::find($id);
    return View::make('informe.editar')->with('informe', $informe);
  }

  public function putEditar($id){

    set_time_limit(300);

    if(Input::get('contenido') == ''){
      $mensaje = "EL CONTENIDO DE LA CARTA NO DEBE SER VACIO. INTENTE NUEVAMENTE.";
      return Redirect::to('informe/nuevo/'.Input::get('empresa_ruc'))
        ->with('rojo', $mensaje);
    }
    $informe = Informe::find($id);

    $empresa = $informe->empresa;
    $usuario = Usuario::find(Auth::user()->id);

    $codigo = 'INFORME Nº '.$informe->numero.'-'.date('Y', strtotime($informe->redaccion))
    .'/'.$empresa->nombre;

    $informe->usuario_id = Auth::user()->id;
    $informe->remite = mb_strtoupper(Input::get('remite'));
    $informe->cargo_remite = mb_strtoupper(Input::get('cargo_remite'));
    $informe->fecha = mb_strtoupper(Input::get('fecha'));
    $informe->codigo = $codigo;
    $informe->destinatario = mb_strtoupper(Input::get('destinatario'));
    $informe->cargo_destinatario = mb_strtoupper(Input::get('cargo_destinatario'));
    $informe->asunto = mb_strtoupper(Input::get('asunto'));
    $informe->contenido = Input::get('contenido');
    $informe->save();

    $html = "
    <!DOCTYPE html>
    <html>
      <head>
        <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>".$informe->codigo."</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' 
          name='viewport'>
      </head>
      <body>
        <style type='text/css'>
          .titulo{
            font-size: 9pt;
            text-decoration: underline;
          }
          .borde{
           border: 1px solid #000;
           padding-left: 10px;
           margin-left: 30%;
          }
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
        </style>
        <h1 align='center'>".$informe->anio."</h1><br>
        <p class='titulo' align='left'><b>".$informe->codigo."</b></p>
        <table>
          <tr valign=top>
            <td height=30><b>PARA</b></td>
            <td><b>:".$informe->destinatario."<br>".
            $informe->cargo_destinatario."</b></td>
          </tr>
          <tr valign=top>
            <td width=100 height=50><b>DE</b></td>
            <td><b>:".$informe->remite."<br>".
            $informe->cargo_remite."</b></td>
          </tr>
          <tr valign=top>
            <td height=30><b>ASUNTO</b></td>
            <td><b>:".$informe->asunto."</b></td>
          </tr>
          <tr valign=top>
            <td height=30><b>FECHA</b></td>
            <td><b>:".$informe->fecha."</b></td>
          </tr>
        </table><hr>
        <p width=300>".$informe->contenido."
        </p>
        <p align='center'>Atentamente,</p>
      </body>
    </html>
    ";

    $html = str_replace("&ndash;", "-", $html);

    define('BUDGETS_DIR', public_path('documentos/informes/'.$empresa->ruc));

    $nombre = $informe->numero;
    $ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

    $pdf = PDF::loadHtml($html);
    $pdf->setPaper('a4')->save($ruta);

    $mensaje = "EL INFORME SE ACTUALIZO PERFECTAMENTE. AHORA PUEDE IMPRIMIRLO.";
    return Redirect::to('informe/mostrar/'.$informe->id)->with('verde', $mensaje);
  }

  public function deleteBorrar($id){

    set_time_limit(300);
    
    $informe = Informe::find($id);
    $ruc = $informe->empresa_ruc;
    if(Hash::check(Input::get('password'), Auth::user()->password)){
      File::delete('documentos/informes/'.$informe->empresa_ruc.'/'.$informe->numero.
        '.pdf');
      $informe->delete();

      $mensaje = "EL INFORME FUE ELIMINADO CORRECTAMENTE.";
      return Redirect::to('informe/inicio/'.$ruc)->with('naranja', $mensaje);
    }else{
      $mensaje = "LA CONTRASEÑA ES INCORRECTA, INTENTE NUEVAMENTE.";
      return Redirect::to('informe/inicio/'.$informe->empresa_ruc)->with('rojo', $mensaje);
    }
  }
}