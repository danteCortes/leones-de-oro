<?php

class Cliente extends Eloquent{

	public $primaryKey = 'ruc';

	public $incrementing = false;
	
	public $timestamps = false;

	public function empresas(){
		return $this->belongsToMany('Empresa', 'cliente_empresa', 'cliente_ruc', 'empresa_ruc');
	}

	public function trabajadores(){
		return $this->belongsToMany('Trabajador', 'cliente_trabajador', 'cliente_ruc', 'trabajador_id')
			->withPivot('cargo_id', 'unidad');
	}

	public function cargos(){
		return $this->belongsToMany('Cargo', 'cliente_trabajador', 'cliente_ruc', 'cargo_id')
			->withPivot('trabajador_id', 'unidad');
	}
}