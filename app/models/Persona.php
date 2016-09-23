<?php

class Persona extends Eloquent{

	public $primaryKey = 'dni';

	public $increments = false;

	public $timestamps = false;

	public function usuario(){
		return $this->hasOne('Usuario', 'persona_dni');
	}

	public function trabajador(){
		return $this->hasOne('Trabajador', 'persona_dni');
	}
}