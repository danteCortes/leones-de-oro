<?php

class TrabajadorController extends BaseController{

  public function getInicio($ruc){

    $empresa = Empresa::find($ruc);
    $trabajadores = $empresa->trabajadores;
    return View::make('trabajador.inicio')->with('trabajadores', $trabajadores)
      ->with('empresa', $empresa);
  }

  public function postContratar(){
    $persona = Persona::find(Input::get('dni'));
    if ($persona) {

      $trabajador = $persona->trabajador;
      if ($trabajador) {
        $empresa = $trabajador->empresa;
        $mensaje = "EL TRABAJADOR ESTA CONTRATADO EN LA EMPRESA ".$empresa->nombre.
          ". ELIMINELO DE ESA EMPRESA PARA CONTRATARLO EN ESTA EMPRESA.";
        return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
          ->with('rojo', $mensaje);
      }else{
        $trabajador = $this->guardarTrabajador($persona->dni, Input::get('empresa'),
          Input::get('inicio'), Input::get('fin'), Input::get('cuenta'),
          Input::get('banco'), Input::get('cci'));

        if ($this->guardarFoto(Input::file('foto'), $trabajador->id)) {
          
          if ($this->guardarDocumento(Input::file('contrato'), $trabajador->id, 8)) {
        
            $mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO.";
            return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
              ->with('verde', $mensaje);
          }else{

            $mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE INGRESAR SU 
              CONTRATO.";
            return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
              ->with('naranja', $mensaje);
          }
        }else{

          if ($this->guardarDocumento(Input::file('contrato'), $trabajador->id, 8)) {
        
            $mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE ACTUALIZAR SU
              FOTO.";
            return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
              ->with('naranja', $mensaje);
          }else{

            $mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE ACTUALIZAR SU
              FOTO E INGRESAR SU CONTRATO.";
            return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
              ->with('naranja', $mensaje);
          }
        }
      }
    }else{

      $persona = $this->guardarPersona(Input::get('dni'), Input::get('nombre'),
        Input::get('apellidos'), Input::get('direccion'), Input::get('telefono'));

      $trabajador = $this->guardarTrabajador($persona->dni, Input::get('empresa'),
        $this->formatoFecha(Input::get('inicio')), $this->formatoFecha(Input::get('fin')),
        Input::get('cuenta'), Input::get('banco'), Input::get('cci'));

      if ($this->guardarFoto(Input::file('foto'), $trabajador->id)) {
          
        if ($this->guardarDocumento(Input::file('contrato'), $trabajador->id, 8)) {
      
          $mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO.";
          return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
            ->with('verde', $mensaje);
        }else{

          $mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE INGRESAR SU 
            CONTRATO.";
          return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
            ->with('naranja', $mensaje);
        }
      }else{

        if ($this->guardarDocumento(Input::file('contrato'), $trabajador->id, 8)) {
      
          $mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE ACTUALIZAR SU
            FOTO.";
          return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
            ->with('naranja', $mensaje);
        }else{

          $mensaje = "EL TRABAJADOR FUE CONTRATADO CON EXITO, PERO DEBE ACTUALIZAR SU
            FOTO E INGRESAR SU CONTRATO.";
          return Redirect::to('trabajador/inicio/'.Input::get('empresa'))
            ->with('naranja', $mensaje);
        }
      }
    }
  }

  public function getVer($id){
    $trabajador = Trabajador::find($id);
    $empresa = $trabajador->empresa;
    $clientes = $empresa->clientes;
    return View::make('trabajador.mostrar')->with('trabajador', $trabajador)
      ->with('empresa', $empresa)->with('clientes', $clientes);
  }

  public function postDocumentar(){

    if ($this->guardarDocumento(Input::file('archivo'), Input::get('trabajador_id')
      ,Input::get('documento_id'))) {
      
      $mensaje = "EL ARCHIVO FUE GUARDADO CON EXITO.";
      return Redirect::to('trabajador/ver/'.Input::get('trabajador_id'))
        ->with('verde', $mensaje);
    }else{

      $mensaje = "HUBO UN ERROR AL GUARDAR EL ARCHIVO. EL FORMATO DEL ARCHIVO DEBE SER .pdf 
      INTENTE NUEVAMENTE.";
      return Redirect::to('trabajador/ver/'.Input::get('trabajador_id'))
        ->with('rojo', $mensaje);
    }
  }

