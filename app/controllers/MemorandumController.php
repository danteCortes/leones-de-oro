<?php

class MemorandumController extends BaseController{

  public function getInicio($ruc){

    $empresa = Empresa::find($ruc);
    if($empresa){
      $memorandums = Memorandum::where('empresa_ruc', '=', $ruc)->get();
      return View::make('memorandum.inicio')->with('memorandums', $memorandums)
        ->with('empresa', $empresa);
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function getNuevo($ruc){
    $empresa = Empresa::find($ruc);
    if($empresa){
      $trabajadores = $empresa->trabajadores;
      $memorandum = new Memorandum;
      return View::make('memorandum.nuevo')->with('empresa', $empresa)
        ->with('trabajadores', $trabajadores)->with('memorandum', $memorandum);
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function getNuevoMultiple($ruc){
    $empresa = Empresa::find($ruc);
    if($empresa){
      $trabajadores = $empresa->trabajadores;
      $clientes = $empresa->clientes;
      $memorandum = new Memorandum;
      return View::make('memorandum.nuevoMultiple')->with('empresa', $empresa)
        ->with('trabajadores', $trabajadores)->with('memorandum', $memorandum)
        ->with('clientes', $clientes);
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function postAgregarTrabajador(){
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $trabajadores = $empresa->trabajadores;

    foreach($trabajadores as $trabajador){

      if(Input::get('trabajador_nombre_apellidos') == $trabajador->persona->nombre." ".
        $trabajador->persona->apellidos){
        return $trabajador;
      }
    }
    return 0;
  }

  public function postNuevoMultiple(){
    set_time_limit(300);

    if(Input::get('contenido') == ''){
      $mensaje = "EL CONTENIDO DEL MEMORANDUM NO DEBE SER VACIO. INTENTE NUEVAMENTE.";
      return Redirect::to('memorandum/nuevo/'.Input::get('empresa_ruc'))
        ->with('rojo', $mensaje);
    }

    if(Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first()){

      if(!Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first()->inicio_memorandum){

        $mensaje = "NO SE CONFIGURO LA NUMERACION DE LOS MEMORANDUMS, RECUERDE QUE ESTO SOLO
        SE HACE UNA VEZ AL AÑO. INTENTE NUEVAMENTE.";
        return Redirect::to('memorandum/nuevo/'.Input::get('empresa_ruc'))
          ->with('rojo', $mensaje);
      }else{

        if(Memorandum::where('empresa_ruc', '=', Input::get('empresa_ruc'))
          ->orderBy('id', 'desc')->first()){

          if(date('Y', strtotime(Memorandum::where('empresa_ruc', '=', Input::get('empresa_ruc'))
            ->orderBy('id', 'desc')->first()->redaccion)) == date('Y')){

            $nro = Memorandum::where('empresa_ruc', '=', Input::get('empresa_ruc'))
              ->orderBy('id', 'desc')->first()->numero + 1;
          }else{

            $nro = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
              ->where('anio', '=', date('Y'))->first()->inicio_memorandum;
          }
        }else{
          
          $nro = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
            ->where('anio', '=', date('Y'))->first()->inicio_memorandum;
        }
      }
    }else{
      $mensaje = "NO SE CONFIGURO LA NUMERACION DE LOS MEMORANDUMS, RECUERDE QUE ESTO SOLO
      SE HACE UNA VEZ AL AÑO. INTENTE NUEVAMENTE.";
      return Redirect::to('memorandum/nuevo/'.Input::get('empresa_ruc'))
        ->with('rojo', $mensaje);
    }

    $remite = Usuario::find(Input::get('remite'));
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $usuario = Usuario::find(Auth::user()->id);
    $area = Area::find($remite->empresas()->find($empresa->ruc)->area_id);

    $codigo = 'MEMORANDUM MULTIPLE Nº '.$nro.'-'.date('Y').'/'.$area->abreviatura.'/'
      .$empresa->nombre;
    $trabajadores = [];
    $cliente = Cliente::find(Input::get('cliente'));

    if (Input::get('todos') != null) {
      foreach ($empresa->trabajadores as $trabajador) {
        array_push($trabajadores, $trabajador);
      }
    }elseif (Input::get('cliente') != null) {
      $cliente = Cliente::find(Input::get('cliente'));
      $contratos = $cliente->contratos;
      foreach ($contratos as $contrato) {
        foreach ($contrato->puntos as $punto) {
          foreach ($punto->trabajadores as $trabajador) {
            if (count($trabajadores) != 0) {
              foreach ($trabajadores as $key) {
                if ($trabajador->id != $key->id) {
                  array_push($trabajadores, $trabajador);
                }else{
                  break;
                }
              }
            }else{
              array_push($trabajadores, $trabajador);
            }
          }
        }
      }
    }

    foreach ($empresa->trabajadores as $trabajador) {
      if(Input::get('trabajador'.$trabajador->persona_dni) == $trabajador->persona_dni){
        foreach ($trabajadores as $key) {
          if ($trabajador->id != $key->id) {
            array_push($trabajadores, $trabajador);
            break;
          }else{
            break;
          }
        }
      }
    }

    if (count($trabajadores) == 0) {
      $mensaje = "DEBE SELECCIONAR AL MENOS UN TRABAJADOR PARA, EMITIR UN MEMORANDUM";
      return Redirect::to('memorandum/nuevo-multiple/'.$empresa->ruc)->with('rojo', $mensaje);
    }

    $memorandum = new Memorandum;
    $memorandum->usuario_id = Auth::user()->id;
    $memorandum->remite = $remite->id;
    $memorandum->area_id = $area->id;
    $memorandum->empresa_ruc = $empresa->ruc;
    $memorandum->asunto = mb_strtoupper(Input::get('asunto'));
    $memorandum->tipo_memorandum_id = Input::get('razon');
    $memorandum->codigo = $codigo;
    $memorandum->numero = $nro;
    $memorandum->fecha = mb_strtoupper(Input::get('fecha'));
    $memorandum->redaccion = date('Y-m-d');
    $memorandum->contenido = Input::get('contenido');
    $memorandum->save();

    foreach($trabajadores as $trabajador){
      $trabajador->memorandums()->attach($memorandum->id);
    }

    $html = "
      <!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
          <title>".$memorandum->codigo."</title>
          <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
            name='viewport'>
        </head>
        <body>
          <style type='text/css'>
            .titulo{
              font-size: 14pt;
              font-family: monospace;
              text-decoration: underline;
            }
            .borde{
             border: 1px solid #000;
             padding-left: 10px;
             margin-left: 30%;
            }
            .cuerpo{
              font-size: 12pt;
              font-family: monospace;
            }
          </style>
          <img src='documentos/membretes/".$memorandum->empresa_ruc.".jpg' width=100%>
          <h1 class='titulo' align='left'>".$memorandum->codigo."</h1><br>
          <table>
            <tr valign=top>
              <td width=100 height=50><b>DE</b></td>
              <td><b>:".Usuario::find($memorandum->remite)->persona->nombre." ".
                Usuario::find($memorandum->remite)->persona->apellidos."<br>".
                Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
                  ->area_id)->nombre."</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>A</b></td>
              <td><b>:MEMORANDUM MULTIPLE</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>ASUNTO</b></td>
              <td><b>:".$memorandum->asunto."</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>FECHA</b></td>
              <td><b>:".$memorandum->fecha."</b></td>
            </tr>
          </table><hr>
          <p width=300>".$memorandum->contenido."
          </p>
          <p align='center'>Atentamente,</p><br><br><br><br><br><p align='center'>
          ___________________________<br>".
          Usuario::find($memorandum->remite)->persona->nombre."<br>".
          Usuario::find($memorandum->remite)->persona->apellidos."<br>".
          Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
            ->area_id)->nombre."</p>
        </body>
      </html>
      ";

    $html = str_replace("&ndash;", "-", $html);

    define('BUDGETS_DIR', public_path('documentos/memorandums/'.$empresa->ruc));

    if (!is_dir(BUDGETS_DIR)){
        mkdir(BUDGETS_DIR, 0755, true);
    }

    $nombre = $memorandum->numero;
    $ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

    $pdf = PDF::loadHtml($html);
    $pdf->setPaper('a4')->save($ruta);

    $mensaje = "EL MEMORANDUM SE GUARDO PERFECTAMENTE. AHORA PUEDE IMPRIMIRLO.";
    return Redirect::to('memorandum/mostrar/'.$memorandum->id)->with('verde', $mensaje);
  }

  public function postArea(){
    $usuario = Usuario::find(Input::get('usuario_id'));
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $area = Area::find($empresa->usuarios()->find($usuario->id)->area_id);
    return Response::json($area);
  }

  public function postNuevo(){
    set_time_limit(300);

    if(Input::get('contenido') == ''){
      $mensaje = "EL CONTENIDO DEL MEMORANDUM NO DEBE SER VACIO. INTENTE NUEVAMENTE.";
      return Redirect::to('memorandum/nuevo/'.Input::get('empresa_ruc'))
        ->with('rojo', $mensaje);
    }

    if(Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first()){

      if(!Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first()->inicio_memorandum){

        $mensaje = "NO SE CONFIGURO LA NUMERACION DE LOS MEMORANDUMS, RECUERDE QUE ESTO SOLO
        SE HACE UNA VEZ AL AÑO. INTENTE NUEVAMENTE.";
        return Redirect::to('memorandum/nuevo/'.Input::get('empresa_ruc'))
          ->with('rojo', $mensaje);
      }else{

        if(Memorandum::where('empresa_ruc', '=', Input::get('empresa_ruc'))
          ->orderBy('id', 'desc')->first()){

          if(date('Y', strtotime(Memorandum::where('empresa_ruc', '=', Input::get('empresa_ruc'))
            ->orderBy('id', 'desc')->first()->redaccion)) == date('Y')){

            $nro = Memorandum::where('empresa_ruc', '=', Input::get('empresa_ruc'))
              ->orderBy('id', 'desc')->first()->numero + 1;
          }else{

            $nro = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
              ->where('anio', '=', date('Y'))->first()->inicio_memorandum;
          }
        }else{

          $nro = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
            ->where('anio', '=', date('Y'))->first()->inicio_memorandum;
        }
      }
    }else{
      $mensaje = "NO SE CONFIGURO EL NOMBRE DEL AÑO, RECUERDE QUE ESTO SOLO SE HACE UNA VEZ AL
      AÑO. INTENTE NUEVAMENTE.";
      return Redirect::to('memorandum/nuevo/'.Input::get('empresa_ruc'))
        ->with('rojo', $mensaje);
    }

    $remite = Usuario::find(Input::get('remite'));
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $usuario = Usuario::find(Auth::user()->id);
    $area = Area::find($remite->empresas()->find($empresa->ruc)->area_id);

    $codigo = 'MEMORANDUM Nº '.$nro.'-'.date('Y').'/'.$area->abreviatura.'/'.$empresa->nombre;

    $memorandum = new Memorandum;
    $memorandum->usuario_id = Auth::user()->id;
    $memorandum->remite = $remite->id;
    $memorandum->area_id = $area->id;
    $memorandum->empresa_ruc = $empresa->ruc;
    $memorandum->asunto = mb_strtoupper(Input::get('asunto'));
    $memorandum->tipo_memorandum_id = Input::get('razon');
    $memorandum->codigo = $codigo;
    $memorandum->numero = $nro;
    $memorandum->fecha = mb_strtoupper(Input::get('fecha'));
    $memorandum->redaccion = date('Y-m-d');
    $memorandum->contenido = Input::get('contenido');
    $memorandum->save();

    $memorandum->trabajadores()->attach(Input::get('trabajador_id'));

    $html = "
      <!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
          <title>".$memorandum->codigo."</title>
          <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
            name='viewport'>
        </head>
        <body>
          <style type='text/css'>
            .titulo{
              font-size: 14pt;
              font-family: monospace;
              text-decoration: underline;
            }
            .borde{
             border: 1px solid #000;
             padding-left: 10px;
             margin-left: 30%;
            }
            .cuerpo{
              font-size: 12pt;
              font-family: monospace;
            }
          </style>
          <img src='documentos/membretes/".$memorandum->empresa_ruc.".jpg' width=100%>
          <h1 class='titulo' align='left'>".$memorandum->codigo."</h1><br>
          <table>
            <tr valign=top>
              <td width=100 height=50><b>DE</b></td>
              <td><b>:".Usuario::find($memorandum->remite)->persona->nombre." ".
                Usuario::find($memorandum->remite)->persona->apellidos."<br> ".
                Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
                  ->area_id)->nombre."</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>A</b></td>
              <td><b>:".Trabajador::find($memorandum->trabajadores()->find(Input::get('trabajador_id'))->trabajador_id)->persona->nombre." ".
              Trabajador::find($memorandum->trabajadores()->find(Input::get('trabajador_id'))->trabajador_id)->persona->apellidos."</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>ASUNTO</b></td>
              <td><b>:".$memorandum->asunto."</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>FECHA</b></td>
              <td><b>:".$memorandum->fecha."</b></td>
            </tr>
          </table><hr>
          <p width=300>".$memorandum->contenido."
          </p>
          <p align='center'>Atentamente,</p><br><br><br><br><br><p align='center'>
          ___________________________<br>".
          Usuario::find($memorandum->remite)->persona->nombre."<br>".
          Usuario::find($memorandum->remite)->persona->apellidos."<br>".
          Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
            ->area_id)->nombre."</p>
        </body>
      </html>
      ";

    $html = str_replace("&ndash;", "-", $html);

    define('BUDGETS_DIR', public_path('documentos/memorandums/'.$empresa->ruc));

    if (!is_dir(BUDGETS_DIR)){
        mkdir(BUDGETS_DIR, 0755, true);
    }

    $nombre = $memorandum->numero;
    $ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

    $pdf = PDF::loadHtml($html);
    $pdf->setPaper('a4')->save($ruta);

    $mensaje = "EL MEMORANDUM SE GUARDO PERFECTAMENTE. AHORA PUEDE IMPRIMIRLO.";
    return Redirect::to('memorandum/mostrar/'.$memorandum->id)->with('verde', $mensaje);
  }

  public function getMostrar($id){
    $memorandum = Memorandum::find($id);
    return View::make('memorandum.mostrar')->with('memorandum', $memorandum);
  }

  public function postNumeracion(){

    $variable = Variable::where('empresa_ruc', '=', Input::get('empresa_ruc'))
      ->where('anio', '=', date('Y'))->first();

    if($variable){
      //actualizamos el registro con el nuevo dato.
      $variable->inicio_memorandum = Input::get('numero');
      $variable->save();
    }else{
      //Creamos un nuevo registro con el año y la empresa
      $variable = new Variable;
      $variable->empresa_ruc = Input::get('empresa_ruc');
      $variable->inicio_memorandum = Input::get('numero');
      $variable->anio = date('Y');
      $variable->save();
    }

    return Redirect::to('memorandum/nuevo/'.Input::get('empresa_ruc'));
  }

  public function postTrabajador(){
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $trabajadores = $empresa->trabajadores;

    foreach($trabajadores as $trabajador){

      if(Input::get('trabajador_nombre_apellidos') == $trabajador->persona->nombre." ".
        $trabajador->persona->apellidos){
        return $trabajador;
      }
    }
    return 0;
  }

  public function getEditar($id){
    $memorandum = Memorandum::find($id);
    $empresa = $memorandum->empresa;
    $trabajadores = $empresa->trabajadores;
    return View::make('memorandum.editar')->with('memorandum', $memorandum)
      ->with('empresa', $empresa)->with('trabajadores', $trabajadores);
  }

  public function getEditarMultiple($id){
    $memorandum = Memorandum::find($id);
    $empresa = $memorandum->empresa;
    $trabajadores = $empresa->trabajadores;
    $clientes = $empresa->clientes;
    return View::make('memorandum.editarMultiple')->with('memorandum', $memorandum)
      ->with('empresa', $empresa)->with('trabajadores', $trabajadores)
      ->with('clientes', $clientes);
  }

  public function putEditar($id){
    set_time_limit(300);

    if(Input::get('contenido') == ''){
      $mensaje = "EL CONTENIDO DEL MEMORANDUM NO DEBE SER VACIO. INTENTE NUEVAMENTE.";
      return Redirect::to('memorandum/editar/'.$id)
        ->with('rojo', $mensaje);
    }

    $memorandum = Memorandum::find($id);

    $remite = Usuario::find(Input::get('remite'));
    $empresa = $memorandum->empresa;
    $usuario = Usuario::find(Auth::user()->id);
    $area = Area::find($remite->empresas()->find($empresa->ruc)->area_id);

    $codigo = 'MEMORANDUM Nº '.$memorandum->numero.'-'.date('Y', strtotime($memorandum->redaccion))
    .'/'.$area->abreviatura.'/'.$empresa->nombre;

    $memorandum->usuario_id = Auth::user()->id;
    $memorandum->remite = $remite->id;
    $memorandum->area_id = $area->id;
    $memorandum->asunto = strtoupper(Input::get('asunto'));
    $memorandum->tipo_memorandum_id = Input::get('razon');
    $memorandum->codigo = $codigo;
    $memorandum->fecha = strtoupper(Input::get('fecha'));
    $memorandum->contenido = Input::get('contenido');
    $memorandum->save();

    foreach ($memorandum->trabajadores as $trabajador) {
      $memorandum->trabajadores()->updateExistingPivot($trabajador->id,
        array('trabajador_id'=>Input::get('trabajador_id')));
    };

    $html = "
      <!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
          <title>".$memorandum->codigo."</title>
          <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
            name='viewport'>
        </head>
        <body>
          <style type='text/css'>
            .titulo{
              font-size: 14pt;
              font-family: monospace;
              text-decoration: underline;
            }
            .borde{
             border: 1px solid #000;
             padding-left: 10px;
             margin-left: 30%;
            }
            .cuerpo{
              font-size: 12pt;
              font-family: monospace;
            }
          </style>
          <img src='documentos/membretes/".$memorandum->empresa_ruc.".jpg' width=100%>
          <h1 class='titulo' align='left'>".$memorandum->codigo."</h1><br>
          <table>
            <tr valign=top>
              <td width=100 height=50><b>DE</b></td>
              <td><b>:".Usuario::find($memorandum->remite)->persona->nombre." ".
                Usuario::find($memorandum->remite)->persona->apellidos."<br> ".
                Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
                  ->area_id)->nombre."</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>A</b></td>
              <td><b>:".Trabajador::find($memorandum->trabajadores()->find(Input::get('trabajador_id'))->trabajador_id)->persona->nombre." ".
              Trabajador::find($memorandum->trabajadores()->find(Input::get('trabajador_id'))
                ->trabajador_id)->persona->apellidos."</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>ASUNTO</b></td>
              <td><b>:".$memorandum->asunto."</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>FECHA</b></td>
              <td><b>:".$memorandum->fecha."</b></td>
            </tr>
          </table><hr>
          <p width=300>".$memorandum->contenido."
          </p>
          <p align='center'>Atentamente,</p><br><br><br><br><br><p align='center'>
          ___________________________<br>".
          Usuario::find($memorandum->remite)->persona->nombre."<br>".
          Usuario::find($memorandum->remite)->persona->apellidos."<br>".
          Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
            ->area_id)->nombre."</p>
        </body>
      </html>
      ";

    $html = str_replace("&ndash;", "-", $html);

    define('BUDGETS_DIR', public_path('documentos/memorandums/'.$empresa->ruc));

    if (!is_dir(BUDGETS_DIR)){
        mkdir(BUDGETS_DIR, 0755, true);
    }

    $nombre = $memorandum->numero;
    $ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

    $pdf = PDF::loadHtml($html);
    $pdf->setPaper('a4')->save($ruta);

    $mensaje = "EL MEMORANDUM SE EDITO PERFECTAMENTE. AHORA PUEDE IMPRIMIRLO.";
    return Redirect::to('memorandum/mostrar/'.$memorandum->id)->with('verde', $mensaje);
  }

