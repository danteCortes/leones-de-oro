<?php

class Trabajador extends Eloquent{

	protected $table = 'trabajadores';

	public $timestamps = false;

	public function empresa(){
		return $this->belongsTo('Empresa', 'empresa_ruc');
	}

	public function persona(){
		return $this->belongsTo('Persona', 'persona_dni');
	}

	public function documentos(){
		return $this->belongsToMany('Documento', 'documento_trabajador',
			'trabajador_id', 'documento_id');
	}
}