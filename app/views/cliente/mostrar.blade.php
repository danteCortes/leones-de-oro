@extends('plantilla')

@section('titulo')
Cliente | Mostrar
@stop

@section('contenido')
<?php
  function moneda($moneda){
    $aux = explode('.', $moneda);
    if (count($aux) > 1) {
      if (strlen($aux[1]) == 1) {
        $moneda = $moneda."0";
      }
    }else{
      $moneda = $moneda.".00";
    }
    return $moneda;
  }
?>
<section class="content-header">
    <h1>
      Cliente
      <small>mostrar</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="#">Cliente</a></li>
      <li class="active">Mostrar</li>
    </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-9">
      <div class="box">
        <div class="box-header">
            <h3 class="box-title">Datos del Cliente</h3>
        </div>
        <div class="box-body no-padding">
            <table class="table table-striped">
              <tr>
                  <th>RUC</th>
                  <td>{{$cliente->ruc}}</td>
              </tr>
              <tr>
                  <th>Razón Social</th>
                  <td>{{$cliente->nombre}}</td>
              </tr>
              <tr>
                  <th>Dirección</th>
                  <td>{{$cliente->direccion}}</td>
              </tr>
              <tr>
                  <th>Teléfono</th>
                  <td>{{$cliente->telefono}}</td>
              </tr>
              <tr>
                  <th>Contacto</th>
                  <td>{{$cliente->contacto}}</td>
              </tr>
            </table>
        </div>
      </div>
    </div>
  </div>
  @if(count($cliente->contratos) != 0)
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
              <h3 class="box-title">Contratos</h3>
          </div>
          <div class="box-body no-padding">
              <table class="table table-striped">
                <tr>
                  <th>INICIO</th>
                  <th>FIN</th>
                  <th>TOTAL</th>
                  <th>MOSTRAR</th>
                </tr>
                @foreach($cliente->contratos as $contrato)
                <tr>
                  <td>{{date('d-m-Y', strtotime($contrato->inicio))}}</td>
                  <td>{{date('d-m-Y', strtotime($contrato->fin))}}</td>
                  <td>S/. {{moneda($contrato->total)}}</td>
                  <td><a href="<?=URL::to('contrato/mostrar/'.$contrato->id)?>" class="btn btn-warning btn-xs">Mostrar</a>
                  </td>
                </tr>
                @endforeach
              </table>
          </div>
        </div>
        @foreach($cliente->empresas as $empresa)
          <a href="<?=URL::to('cliente/inicio/'.$empresa->ruc)?>" class="btn btn-primary">Volver a {{$empresa->nombre}}</a><br>
        @endforeach
      </div>
    </div>
  @endif
</section>
@stop