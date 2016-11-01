@extends('plantilla')

@section('titulo')
Estructura de Costos | Ver
@stop

@section('estilos')
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Estructura de Costos
    <small>mostrar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Estructura de Costos</a></li>
    <li class="active">Mostrar</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      @if(Session::has('rojo'))
        <div class="alert alert-danger alert-dismissable">
          <i class="fa fa-info"></i>
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <b>Alerta!</b> {{ Session::get('rojo')}}
        </div>
      @elseif(Session::has('verde'))
        <div class="alert alert-success alert-dismissable">
          <i class="fa fa-info"></i>
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <b>Excelente!</b> {{ Session::get('verde')}}
        </div>
      @elseif(Session::has('naranja'))
        <div class="alert alert-warning alert-dismissable">
          <i class="fa fa-info"></i>
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <b>Cuidado!</b> {{ Session::get('naranja')}}
        </div>
      @endif
    </div>
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">ESTRUCTURA DE COSTOS Nº {{$costo->id}}</h3>
        </div>
        <div class="box-body no-padding">
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item"
              src="<?=URL::to('documentos/costos/'.$costo->empresa_ruc.'/'
              .$costo->id.'.pdf')?>">
            </iframe>
          </div>
        </div>
        <div class="box-footer">
          <a href="<?=URL::to('costo/inicio/'.$costo->empresa_ruc)?>" class="btn btn-primary">
            Volver a Estructuras de Costos
          </a>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">CONCEPTOS DETALLADOS</h3>
        </div>
        	@foreach($costo->conceptos as $concepto)
        <div class="box-body">
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item"
              src="<?=URL::to('documentos/costos/'.$costo->empresa_ruc.'/detalles/'
              .$concepto->id.'.pdf')?>">
            </iframe>
          </div>
        </div>
          @endforeach
      </div>
    </div>
  </div>
</section>
@stop

@section('scripts')
@stop