<?php

class ClienteTrabajador extends Eloquent{

  public $table = 'cliente_trabajador';
  
  public $timestamps = false;

  public function asistencias(){
    return $this->belongsToMany('Asistencia', 'asistencia_cliente_trabajador', 'cliente_trabajador_id', 'asistencia_id');
  }
}