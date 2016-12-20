<?php

class BonificacionTrabajador extends Eloquent{

  protected $table = 'bonificacion_trabajador';

  public $timestamps = false;

  public function bonificacion(){
    return $this->belongsTo('Bonificacion');
  }
}