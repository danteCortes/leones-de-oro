<?php

class Asistencia extends Eloquent{

  public $timestamps = false;

  public function trabajadores(){
    return $this->belongsToMany('Trabajador')->withPivot('entrada', 'salida');
  }
}