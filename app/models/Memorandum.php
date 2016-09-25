<?php

class Memorandum extends Eloquent{

	public $timestamp = false;

	public function usuario(){
		return $this->belongsTo('Usuario');
	}
}