  public function getEditar($id){

    $trabajador = Trabajador::find($id);
    return View::make('trabajador.editar')->with('trabajador', $trabajador);
  }

  public function putEditar($id){

    $trabajador = Trabajador::find($id);
    $persona = $trabajador->persona;
    if ($this->actualizarPersona($persona->dni, Input::get('dni'), Input::get('nombre'),
      Input::get('apellidos'), Input::get('direccion'), Input::get('telefono'))) {

      $this->actualizarTrabajador($id, $this->formatoFecha(Input::get('inicio')),
        $this->formatoFecha(Input::get('fin')), Input::get('cuenta'), Input::get('banco')
        , Input::get('cci'));
      
      $mensaje = "LOS DATOS DEL TRABAJADOR SE ACTUALIZARON CON EXITO.";
      return Redirect::to('trabajador/inicio/'.$trabajador->empresa->ruc)->with('verde', $mensaje);
    }else{

      $mensaje = "EL DNI YA ESTA SIENDO USADO POR OTRO TRABAJADOR, CORRIJA EL ERROR E INTENTE NUEVAMENTE.";
      return Redirect::to('trabajador/inicio/'.$trabajador->empresa->ruc)->with('rojo', $mensaje);
    }
  }

  public function putFoto($id){

    if ($this->guardarFoto(Input::file('foto'), $id)) {
      
      $mensaje = "LA FOTO FUE ACTUALIZADA CON EXITO.";
      return Redirect::to("trabajador/editar/".$id)->with('verde', $mensaje);
    }else{

      $mensaje = "LA FOTO DEBE TENER EXTENCION .jpg, INTENTELO NUEVAMENTE.";
      return Redirect::to("trabajador/editar/".$id)->with('rojo', $mensaje);
    }
  }

  public function deleteBorrar($id){

    $trabajador = Trabajador::find($id);
    $empresa = $trabajador->empresa;
    $persona = $trabajador->persona;
    $documentos = $trabajador->documentos;
    if (Hash::check(Input::get('password'), Auth::user()->password)) {
      
      foreach ($documentos as $documento) {

        File::delete('documentos/documentos/'.$documento->pivot->nombre);
      }
      if ($trabajador->foto != 'usuario.jpg') {
        File::delete('documentos/fotos/'.$trabajador->foto);
      }

      $persona->delete();

      $mensaje = "EL TRABAJADOR FUE BORRADO JUNTO A TODOS SUS DOCUMENTOS.";
      return Redirect::to('trabajador/inicio/'.$empresa->ruc)->with('naranja', $mensaje);
    }else{

      $mensaje = "LA CONTRASEÑA INGRESADA ES INCORRECTA. VUELVA A INTENTARLO..";
      return Redirect::to('trabajador/inicio/'.$empresa->ruc)->with('rojo', $mensaje);
    }
  }

  public function postBuscarRuc(){
    $nombre = Input::get('nombre');
    $trabajador = Trabajador::find(Input::get('trabajador_id'));
    $empresa = $trabajador->empresa;
    $clientes = $empresa->clientes;
    foreach ($clientes as $cliente) {
      if ($cliente->nombre == $nombre) {
        $contratos = Contrato::where('cliente_ruc', '=', $cliente->ruc)
          ->where('empresa_ruc', '=', $empresa->ruc)->get();
        foreach ($contratos as $contrato) {
          if (strtotime($contrato->fin) > strtotime(date('Y-m-d'))) {
            return $contrato->puntos;
          }
        }
      }
    }
    return 0;
  }

