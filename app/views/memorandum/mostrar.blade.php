@extends('plantilla')

@section('titulo')
Memorandum | Ver
@stop

@section('estilos')
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Memorandum
    <small>mostrar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Memorandum</a></li>
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
          <h3 class="box-title">{{$memorandum->codigo}}</h3>
        </div>
        <div class="box-body no-padding">
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item"
              src="<?=URL::to('documentos/memorandums/'.$memorandum->empresa_ruc.'/'
              .$memorandum->numero.'.pdf')?>">
            </iframe>
          </div>
        </div>
        <div class="box-footer">
          <a href="<?=URL::to('memorandum/inicio/'.$memorandum->empresa_ruc)?>" class="btn btn-primary">
            Ver Memorandums
          </a>
          @if(Auth::user()->nivel == 0)
            @if(count($memorandum->trabajadores) == 1)
              @foreach($memorandum->trabajadores as $trabajador)
              <a href="<?=URL::to('trabajador/ver/'.$trabajador->id)?>" class="btn btn-warning">
                Ver Trabajador
              </a>
              @endforeach
            @endif
          @endif
        </div>
      </div>
      </div>
    </div>
</section>
@stop

@section('scripts')
@stop