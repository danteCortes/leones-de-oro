@extends('plantilla')

@section('titulo')
Asistencia | Reporte
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Asistencia
    <small>Reporte</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Asistencia</a></li>
    <li class="active">Reporte</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Escoja Mes</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            <label>Mes y año</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control" data-inputmask="'alias': 'mm/yyyy'" 
              data-mask placeholder="MES" id="fecha">
            </div>
          </div>
        </div>
        <div class="box-footer">
          {{Form::open(array('url'=>'asistencia/excel', 'method'=>'get', 'class'=>'pull-left'))}}
            <button type="submit" class="btn btn-success" style="margin-right: 5px;" id="excel">
              <i class="fa fa-download"></i> Descargar EXCEL <i class="fa fa-file-excel-o"></i>
            </button>
            {{Form::hidden('fecha', null, array('class'=>'fecha'))}}
            {{Form::hidden('empresa_ruc', $empresa->ruc)}}
          {{Form::close()}}
          {{Form::open(array('url'=>'asistencia/pdf', 'method'=>'get', 'class'=>'pull-right'))}}
            <button type="submit" class="btn btn-primary" style="margin-right: 5px;" id="pdf">
              <i class="fa fa-download"></i> Descargar PDF <i class="fa fa-file-pdf-o"></i>
            </button>
            {{Form::hidden('fecha', null, array('class'=>'fecha'))}}
            {{Form::hidden('empresa_ruc', $empresa->ruc)}}
          {{Form::close()}}
        </div>
      </div>
    </div>
  </div>
</section>
@stop

@section('scripts')
<script>
  $(function () {
    //fecha mm/yyyy
    $("[data-mask]").inputmask();

    $("#fecha").blur(function(){
      $(".fecha").val($("#fecha").val());
    });
  });
</script>
@stop