@extends('plantilla')

@section('titulo')
Pago | Reporte
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Pago
    <small>Reporte</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Pago</a></li>
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
              <input type="text" class="form-control input-sm" data-inputmask="'alias': 'mm/yyyy'" 
              data-mask placeholder="MES" id="fecha">
            </div>
          </div>
        </div>
        <div class="box-footer">
          {{Form::open(array('url'=>'pago/pdf', 'method'=>'get', 'class'=>'pull-right',
            'target'=>'_blank'))}}
            <button type="submit" class="btn btn-primary" style="margin-right: 5px;" id="pdf"
              target="_blank">
              <i class="fa fa-download"></i> Descargar PDF <i class="fa fa-file-pdf-o"></i>
            </button>
            {{Form::hidden('fecha', null, array('class'=>'fecha'))}}
            {{Form::hidden('cliente_id', null, array('class'=>'cliente_id'))}}
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

    $("#pdf").click(function(){
      if ($(".fecha").val() == "") {
        return false;
      };
    });
  });
</script>
@stop