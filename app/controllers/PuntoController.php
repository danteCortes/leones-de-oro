<?php

class PuntoController extends \BaseController {

  public function index(){}

  public function create(){}

  public function store(){
    //separamos la latitud y la longitud de coordenadas.
    $latitud = explode(',', Input::get('coordenadas'))[0];
    $longitud = explode(',', Input::get('coordenadas'))[1];
    $punto = new Punto;
    $punto->contrato_id = Input::get('contrato_id');
    $punto->nombre = mb_strtoupper(Input::get('nombre'));
    $punto->latitud = $latitud;
    $punto->longitud = $longitud;
    $punto->save();

    return Redirect::to('contrato/mostrar/'.Input::get('contrato_id'));
  }

  public function show($id){}

  public function edit($id){}

  public function update($id){}

  public function destroy($id){
    //Primero verificamos que el password ingresado pertenece al usuario logueado.
    if (Hash::check(Input::get('password'), Auth::user()->password)) {
      //si el password es correcto seleccionamos el punto.
      $punto = Punto::find($id);
      //Luego seleccionamos el contrato a la que pertenece el punto para regresar
      //a su vista de puntos.
      $contrato = $punto->contrato;
      //Borramos el punto de la tabla puntos
      $punto->delete();
      //Regresamos a la vista de puntos de la empresa con el mensaje respectivo.
      $mensaje = "EL PUNTO FUE BORRADO JUNTO A TODOS SUS DOCUMENTOS.";
      return Redirect::to('contrato/mostrar/'.$contrato->id)->with('naranja', $mensaje);
    }else{
      $punto = Punto::find($id);
      $contrato = $punto->contrato;
      //Si el password no es correcto, regresamos a la vista de mostrar contrato 
      //con el mensaje respectivo.
      $mensaje = "LA CONTRASEÑA INGRESADA ES INCORRECTA. VUELVA A INTENTARLO..";
      return Redirect::to('contrato/mostrar/'.$contrato->id)->with('rojo', $mensaje);
    }
  }

}
