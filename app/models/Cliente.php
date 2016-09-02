<?php

class Cliente extends Eloquent{

	public $primaryKey = 'ruc';

	public $incrementing = false;
	
	public $timestamps = false;
}