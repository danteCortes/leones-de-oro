s<?php

class EmpresaController extends \BaseController {

  public function index(){
    
    $empresas = Empresa::all();
    return View::make('empresa.inicio')->with('empresas', $empresas);
  }

  public function store(){
    
    $empresa = new Empresa;
    $empresa->ruc = Input::get('ruc');
    $empresa->nombre = mb_strtoupper(Input::get('nombre'));
    $empresa->save();

    $mensaje = "LA EMPRESA FUE CREADA CON EXITO.";
    return Redirect::to('empresa')->with('verde', $mensaje);
  }

  public function update($id){

    $empresa = Empresa::find($id);
    $empresa->ruc = Input::get('ruc');
    $empresa->nombre = mb_strtoupper(Input::get('nombre'));
    $empresa->save();

    $mensaje = "SE MODIFICO LOS DATOS DE LA EMPRESA SATISFACTORIAMENTE.";
    return Redirect::to('empresa')->with('naranja', $mensaje);
  }

  public function destroy($id){

    if (Hash::check(Input::get('password'), Auth::user()->password)) {
      if (Auth::user()->empresa_ruc != $id) {
        $empresa = Empresa::find($id);
        $empresa->delete();

        $mensaje = "LA EMPRESA FUE ELIMINADOA SIN PROBLEMAS.";
        return Redirect::to('empresa')->with('naranja', $mensaje);
      }else{
        $mensaje = "ESTA EMPRESA NO SE PUEDE ELIMINAR, DEBIDO A QUE USTED ESTA ASOCIADO A ESTA EMPRESA.
          LE RECOMENDAMOS CAMBIARSE DE EMPRESA ANTES DE ELIMINARLO.";
        return Redirect::to('empresa')->with('rojo', $mensaje);
      }
    }else{
      $mensaje = "SU CONTRASEÑA ES ERRONEA, INTENTE NUEVAMENTE.";
      return Redirect::to('empresa')->with('rojo', $mensaje);
    }
  }
}
