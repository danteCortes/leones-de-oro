@extends('plantilla')

@section('titulo')
Carta | Editar
@stop

@section('estilos')
<link rel="stylesheet" type="text/css" href="<?=URL::to('plugins/jQueryUI/jquery-ui.css')?>">
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Carta
    <small>Editar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Carta</a></li>
    <li class="active">Editar</li>
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
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">CARTA Nº {{$carta->numero}}-{{date('Y', strtotime($carta->redaccion))}}/
            {{$carta->empresa->nombre}}
            <small>Editar</small>
          </h3><br>
          <h3 class="box-title">{{$carta->anio}}
          </h3>
        </div>
        {{Form::open(array('url'=>'carta/editar/'.$carta->id, 'class'=>'form-horizontal', 
          'method'=>'put', 'id'=>'formulario'))}}
          <div class="box-body">
            <div class="form-group">
              {{Form::label(null, 'SEÑORES*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('destinatario', $carta->destinatario, array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'DESTINATARIO', 'required'=>''))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'LUGAR*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('lugar', $carta->lugar, array('class'=>'form-control input-sm'
                  ,'placeholder'=>'LUGAR', 'required'=>''))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'ASUNTO:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('asunto', $carta->asunto, array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'ASUNTO', 'id'=>'asunto'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'REFERENCIA:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('referencia', $carta->referencia, array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'REFERENCIA', 'id'=>'referencia'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'FECHA*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('fecha', $carta->fecha, array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'FECHA', 'required'=>'', 'id'=>'fecha'))}}
              </div>
            </div>
          </div>
          <div class="box-body">
              <div class="form-group">
                <div class="col-xs-12">
                  <textarea id="contenido" name="contenido" rows="10" cols="80" placeholder="Contenido..." required="">
                      {{$carta->contenido}}
                  </textarea>
                </div>
              </div>
              {{Form::hidden('empresa_ruc', $carta->empresa->ruc, array('id'=>'empresa_ruc'))}}
              {{Form::button('Guardar', array('class'=>'btn btn-primary', 'type'=>'submit', 
                'id'=>'guardar'))}}
              <a href="<?=URL::to('carta/inicio/'.$carta->empresa_ruc)?>"
                class="btn btn-warning pull-right">Atras</a>
          </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
</section>
@stop

@section('scripts')
<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script>

<script src="<?=URL::to('plugins/jQueryUI/jquery-ui.min.js')?>" type="text/javascript"></script>

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('contenido');

    $("#formulario").submit(function(){
      if($("#asunto").val() == "" && $("#referencia").val() == ""){
        $("#asunto").focus();
        return false;
      }
    });

  });
</script>
@stop