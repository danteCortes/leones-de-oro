<?php

class Concepto extends Eloquent{

  public $timestamps = false;

  public function turnos(){
    return $this->belongsToMany('Turno')->withPivot('sueldobasico', 'asignacionfamiliar', 
      'jornadanocturna', 'sobretiempo1', 'sobretiempo2', 'descancero', 'feriados',
      'asignfamiliar', 'gratificaciones', 'cts', 'vacaciones', 'essalud', 'sctr', 'ueas',
      'capacitacion', 'movilidad', 'refrigerio', 'gastosgenerale', 'utilidad', 'total');
  }
}