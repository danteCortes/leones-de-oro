<?php

class Retencion extends Eloquent{

	protected $table = 'retenciones';

	public $timestamps = false;

	public function contrato(){
		return $this->belongsToOne('Contrato');
	}
}