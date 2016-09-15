<?php

class Empresa extends Eloquent{

	protected $table = 'empresas';

	public $primaryKey = 'ruc';

	public $incrementing = false;
	
	public $timestamps = false;

	public function trabajadores(){
		return $this->hasMany('Trabajador', 'empresa_ruc');
	}

	public function clientes(){
		return $this->belongsToMany('Cliente', 'cliente_empresa', 'empresa_ruc', 'cliente_ruc');
	}

	public function contratos(){
		return $this->hasMany('Contrato', 'empresa_ruc');
	}
}