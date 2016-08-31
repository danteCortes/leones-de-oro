<?php

class Empresa extends Eloquent{

	protected $table = 'empresas';

	public $primaryKey = 'ruc';

	public $incrementing = false;
	
	public $timestamps = false;
}