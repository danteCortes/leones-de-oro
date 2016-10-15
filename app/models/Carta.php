<?php

class Carta extends Eloquent{
  
  public $timestamps = false;

  public function usuario(){
    return $this->belongsTo('Usuario');
  }

  public function empresa(){
    return $this->belongsTo('Empresa', 'empresa_ruc');
  }
}