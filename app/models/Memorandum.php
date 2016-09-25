<?php

class Memorandum extends Eloquent{

	public $timestamps = false;

	public function usuario(){
		return $this->belongsTo('Usuario');
	}
}