<?php

class CostoController extends BaseController{
  
  public function getInicio($ruc){
    $empresa = Empresa::find($ruc);
    if($empresa){
      $clientes = Cliente::all();
      $costos = Costo::where('empresa_ruc', '=', $ruc)->get();
      return View::make('costo.inicio')->with('costos', $costos)
        ->with('empresa', $empresa);
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function getNuevo($ruc){
    $empresa = Empresa::find($ruc);
    if($empresa){
      $clientes = $empresa->clientes()->get();
      $costo = new Costo;
      return View::make('costo.nuevo')->with('empresa', $empresa)->with('costo', $costo)
        ->with('clientes', $clientes);
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function postGuardarConcepto(){
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $costo = $empresa->costos()->where('estado', '=', 1)->first();
    if(count($costo) == 0){
      // $costo = $this->nuevoCosto(Input::get('empresa_ruc'), '', '', '', 0, 0, 0, '', '', 1);

      // $concepto = $this->nuevoConcepto($costo->id, Input::get('nombre'), 
      //   Input::get('diurno')+Input::get('nocturno'), 0, 0, 0);

      if (Input::get('asignacionfamiliar')) {
        $asignacionfamiliar = Input::get('rmv') * 0.1;
        return $asignacionfamiliar;
      }else{
        return 0;
      }
    }else{
      // $concepto = $this->nuevoConcepto($costo->id, Input::get('nombre'), 
      //   Input::get('diurno')+Input::get('nocturno'), 0, 0, 0);

      return 1;
    }
  }

  private function nuevoCosto($empresa_ruc, $cliente, $lugar, $saludo, $subtotal, $igv, $total,
    $despedida, $fecha, $estado){

    $costo = new Costo;
    $costo->empresa_ruc = $empresa_ruc;
    $costo->cliente = $cliente;
    $costo->lugar = $lugar;
    $costo->saludo = $saludo;
    $costo->subtotal = $subtotal;
    $costo->igv = $igv;
    $costo->total = $total;
    $costo->despedida = $despedida;
    $costo->fecha = $fecha;
    $costo->estado = $estado;
    $costo->save();

    return Costo::find($costo->id);
  }

  private function nuevoConcepto($costo_id, $nombre, $numero, $subtotal, $igv, $total){
    $concepto = new Concepto;
    $concepto->costo_id = $costo_id;
    $concepto->nombre = mb_strtoupper($nombre);
    $concepto->numero = $numero;
    $concepto->subtotal = $subtotal;
    $concepto->igv = $igv;
    $concepto->total = $total;
    $concepto->save();

    return Concepto::find($concepto->id);
  }

  // private function nuevoConceptoTurno($turno_id, $concepto_id, $puestos, $sueldobasico, 
  //   $asignacionfamiliar, $jornadanocturna, $sobretiempo, $descancero, $feriados,
  //   $gratificaciones, $cts, $vacaciones, $essalud, $sctr, $ueas, $capacitacion, $movilidad, 
  //   $refigerio, $gastosgenerales, $utilidad){
  //   if($asignacionfamiliar){
  //     $asignacionfamiliar = $sueldobasico*0.1;
  //   }
  //   if($jornadanocturna){
  //     $jornadanocturna = $sueldobasico*0.35;
  //   }
  //   if($sobretiempo){
  //     if ($sobretiempo > 0 && $sobretiempo <=2) {
  //       $sobretiempo1 = sueldobasico + asignacionfamiliar
  //     }
  //   }
  //   Concepto::find($concepto_id)->turnos()->attach($turno_id, array('puestos'=>$puestos, 
  //     'sueldobasico'=>$sueldobasico, 'asignacionfamiliar'=>$asignacionfamiliar, 'jornadanocturna'
  //     =>$jornadanocturna, 'sobretiempo1'=>$sobretiempo1, 'sobretiempo2'=>$sobretiempo2, 'descancero'
  //     =>$descancero, 'feriados'=>$feriados, 'gratificaciones'=>$gratificaciones, 'cts'=>$cts,
  //     'vacaciones'=>$vacaciones, 'essalud'=>$essalud, 'sctr'=>$sctr, 'ueas'=>$ueas, 'capacitacion'=>
  //     $capacitacion, 'movilidad'=>$movilidad, 'refirgerio'=>$refirgerio, 'gastosgenerales'=>
  //     $gastosgenerales, 'utilidad'=>$utilidad, 'puestos'=>$puestos, ));
  // }
}