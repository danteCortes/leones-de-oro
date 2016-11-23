<?php

class Punto extends Eloquent{

  public $timestamps = false;

  public function contrato(){
    return $this->belongsTo('Contrato');
  }
}