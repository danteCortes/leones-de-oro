<?php

class Trabajador extends Eloquent{

  protected $table = 'trabajadores';

  public $timestamps = false;

  public function empresa(){
    return $this->belongsTo('Empresa', 'empresa_ruc');
  }

  public function persona(){
    return $this->belongsTo('Persona', 'persona_dni');
  }

  public function documentos(){
    return $this->belongsToMany('Documento', 'documento_trabajador',
      'trabajador_id', 'documento_id')->withPivot('nombre');
  }

  public function memorandums(){
    return $this->belongsToMany('Memorandum');
  }

  public function asistencias(){
    return $this->belongsToMany('Asistencia', 'asistencia_trabajador', 'trabajador_id', 'asistencia_id')
    ->withPivot('entrada', 'salida');
  }

  public function puntos(){
    return $this->belongsToMany('Punto', 'punto_trabajador', 'trabajador_id', 'punto_id')
      ->withPivot('cargo_id');
  }
}