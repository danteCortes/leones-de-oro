<?php

class Cliente extends Eloquent{

	public $primaryKey = 'ruc';

	public $incrementing = false;
	
	public $timestamps = false;

	public function empresas(){
		return $this->belongsToMany('Empresa', 'cliente_empresa', 'cliente_ruc', 'empresa_ruc');
	}
}