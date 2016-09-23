<?php

class Area extends Eloquent{

	public $timestamps = false;

	public function usuarios(){
		return $this->belongsToMany('Usuario', 'area_empresa_usuario', 'area_id', 'usuario_id')
			->withPivot('empresa_ruc');
	}

	public function empresas(){
		return $this->belongsToMany('Empresa', 'area_empresa_usuario', 'area_id', 'empresa_ruc')
			->withPivot('usuario_id');
	}
}