  public function putEditarMultiple($id){
    set_time_limit(300);

    $memorandum = Memorandum::find($id);
    $remite = Usuario::find(Input::get('remite'));
    $empresa = $memorandum->empresa;
    $usuario = Usuario::find(Auth::user()->id);
    $area = Area::find($remite->empresas()->find($empresa->ruc)->area_id);

    $codigo = 'MEMORANDUM MULTIPLE Nº '.$memorandum->numero.'-'.date('Y', strtotime($memorandum->redaccion))
      .'/'.$area->abreviatura.'/'.$empresa->nombre;

    $trabajadores = [];

    if (Input::get('todos') != null) {
      foreach ($empresa->trabajadores as $trabajador) {
        array_push($trabajadores, $trabajador);
      }
    }elseif (Input::get('cliente') != null) {
      $cliente = Cliente::find(Input::get('cliente'));
      $contratos = $cliente->contratos;
      foreach ($contratos as $contrato) {
        foreach ($contrato->puntos as $punto) {
          foreach ($punto->trabajadores as $trabajador) {
            if (count($trabajadores) != 0) {
              foreach ($trabajadores as $key) {
                if ($trabajador->id != $key->id) {
                  array_push($trabajadores, $trabajador);
                }else{
                  break;
                }
              }
            }else{
              array_push($trabajadores, $trabajador);
            }
          }
        }
      }
    }

    foreach ($empresa->trabajadores as $trabajador) {
      if(Input::get('trabajador'.$trabajador->persona_dni) == $trabajador->persona_dni){
        foreach ($trabajadores as $key) {
          if ($trabajador->id != $key->id) {
            array_push($trabajadores, $trabajador);
            break;
          }else{
            break;
          }
        }
      }
    }

    if (count($trabajadores) == 0) {
      $mensaje = "DEBE SELECCIONAR AL MENOS UN TRABAJADOR PARA, EMITIR UN MEMORANDUM";
      return Redirect::to('memorandum/editar-multiple/'.$memorandum->id)->with('rojo', $mensaje);
    }

    $memorandum->trabajadores()->detach();

    $memorandum->usuario_id = Auth::user()->id;
    $memorandum->remite = $remite->id;
    $memorandum->area_id = $area->id;
    $memorandum->asunto = mb_strtoupper(Input::get('asunto'));
    $memorandum->tipo_memorandum_id = Input::get('razon');
    $memorandum->codigo = $codigo;
    $memorandum->fecha = mb_strtoupper(Input::get('fecha'));
    $memorandum->contenido = Input::get('contenido');
    $memorandum->save();

    foreach($trabajadores as $trabajador){
      $trabajador->memorandums()->attach($memorandum->id);
    }

    $html = "
      <!DOCTYPE html>
      <html>
        <head>
          <meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>
          <meta http-equiv='X-UA-Compatible' content='IE=edge'>
          <title>".$memorandum->codigo."</title>
          <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
            name='viewport'>
        </head>
        <body>
          <style type='text/css'>
            .titulo{
              font-size: 14pt;
              font-family: monospace;
              text-decoration: underline;
            }
            .borde{
             border: 1px solid #000;
             padding-left: 10px;
             margin-left: 30%;
            }
            .cuerpo{
              font-size: 12pt;
              font-family: monospace;
            }
          </style>
          <img src='documentos/membretes/".$memorandum->empresa_ruc.".jpg' width=100%>
          <h1 class='titulo' align='left'>".$memorandum->codigo."</h1><br>
          <table>
            <tr valign=top>
              <td width=100 height=50><b>DE</b></td>
              <td><b>:".Usuario::find($memorandum->remite)->persona->nombre." ".
                Usuario::find($memorandum->remite)->persona->apellidos."<br> ".
                Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
                  ->area_id)->nombre."</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>A</b></td>
              <td><b>:MEMORANDUM MULTIPLE</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>ASUNTO</b></td>
              <td><b>:".$memorandum->asunto."</b></td>
            </tr>
            <tr valign=top>
              <td height=30><b>FECHA</b></td>
              <td><b>:".$memorandum->fecha."</b></td>
            </tr>
          </table><hr>
          <p width=300>".$memorandum->contenido."
          </p>
          <p align='center'>Atentamente,</p><br><br><br><br><br><p align='center'>
          ___________________________<br>".
          Usuario::find($memorandum->remite)->persona->nombre."<br>".
          Usuario::find($memorandum->remite)->persona->apellidos."<br>".
          Area::find(Empresa::find($memorandum->empresa_ruc)->usuarios()->find($memorandum->remite)
            ->area_id)->nombre."</p>
        </body>
      </html>
      ";

