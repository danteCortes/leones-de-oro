<?php

class Asistencia extends Eloquent{

  public $timestamps = false;

  public function trabajadores(){
    return $this->belongsToMany('Trabajador')->withPivot('entrada', 'salida');
  }

  public function punto(){
  	return $this->belongsTo('Punto');
  }

  public function turno(){
  	return $this->belongsTo('Turno');
  }
}