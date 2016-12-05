<?php

class Descuento extends Eloquent{

	public $timestamps = false;

	public function trabajadores(){
		return $this->belongsToMany('Trabajador', 'descuento_trabajador', 'descuento_id'
			,'trabajador_id')->withPivot('nombre');
	}
}