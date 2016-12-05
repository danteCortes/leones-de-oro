<?php

class DescuentoTrabajador extends Eloquent{

	protected $table = 'descuento_trabajador';

	public $timestamps = false;

	public function descuento(){
		return $this->belongsTo('Descuento');
	}
}