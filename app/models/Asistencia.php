<?php

class Asistencia extends Eloquent{

  public $timestamps = false;

  public function cliente(){
    return $this->belongsTo('Cliente', 'cliente_ruc', 'id');
  }
}