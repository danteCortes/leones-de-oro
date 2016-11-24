<?php

class Punto extends Eloquent{

  public $timestamps = false;

  public function contrato(){
    return $this->belongsTo('Contrato');
  }

  public function trabajadores(){
    return $this->belongsToMany('Trabajador', 'punto_trabajador', 'punto_id', 'trabajador_id')
      ->withPivot('cargo_id');
  }
}