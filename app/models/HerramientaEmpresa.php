<?php

class HerramientaEmpresa extends Eloquent{
  
  protected $table = 'empresa_herramienta';

  public $timestamps = false;

  public function trabajadores(){
  	return $this->belongsToMany('Trabajador', 'empresa_herramienta_trabajador', 
  		'empresa_herramienta_id', 'trabajador_id');
  }

  public function herramienta(){
  	return $this->belongsTo('Herramienta');
  }
}