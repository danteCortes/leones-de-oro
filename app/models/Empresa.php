<?php

class Empresa extends Eloquent{

	protected $table = 'empresas';

	public $primaryKey = 'ruc';

	public $incrementing = false;
	
	public $timestamps = false;

	public function trabajadores(){
		return $this->hasMany('Trabajador', 'empresa_ruc');
	}
}