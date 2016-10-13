<?php

class Informe extends Eloquent{

  public $timestamps = false;

  public function usuario(){
    return $this->belongsTo('Usuario');
  }

  public function empresa(){
    return $this->belongsTo('Empresa', 'empresa_ruc');
  }

  public function remitente(){
    return $this->belongsTo('Usuario', 'remite');
  }

  public function area(){
    return $this->belongsTo('Area');
  }
}