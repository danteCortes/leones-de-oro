<?php

class ReciboController extends BaseController{

  public function getInicio($ruc){
    $empresa = Empresa::find($ruc);
    return View::make('recibo.inicio')->with('empresa', $empresa);
  }
}