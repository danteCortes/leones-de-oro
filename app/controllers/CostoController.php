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
      $costo = $empresa->costos()->where('estado', '=', 1)->first();
      if ($costo) {
        return View::make('costo.nuevo')->with('empresa', $empresa)->with('costo', $costo)
          ->with('clientes', $clientes);
      }else{
        $costo = new Costo;
        return View::make('costo.nuevo')->with('empresa', $empresa)->with('costo', $costo)
          ->with('clientes', $clientes);
      }
    }else{
      return Redirect::to('usuario/panel');
    }
  }

  public function postGuardarConcepto(){
    $empresa = Empresa::find(Input::get('empresa_ruc'));
    $costo = $empresa->costos()->where('estado', '=', 1)->first();

    if(count($costo) == 0){
      $costo = $this->nuevoCosto(Input::get('empresa_ruc'), '', '', '', 0, 0, 0, '', '', 1);
    }

    $concepto = $this->nuevoConcepto($costo->id, Input::get('nombre'), 
      0, 0, 0, 0);
    
    $this->nuevoConceptoTurno(1, $concepto->id, Input::get('diurno'), Input::get('rmv'), 
      Input::get('asignacionfamiliar'), 0, Input::get('txt_st'),
      Input::get('descansero'), Input::get('feriados'), Input::get('gratificaciones'),
      Input::get('cts'), Input::get('vacaciones'), Input::get('essalud'), Input::get('txt_sctr'),
      Input::get('ueas'), Input::get('capacitacion'), Input::get('movilidad'), Input::get('refrigerio'),
      Input::get('gastosgenerales'), Input::get('utilidad'), Input::get('txt_igv'));

    $this->nuevoConceptoTurno(2, $concepto->id, Input::get('nocturno'), Input::get('rmv'), 
      Input::get('asignacionfamiliar'), Input::get('jornadanocturna'), Input::get('txt_st'),
      Input::get('descansero'), Input::get('feriados'), Input::get('gratificaciones'),
      Input::get('cts'), Input::get('vacaciones'), Input::get('essalud'), Input::get('txt_sctr'),
      Input::get('ueas'), Input::get('capacitacion'), Input::get('movilidad'), Input::get('refrigerio'),
      Input::get('gastosgenerales'), Input::get('utilidad'), Input::get('txt_igv'));

    foreach ($concepto->turnos as $turno) {
      $concepto = $this->actualizarConcepto($concepto->id, $turno->pivot->puestos, $turno->pivot->subtotal,
        $turno->pivot->igv, $turno->pivot->total);
    }

    $costo = $this->actualizarCosto($costo->id, $concepto->subtotal, $concepto->igv, $concepto->total);

    return $concepto;
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

  private function nuevoConceptoTurno($turno_id, $concepto_id, $puestos, $sueldobasico, 
    $asignacionfamiliar, $jornadanocturna, $sobretiempo, $descansero, $feriados,
    $gratificaciones, $cts, $vacaciones, $essalud, $sctr, $ueas, $capacitacion, $movilidad, 
    $refrigerio, $gastosgenerales, $utilidad, $igv){

    if ($asignacionfamiliar) {
      $asignacionfamiliar = $sueldobasico*0.1;
    }else{
      $asignacionfamiliar = 0;
    }

    if ($jornadanocturna) {
      $jornadanocturna = $sueldobasico*0.35;
    }else{
      $jornadanocturna = 0;
    }

    if ($sobretiempo) {
      if ($sobretiempo > 0 && $sobretiempo <=2) {
        $sobretiempo1 = round(((((($sueldobasico + $asignacionfamiliar)*1.25)/30)/8)*26)*$sobretiempo*100)/100;
        $sobretiempo2 = 0;
      }elseif ($sobretiempo >2 && $sobretiempo <=4) {
        $sobretiempo1 = round(((((($sueldobasico + $asignacionfamiliar)*1.25)/30)/8)*26)*2*100)/100;
        $sobretiempo2 = round(((((($sueldobasico + $asignacionfamiliar)*1.35)/30)/8)*26)*($sobretiempo-2)*100)/100;;
      }
    }else{
      $sobretiempo1 = 0;
      $sobretiempo2 = 0;
    }

    $subtotal = $sueldobasico+$asignacionfamiliar+$jornadanocturna+$sobretiempo1+$sobretiempo2;

    if($descansero){
      $descansero = round($subtotal*100/6)/100;
    }else{
      $descansero = 0;
    }

    if($feriados){
      $feriados = round((($subtotal+(round(($subtotal-$jornadanocturna)*100/6)/100)-$jornadanocturna)/30)*100)/100;
    }else{
      $feriados = 0;
    }

    $remuneraciones = $descansero + $feriados + $subtotal;

    if($gratificaciones){
      $gratificaciones = round((2*($subtotal-$asignacionfamiliar)+$descansero+(2*$feriados))/12*100)/100;
    }else{
      $gratificaciones = 0;
    }

    if($cts){
      $cts = round(($remuneraciones + $gratificaciones)*0.0833*100)/100;
    }else{
      $cts = 0;
    }

    if($vacaciones){
      $vacaciones = round($remuneraciones*0.0833*100)/100;
    }else{
      $vacaciones = 0;
    }

    $beneficiossociales = $gratificaciones+$cts+$vacaciones;

    if($essalud){
      $essalud = round(($remuneraciones+$gratificaciones+$vacaciones)*0.09*100)/100;
    }else{
      $essalud = 0;
    }

    if($sctr){
      $sctr = round(($remuneraciones+$gratificaciones+$vacaciones)*$sctr)/100;
    }else{
      $sctr = 0;
    }

    $contribucionessociales = $essalud + $sctr;
    $manodeobra = $remuneraciones + $beneficiossociales + $contribucionessociales;

    if(!$ueas){
      $ueas = 0;
    }

    if(!$capacitacion){
      $capacitacion = 0;
    }
    $implementos = $ueas + $capacitacion;

    if(!$movilidad){
      $movilidad = 0;
    }

    if(!$refrigerio){
      $refrigerio = 0;
    }

    $movilidad_refrigerio = $movilidad + $refrigerio;
    $total12horas = $manodeobra + $implementos + $movilidad_refrigerio;

    if(!$gastosgenerales){
      $gastosgenerales = 0;
    }

    if(!$utilidad){
      $utilidad = 0;
    }

    $gastosgenerales_utilidad = $gastosgenerales + $utilidad;
    $subtotalconcepto = $total12horas + $gastosgenerales_utilidad;

    if($igv){
      $igv = round($subtotalconcepto*$igv)/100;
    }else{
      $igv = 0;
    }
    
    $total = $subtotalconcepto + $igv;

    Concepto::find($concepto_id)->turnos()->attach($turno_id, array('puestos'=>$puestos, 
      'sueldobasico'=>$sueldobasico, 'asignacionfamiliar'=>$asignacionfamiliar, 'jornadanocturna'
      =>$jornadanocturna, 'sobretiempo1'=>$sobretiempo1, 'sobretiempo2'=>$sobretiempo2, 'descansero'
      =>$descansero, 'feriados'=>$feriados, 'gratificaciones'=>$gratificaciones, 'cts'=>$cts,
      'vacaciones'=>$vacaciones, 'essalud'=>$essalud, 'sctr'=>$sctr, 'ueas'=>$ueas, 'capacitacion'=>
      $capacitacion, 'movilidad'=>$movilidad, 'refrigerio'=>$refrigerio, 'gastosgenerale'=>
      $gastosgenerales, 'utilidad'=>$utilidad, 'subtotal'=>$subtotalconcepto, 'igv'=>$igv,
      'total'=>$total));
  }

  private function actualizarConcepto($id, $numero, $subtotal, $igv, $total){
    $concepto = Concepto::find($id);
    $concepto->numero += $numero;
    $concepto->subtotal += $subtotal;
    $concepto->igv += $igv;
    $concepto->total += $total;
    $concepto->save();

    return Concepto::find($id);
  }

  private function actualizarCosto($id, $subtotal, $igv, $total){

    $costo = Costo::find($id);
    $costo->subtotal += $subtotal;
    $costo->igv += $igv;
    $costo->total += $total;
    $costo->save();

    return Costo::find($id);
  }
}