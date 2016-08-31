<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class Usuario extends Eloquent implements UserInterface{

	use UserTrait;

	public $timestamps = false;

	public function persona(){
		return $this->belongsTo('Persona', 'persona_dni');
	}

	public function empresa(){
		return $this->belongsTo('Empresa', 'empresa_ruc');
	}
}