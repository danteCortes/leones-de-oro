<?php

class Contrato extends Eloquent{

	public $timestamps = false;

	public function empresa(){
		return $this->belongsTo('Empresa', 'empresa_ruc');
	}

	public function cliente(){
		return $this->belongsTo('Cliente', 'cliente_ruc');
	}

	public function documentos(){
		return $this->belongsToMany('Documento', 'contrato_documento',
			'contrato_id', 'documento_id')->withPivot('nombre');
	}
}