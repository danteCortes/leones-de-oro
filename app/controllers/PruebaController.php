<?php

class PruebaController extends BaseController{
	
	
	public function getInicio($personal_id) {
		$personal = Trabajador::find($personal_id);
		return View::make('prueba')->with('personal', $personal);
    // $location = GeoIP::getLocation('232.223.11.5');
    // return $location;
  }
}