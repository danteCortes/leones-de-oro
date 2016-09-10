<?php

class Documento extends Eloquent{

	public $timestamps = false;

	public function trabajadores(){
		return $this->belongsToMany('Trabajador', 'documento_trabajador', 'documento_id'
			,'trabajador_id')->withPivot('nombre');
	}
}