<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class Usuario extends Eloquent implements UserInterface{

	use UserTrait;

	public $timestamps = false;

	public function persona(){
		return $this->belongsTo('Persona', 'persona_dni');
	}

	public function empresas(){
		return $this->belongsToMany('Empresa', 'area_empresa_usuario', 'usuario_id', 'empresa_ruc')
			->withPivot('area_id');
	}

	public function areas(){
		return $this->belongsToMany('Area', 'area_empresa_usuario', 'usuario_id', 'area_id')
			->withPivot('empresa_ruc');
	}
}