  //funcion para guardar un cargo de un trabajador en un cliente en la tabla pivote
  //cliente_trabajador.
  public function postCargo(){
    $trabajador = Trabajador::find(Input::get('trabajador_id'));
    $empresa = $trabajador->empresa;
    $clientes = $empresa->clientes;
    $cliente = [];
    $punto = [];
    //Buscamos al cliente mediante el nombre que nos envia el formulario.
    foreach($clientes as $cli){
      if ($cli->nombre == Input::get('cliente')) {
        $cliente = $cli;
      }
    }
    //Verificamos si existe el cliente
    if ($cliente) {
      //Si el cliente existe buscamos sus contratos vigentes.
      foreach ($cliente->contratos as $contrato) {
        if (strtotime($contrato->fin) > strtotime(date('Y-m-d'))) {
          //Si el contrato está vigente buscamos sus puntos de trabajo.
          foreach ($contrato->puntos as $p) {
            //comprobamos si algun punto coincide con el que mandamos por el formulario.
            if ($p->id == Input::get('punto')) {
              $punto = $p;
              break;
            }
          }
        }
      }
      //verificamos si existe un punto de trabajo
      if ($punto) {
        //Si existe el punto de trabajo, verificamos si el trabajador ya esta relacionado
        //con este punto.
        if ($punto->trabajadores->find(Input::get('trabajador_id'))) {
          //Si el trabajador ya esta relacionado con el punto de trabajo, actualizamos los
          //datos del registro
          $punto->trabajadores()->updateExistingPivot(Input::get('trabajador_id'), 
            array('cargo_id'=>Input::get('cargo')));
        }else{
          //si no esta relacionado, creamos un nuevo registro en la tabla punto_trabajador
          //con los datos correspondientes.
          $punto->trabajadores()->attach(Input::get('trabajador_id'), array('cargo_id'=>
            Input::get('cargo')));
        }
        //Si el punto no existe regresamos a la vista de ver trabajador con un mensaje 
        //informando el error.
        $mensaje = "EL PUNTO DE TRABAJO FUE AGREGADO CORRECTAMENTE AL TRABAJADOR.";
        return Redirect::to('trabajador/ver/'.Input::get('trabajador_id'))->with('verde', $mensaje);
      }else{
        //Si el punto no existe regresamos a la vista de ver trabajador con un mensaje 
        //informando el error.
        $mensaje = "HUBO UN ERROR CON EL PUNTO DE TRABAJO, VUELVA A INTENTARLO";
        return Redirect::to('trabajador/ver/'.Input::get('trabajador_id'))->with('rojo', $mensaje);
      }
    }else{
      //Si el cliente no existe regresamos a la vista de ver trabajador con un mensaje 
      //informando el error.
      $mensaje = "HUBO UN ERROR CON EL CLIENTE, VUELVA A INTENTARLO";
      return Redirect::to('trabajador/ver/'.Input::get('trabajador_id'))->with('rojo', $mensaje);
    }
  }

  //funcion para borrar el cargo de un trabajador en un lugar de trabajo (cliente)
  public function deleteCargo($id){
    //primero verificamos si la contraseña ingresada pertence al usuario logueado.
    if(Hash::check(Input::get('password'), Auth::user()->password)){
      //si es correcto hallamos al trabajador mediante el hidden trabajador_id.
      $trabajador = Trabajador::find(Input::get('trabajador_id'));
      //Hallamos el cargo del trabajador en la tabla pivote cliente_trabajador.
      $punto = $trabajador->puntos()->find($id);
      //borramos el registro de la tabla pivote cliente_trabajador con el metodo detach pasandole
      //como argumento un arreglo clave=>valor.
      $trabajador->puntos()->detach($punto->punto_id);
      //Regresamos a la vista de mostrar trabajador con el mensaje de cargo borrado.
      $mensaje = "EL CARGO DEL TRABAJADOR FUE BORRADO.";
        return Redirect::to('trabajador/ver/'.Input::get('trabajador_id'))
          ->with('naranja', $mensaje);
    }else{
      //Si la contraseña es incorrecta regresamos a la vista de mostrar trabajador con
      //el mensaje respectivo.
      $mensaje = "NO SE BORRO EL CARGO DEL TRABAJADOR. LA CONTRASEÑA QUE INTRODUJO ES INCORRECTO,
      VUELVA A INTENTARLO.";
      return Redirect::to('trabajador/ver/'.Input::get('trabajador_id'))->with('rojo', $mensaje);
    }
  }