    $html = str_replace("&ndash;", "-", $html);

    define('BUDGETS_DIR', public_path('documentos/memorandums/'.$empresa->ruc));

    $nombre = $memorandum->numero;
    $ruta = BUDGETS_DIR.'/'.$nombre.'.pdf';

    $pdf = PDF::loadHtml($html);
    $pdf->setPaper('a4')->save($ruta);

    $mensaje = "EL MEMORANDUM SE EDITO PERFECTAMENTE. AHORA PUEDE IMPRIMIRLO.";
    return Redirect::to('memorandum/mostrar/'.$memorandum->id)->with('verde', $mensaje);
  }

  public function deleteBorrar($id){
    set_time_limit(300);

    $memorandum = Memorandum::find($id);
    $ruc = $memorandum->empresa_ruc;
    if(Hash::check(Input::get('password'), Auth::user()->password)){
      File::delete('documentos/memorandums/'.$memorandum->empresa_ruc.'/'.$memorandum->numero.
        '.pdf');
      $memorandum->delete();

      $mensaje = "EL MEMORANDUM FUE ELIMINADO CORRECTAMENTE.";
      return Redirect::to('memorandum/inicio/'.$ruc)->with('naranja', $mensaje);
    }else{
      $mensaje = "LA CONTRASEÑA ES INCORRECTA, INTENTE NUEVAMENTE.";
      return Redirect::to('memorandum/inicio/'.$memorandum->empresa_ruc)->with('rojo', $mensaje);
    }
  }
}
