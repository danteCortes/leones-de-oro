<?php

class Costo extends Eloquent{

  public $timestamps = false;

  public function conceptos(){
    return $this->hasMany('Concepto');
  }
}