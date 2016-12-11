<?php

class Herramienta extends Eloquent{

  public $timestamps = false;

  public function empresas(){
  	return $this->belongsToMany('Empresa', 'empresa_herramienta', 'herramienta_id', 'empresa_ruc')
  		->withPivot('serie', 'marca', 'modelo', 'descripcion');
  }
}