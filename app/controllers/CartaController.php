<?php

class CartaController extends BaseController{

  public function getInicio($ruc){

    $empresa = Empresa::find($ruc);
    if($empresa){
      $cartas = Carta::where('empresa_ruc', '=', $ruc)->get();
      return View::make('carta.inicio')->with('cartas', $cartas)
        ->with('empresa', $empresa);
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function getNuevo($ruc){
    $empresa = Empresa::find($ruc);
    if($empresa){
      $carta = new Carta;
      return View::make('carta.nuevo')->with('empresa', $empresa)->with('carta', $carta);
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
    return Redirect::to('carta/nuevo/'.Input::get('empresa_ruc'));
  }

  public function postNumeracion(){
    $variable = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first();

    if($variable){
      //actualizamos el registro con el nuevo dato.
      $variable->inicio_carta = Input::get('numero');
      $variable->save();
    }else{
      //Creamos un nuevo registro con el año y la empresa
      $variable = new Variable;
      $variable->empresa_ruc = Input::get('empresa_ruc');
      $variable->inicio_carta = Input::get('numero');
      $variable->anio = date('Y');
      $variable->save();
    }
    return Redirect::to('carta/nuevo/'.Input::get('empresa_ruc'));
  }

  public function postNuevo(){
    if(Input::get('contenido') == ''){
      $mensaje = "EL CONTENIDO DE LA CARTA NO DEBE SER VACIO. INTENTE NUEVAMENTE.";
      return Redirect::to('carta/nuevo/'.Input::get('empresa_ruc'))
        ->with('rojo', $mensaje);
    }

    if(Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first()){

      if(!Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
        ->where('anio', '=', date('Y'))->first()->anio){

        $mensaje = "NO SE CONFIGURO EL NOMBRE DEL AÑO, RECUERDE QUE ESTO SOLO SE HACE UNA VEZ AL 
        AÑO. INTENTE NUEVAMENTE.";
        return Redirect::to('carta/nuevo/'.Input::get('empresa_ruc'))
          ->with('rojo', $mensaje);
      }else{
        $anio = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
        ->where('anio', '=', date('Y'))->first()->nombre_anio;
      }

      if(!Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first()->inicio_carta){

        $mensaje = "NO SE CONFIGURO LA NUMERACION DE LAS CARTAS, RECUERDE QUE ESTO SOLO SE HACE UNA VEZ AL 
        AÑO. INTENTE NUEVAMENTE.";
        return Redirect::to('carta/nuevo/'.Input::get('empresa_ruc'))
          ->with('rojo', $mensaje);
      }else{
        if(Carta::where('empresa_ruc', '=', Input::get('empresa_ruc'))
          ->orderBy('numero', 'desc')->first()){
          $nro = Carta::where('empresa_ruc', '=', Input::get('empresa_ruc'))
            ->orderBy('numero', 'desc')->first()->numero + 1;
        }else{
          $nro = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
            ->where('anio', '=', date('Y'))->first()->inicio_carta;
        }
      }
    }else{
      $mensaje = "NO SE CONFIGURO EL NOMBRE DEL AÑO, RECUERDE QUE ESTO SOLO SE HACE UNA VEZ AL 
      AÑO. INTENTE NUEVAMENTE.";
      return Redirect::to('carta/nuevo/'.Input::get('empresa_ruc'))
        ->with('rojo', $mensaje);
    }

    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $usuario = Usuario::find(Auth::user()->id);

    $codigo = 'CARTA Nº '.$nro.'-'.date('Y').'/'.$empresa->nombre;

    $carta = new Carta;
    $carta->usuario_id = Auth::user()->id;
    $carta->empresa_ruc = $empresa->ruc;
    $carta->anio = $anio;
    $carta->fecha = mb_strtoupper(Input::get('fecha'));
    $carta->numero = $nro;
    $carta->codigo = $codigo;
    $carta->destinatario = mb_strtoupper(Input::get('destinatario'));
    $carta->lugar = mb_strtoupper(Input::get('lugar'));
    $carta->asunto = mb_strtoupper(Input::get('asunto'));
    $carta->referencia = mb_strtoupper(Input::get('referencia'));
    $carta->contenido = Input::get('contenido');
    $carta->redaccion = date('Y-m-d');
    $carta->save();

    $html = "
    <!DOCTYPE html>
    <html>
      <head>
        <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>".$carta->codigo."</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' 
          name='viewport'>
      </head>
      <body>
        <style type='text/css'>
          .borde{
           border: 1px solid #000;
           padding-left: 10px;
           margin-left: 30%;
          }
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
        </style>
        <h1 class='titulo' align='center'>".$carta->anio."</h1><br>
        <p align='right'>".$carta->fecha."</p>
        <p>".$carta->codigo."</p>
        <p>Señores:<br>".
          $carta->destinatario."<br>".
          $carta->lugar."</p>";
        if($carta->asunto){
          $html .= "<p>ASUNTO: ".
            $carta->asunto."</p>";
        }elseif($carta->referencia){
          $html .= "<p>REFERENCIA: ".
            $carta->referencia."</p>";
        }
        $html .= "<p width=300>".$carta->contenido."
        </p>
        <p>Atte.
      </body>
    </html>
    ";

    define('BUDGETS_DIR', public_path('documentos/cartas/'.$empresa->ruc));

    if (!is_dir(BUDGETS_DIR)){
        mkdir(BUDGETS_DIR, 0755, true);
    }

    $nombre = $carta->numero;
    $ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

    $pdf = PDF::loadHtml($html);
    $pdf->setPaper('a4')->save($ruta);

    $mensaje = "LA CARTA SE GUARDO PERFECTAMENTE. AHORA PUEDE IMPRIMIRLO.";
    return Redirect::to('carta/mostrar/'.$carta->id)->with('verde', $mensaje);
  }

  public function getMostrar($id){
    $carta = Carta::find($id);
    return View::make('carta.mostrar')->with('carta', $carta);
  }

  public function getEditar($id){
    $carta = Carta::find($id);
    return View::make('carta.editar')->with('carta', $carta);
  }

  public function putEditar($id){
    if(Input::get('contenido') == ''){
      $mensaje = "EL CONTENIDO DE LA CARTA NO DEBE SER VACIO. INTENTE NUEVAMENTE.";
      return Redirect::to('carta/nuevo/'.Input::get('empresa_ruc'))
        ->with('rojo', $mensaje);
    }
    $carta = Carta::find($id);

    $empresa = $carta->empresa;
    $usuario = Usuario::find(Auth::user()->id);

    $codigo = 'CARTA Nº '.$carta->numero.'-'.date('Y', strtotime($carta->redaccion))
    .'/'.$empresa->nombre;

    $carta->usuario_id = Auth::user()->id;
    $carta->fecha = mb_strtoupper(Input::get('fecha'));
    $carta->codigo = $codigo;
    $carta->destinatario = mb_strtoupper(Input::get('destinatario'));
    $carta->lugar = mb_strtoupper(Input::get('lugar'));
    $carta->asunto = mb_strtoupper(Input::get('asunto'));
    $carta->referencia = mb_strtoupper(Input::get('referencia'));
    $carta->contenido = Input::get('contenido');
    $carta->save();

    $html = "
    <!DOCTYPE html>
    <html>
      <head>
        <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>".$carta->codigo."</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' 
          name='viewport'>
      </head>
      <body>
        <style type='text/css'>
          .borde{
           border: 1px solid #000;
           padding-left: 10px;
           margin-left: 30%;
          }
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
        </style>
        <h1 class='titulo' align='center'>".$carta->anio."</h1><br>
        <p align='right'>".$carta->fecha."</p>
        <p>".$carta->codigo."</p>
        <p>Señores:<br>".
          $carta->destinatario."<br>".
          $carta->lugar."</p>";
        if($carta->asunto){
          $html .= "<p>ASUNTO: ".
            $carta->asunto."</p>";
        }elseif($carta->referencia){
          $html .= "<p>REFERENCIA: ".
            $carta->referencia."</p>";
        }
        $html .= "<p width=300>".$carta->contenido."
        </p>
        <p>Atte.</p>
      </body>
    </html>
    ";

    define('BUDGETS_DIR', public_path('documentos/cartas/'.$empresa->ruc));

    if (!is_dir(BUDGETS_DIR)){
        mkdir(BUDGETS_DIR, 0755, true);
    }

    $nombre = $carta->numero;
    $ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

    $pdf = PDF::loadHtml($html);
    $pdf->setPaper('a4')->save($ruta);

    $mensaje = "LA CARTA SE ACTUALIZO PERFECTAMENTE. AHORA PUEDE IMPRIMIRLO.";
    return Redirect::to('carta/mostrar/'.$carta->id)->with('verde', $mensaje);
  }

  public function deleteBorrar($id){
    $carta = Carta::find($id);
    $ruc = $carta->empresa_ruc;
    if(Hash::check(Input::get('password'), Auth::user()->password)){
      File::delete('documentos/cartas/'.$carta->empresa_ruc.'/'.$carta->numero.
        '.pdf');
      $carta->delete();

      $mensaje = "LA CARTA FUE ELIMINADO CORRECTAMENTE.";
      return Redirect::to('carta/inicio/'.$ruc)->with('naranja', $mensaje);
    }else{
      $mensaje = "LA CONTRASEÑA ES INCORRECTA, INTENTE NUEVAMENTE.";
      return Redirect::to('carta/inicio/'.$carta->empresa_ruc)->with('rojo', $mensaje);
    }
  }
}