  public function getCodigo($id){
    $trabajador = Trabajador::find($id);
    return View::make('trabajador.codigo')->with('trabajador', $trabajador);
  }

  private function guardarPersona($dni, $nombre, $apellidos, $direccion, $telefono){

    $persona = new Persona;
    $persona->dni = $dni;
    $persona->nombre = mb_strtoupper($nombre);
    $persona->apellidos = mb_strtoupper($apellidos);
    $persona->direccion = mb_strtoupper($direccion);
    $persona->telefono = mb_strtoupper($telefono);
    $persona->save();

    return Persona::find($dni);
  }

  private function guardarTrabajador($persona_dni, $empresa_ruc, $inicio, $fin, $cuenta, $banco, 
    $cci){

    $trabajador = new Trabajador;
    $trabajador->persona_dni = $persona_dni;
    $trabajador->empresa_ruc = $empresa_ruc;
    $trabajador->inicio = $inicio;
    $trabajador->fin = $fin;
    $trabajador->cuenta = mb_strtoupper($cuenta);
    $trabajador->banco = mb_strtoupper($banco);
    $trabajador->cci = $cci;
    $trabajador->foto = "usuario.jpg";
    $trabajador->save();

    return Trabajador::find($trabajador->id);
  }

  private function guardarFoto($foto, $trabajador_id){

    if ($foto) {
      
      $extencion = explode('.', trim($foto->getClientOriginalName()));
      $extencion = $extencion[count($extencion)-1];

      if ($extencion == 'jpg' || $extencion == 'JPG') {
        
        $foto->move("documentos/fotos", $trabajador_id.".".$extencion);

        $trabajador = Trabajador::find($trabajador_id);
        $trabajador->foto = $trabajador_id.".".$extencion;
        $trabajador->save();
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  private function guardarDocumento($archivo, $trabajador_id, $documento_id){

    if ($archivo) {
      
      $extencion = explode('.', trim($archivo->getClientOriginalName()));
      $extencion = $extencion[count($extencion)-1];

      if ($extencion == 'pdf' || $extencion == 'PDF') {

        $documento = Documento::find($documento_id);
        
        $archivo->move("documentos/documentos", $trabajador_id.$documento->nombre."."
          .$extencion);

        $trabajador = Trabajador::find($trabajador_id);
        if (!$trabajador->documentos()->find($documento_id)) {
          
          $trabajador->documentos()->attach($documento_id, array('nombre'=>$trabajador->id
            .$documento->nombre.'.'.$extencion));
        }
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  private function formatoFecha($fecha){

    return substr($fecha, 6, 4)."-".substr($fecha, 3, 2)."-".substr($fecha, 0, 2);
  }

  private function actualizarPersona($id, $dni, $nombre, $apellidos, $direccion, $telefono){

    if ($id == $dni) {
      
      $persona = Persona::find($id);
      $persona->dni = $dni;
      $persona->nombre = mb_strtoupper($nombre);
      $persona->apellidos = mb_strtoupper($apellidos);
      $persona->direccion = mb_strtoupper($direccion);
      $persona->telefono = mb_strtoupper($telefono);
      $persona->save();

      return true;
    }else{

      $persona = Persona::find($dni);
      if ($persona) {
        
        return false;
      }else{

        $persona = Persona::find($id);
        $persona->dni = $dni;
        $persona->nombre = mb_strtoupper($nombre);
        $persona->apellidos = mb_strtoupper($apellidos);
        $persona->direccion = mb_strtoupper($direccion);
        $persona->telefono = mb_strtoupper($telefono);
        $persona->save();

        return true;
      }
    }
  }

  private function actualizarTrabajador($id, $inicio, $fin, $cuenta, $banco, $cci){

    $trabajador = Trabajador::find($id);
    $trabajador->inicio = $inicio;
    $trabajador->fin = $fin;
    $trabajador->cuenta = mb_strtoupper($cuenta);
    $trabajador->banco = mb_strtoupper($banco);
    $trabajador->cci = $cci;
    $trabajador->save();

    return Trabajador::find($trabajador->id);
  }
}