<?php

class UsuarioController extends BaseController{

  public function __construct(){

        $this->beforeFilter('auth', array('except' => 'postLoguearse'));
    }

  public function postLoguearse(){
    
    $password = Input::get('password');
    $dni = Input::get('dni');
    $recordarme = Input::get('recordarme');
    if (Auth::attempt(array('persona_dni'=>$dni, 'password'=>$password), 1)) {
      return Redirect::intended('usuario/panel');
    }else{
      $mensaje = "EL DNI O CONTRASEÑA SON ERRONEOS, INTENTE DE NUEVO.";
      return Redirect::to('/')->with('rojo', $mensaje);
    }
  }

  public function getPanel(){
    return View::make('inicio.panel');
  }

  public function getSalir(){
    Auth::logout();
    $mensaje = "CERRO SESION SATISFACTORIAMENTE, PUEDE CERRAR EL SISTEMA.";
    return Redirect::to('/')->with('verde', $mensaje);
  }

  public function getContrasenia(){
    if(Auth::user()->nivel == 0){

      return View::make('usuario.contrasenia');
    }else{
      $mensaje = "USTED NO ESTA AUTORIZADO PARA EJECUTAR ESTA ACCIÓN. CONSULTE 
        CON EL ADMINISTRADOR DEL SISTEMA";
      return Redirect::to('usuario/panel')->with('rojo', $mensaje);
    }
  }

  public function postContrasenia(){
    if (Hash::check(Input::get('actual'), Auth::user()->password)) {
      if(Input::get('nueva') == Input::get('confirmar')){
        $usuario = Usuario::find(Auth::user()->id);
        $usuario->password = Hash::make(Input::get('nueva'));
        $usuario->save();
        Auth::logout();
        $mensaje = "SU CONTRASEÑA FUE CAMBIADA CON EXITO. INICIE SESION CON SU NUEVA CONTRASEÑA.";
        return Redirect::to('/')->with('verde', $mensaje);
      }else{
        $mensaje = "LAS NUEVAS CONTRASEÑAS NO COINCIDEN, PRUEBE DE NUEVO.";
        return Redirect::to('usuario/contrasenia')->with('rojo', $mensaje);
      }
    }else{
      $mensaje = "LA CONTRASEÑA ACTUAL ES INCORRECTA, PRUEBE DE NUEVO.";
      return Redirect::to('usuario/contrasenia')->with('rojo', $mensaje);
    }
  }

  public function getInicio(){
    $usuarios = Usuario::all();
    return View::make('usuario.inicio')->with('usuarios', $usuarios);
  }

  public function postNuevo(){
    //verificamos que el dni no pertenesca a una persona ya registrada.
    $persona = Persona::find(Input::get('dni'));
    if($persona){
      //Si la persona ya existe verificamos si ya es usuario.
      $usuario = $persona->usuario;
      if($usuario){
        //si ya es usuario regresamos a la vista de inicio usuario con el mensaje correspondiente.
        $mensaje = "EL USUARIO QUE INTENTA REGISTRAR YA EXISTE.";
        return Redirect::to('usuario/inicio')->with('rojo', $mensaje);
      }else{
        //Si el usuario no existe guardamos sus datos como usuario.
        $this->guardarUsuario($persona->dni, Input::get('nivel'));
        $mensaje = "EL USUARIO FUE GUARDADO CON EXITO.";
        return Redirect::to('usuario/inicio')->with('verde', $mensaje);
      }
    }else{
      //Si la persona no existe, guardamos sus datos en la tabla personas y usuarios.
      $persona = $this->guardarPersona(Input::get('dni'), strtoupper(Input::get('nombre')), 
        strtoupper(Input::get('apellidos')), strtoupper(Input::get('direccion')),
        Input::get('telefono'));
      $this->guardarUsuario($persona->dni, Input::get('nivel'));
      $mensaje = "EL USUARIO FUE GUARDADO CON EXITO.";
      return Redirect::to('usuario/inicio')->with('verde', $mensaje);
    }
  }

  public function putEditar($id){
    //Seleccionamos al usuario que se va a editar.
    $usuario = Usuario::find($id);
    $persona = $usuario->persona;
    //Verificamos si esta cambiando de DNI.
    if($persona->dni == Input::get('dni')){
      //si el dni es igual con el que se ingreso es la misma persona.
      //actualizamos los datos de la persona.
      $persona = $this->actualizarPersona($persona->dni, Input::get('dni'), strtoupper(Input::get('nombre')),
        strtoupper(Input::get('apellidos')), strtoupper(Input::get('direccion')),
        Input::get('telefono'));
      $this->actualizarUsuario($id, $persona->dni, Input::get('nivel'));
      $mensaje = "EL USUARIO FUE ACTUALIZADO CON EXITO.";
      return Redirect::to('usuario/inicio')->with('naranja', $mensaje);
    }else{
      //Si el dni ingresado por el formulario es diferente con el que ya tenia el usuario
      //hay que verificar si no pertenece a otra persona.
      $registro = Persona::find(Input::get('dni'));
      if($registro){
        //Si el registro existe es por que el dni ingresado por el formulario le pertenece a 
        //otra persona. Regresamos a la vista de usuarios con el mensaje correspondiente.
        $mensaje = "EL DNI QUE INTENTA INGRESAR AL USUARIO YA EXISTE EN OTRA PERSONA.";
        return Redirect::to('usuario/inicio')->with('rojo', $mensaje);
      }else{
        //Si el registro no existe es por que el DNI ingresado por el formulario esta disponible 
        //para guardarlo con el usuario. Actualizamos los datos de la persona y usuario.
        $persona = $this->actualizarPersona($persona->dni, Input::get('dni'), strtoupper(Input::get('nombre')),
          strtoupper(Input::get('apellidos')), strtoupper(Input::get('direccion')),
          Input::get('telefono'));
        $this->actualizarUsuario($id, $persona->dni, Input::get('nivel'));
        $mensaje = "EL USUARIO FUE ACTUALIZADO CON EXITO.";
        return Redirect::to('usuario/inicio')->with('naranja', $mensaje);
      }
    }
  }

  public function deleteBorrar($id){
    //Verificamo si el password es correcto
    if(Hash::check(Input::get('password'), Auth::user()->password)){
      //Verficamos si el usuario a borrar no es el mismo que esta logueado.
      if(Auth::user()->id != $id){
        //Si no es un usuario logueado lo borramos.
        $usuario = Usuario::find($id);
        $usuario->delete();
        $mensaje = "EL USUARIO FUE BORRADO CON EXITO.";
        return Redirect::to('usuario/inicio')->with('naranja', $mensaje);
      }else{
        //Si es el mismo regresamos a la vista anterior con el mensaje correspondiente.
        $mensaje = "USTED NO PUEDE BORRARSE A SI MISMO DEL SISTEMA.";
        return Redirect::to('usuario/inicio')->with('rojo', $mensaje);
      }
    }else{
      $mensaje = "EL PASSWORD INGRESADO ES INCORRECTO.";
      return Redirect::to('usuario/inicio')->with('rojo', $mensaje);
    }
  }

  public function getMostrar($id){
    $usuario = Usuario::find($id);
    return View::make('usuario.mostrar')->with('usuario', $usuario);
  }

  public function postArea($id){
    $usuario = Usuario::find($id);
    $area = Area::find(Input::get('area_id'));
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    if($usuario->empresas()->find($empresa->ruc)){
      $usuario->empresas()->updateExistingPivot($empresa->ruc, array('area_id'=>$area->id));
    }else{
      $usuario->empresas()->attach($empresa->ruc, array('area_id'=>$area->id));
    }
    $mensaje = "SE AGREGO EL AREA AL USUARIO CORRECTAMENTE.";
    return Redirect::to('usuario/mostrar/'.$usuario->id)->with('verde', $mensaje);
  }

  public function deleteArea($id){
    if(Hash::check(Input::get('password'), Auth::user()->password)){
      Usuario::find(Input::get('usuario_id'))->empresas()->detach(Input::get('empresa_ruc'));
      $mensaje = "EL CARGO DEL USUARIO FUE ELIMINADO.";
      return Redirect::to('usuario/mostrar/'.Input::get('usuario_id'))->with('naranja', $mensaje);
    }else{
      $mensaje = "EL PASSWORD INGRESADO ES INCORRECTO, PRUEBE NUEVAMENTE.";
      return Redirect::to('usuario/mostrar/'.Input::get('usuario_id'))->with('rojo', $mensaje);
    }
  }

  private function guardarUsuario($persona_dni, $nivel){
    $usuario = new Usuario;
    $usuario->persona_dni = $persona_dni;
    $usuario->password = Hash::make($persona_dni);
    $usuario->nivel = $nivel;
    $usuario->save();
    return Usuario::find($usuario->id);
  }

  private function guardarPersona($dni, $nombre, $apellidos, $direccion, $telefono){
    $persona = new Persona;
    $persona->dni = $dni;
    $persona->nombre = $nombre;
    $persona->apellidos = $apellidos;
    $persona->direccion = $direccion;
    $persona->telefono = $telefono;
    $persona->save();
    return Persona::find($dni);
  }

  private function actualizarPersona($id, $dni, $nombre, $apellidos, $direccion, $telefono){
    $persona = Persona::find($id);
    $persona->dni = $dni;
    $persona->nombre = $nombre;
    $persona->apellidos = $apellidos;
    $persona->direccion = $direccion;
    $persona->telefono = $telefono;
    $persona->save();
    return Persona::find($persona->dni);
  }

  private function actualizarUsuario($id, $persona_dni, $nivel){
    $usuario = Usuario::find($id);
    $usuario->nivel = $nivel;
    $usuario->save();
    return Usuario::find($id);
  }
}