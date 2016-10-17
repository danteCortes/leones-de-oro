@extends('plantilla')

@section('titulo')
Estructura de Costos | Nuevo
@stop

@section('estilos')
<link rel="stylesheet" type="text/css" href="<?=URL::to('plugins/jQueryUI/jquery-ui.css')?>">
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Estructura de Costos
    <small>Nuevo</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Estructura de Costos</a></li>
    <li class="active">Nuevo</li>
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
          <h3 class="box-title">Nueva Estructura de Costos
            <small>Redactar</small>
          </h3><br>
        </div>
        {{Form::open(array('url'=>'carta/nuevo', 'class'=>'form-horizontal', 
          'method'=>'post'))}}
          <div class="box-body">
            <div class="form-group">
              {{Form::label(null, 'RUC*:', array('class'=>'control-label col-xs-1'))}}
              <div class="col-xs-5">
                {{Form::text('ruc','' , array('class'=>'form-control input-sm ruc'
                  ,'placeholder'=>'RUC', 'required'=>'', 'id'=>'ruc'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'CLIENTE*:', array('class'=>'control-label col-xs-1'))}}
              <div class="col-xs-5">
                {{Form::text('cliente','' , array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'CLIENTE', 'required'=>'', 'id'=>'nombre'))}}
              </div>
              {{Form::label(null, 'DIRECCIÓN*:', array('class'=>'control-label col-xs-1'))}}
              <div class="col-xs-5">
                {{Form::text('direccion','' , array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'DIRECCIÓN', 'required'=>'', 'id'=>'direccion', 'readonly'=>''))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'LUGAR*:', array('class'=>'control-label col-xs-1'))}}
              <div class="col-xs-5">
                {{Form::text('lugar','' , array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'LUGAR', 'required'=>''))}}
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="form-group">
              <div class="col-xs-12">
                <textarea id="saludo" name="saludo" rows="3" cols="80" placeholder="Contenido..." required="">
                  Saludo...
                </textarea>
              </div>
            </div>
          </div>
          <div class="box-body">
            {{Form::button('Agregar Concepto', array('class'=>'btn btn-success'))}}
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Cant.</th>
                    <th>Descripción</th>
                    <th>Prec. Uni.</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2</td>
                    <td>SERVICIO DE SEGURIDAD Y VIGILANCIA PARA LA INTENDENCIA REGIONAL DE HUANUCO<br>
                      SERVICIO DE 24 HORAS DE LUNES A DOMINGO INCLUIDO FERIADOS</td>
                    <td>7304.00</td>
                    <td>14608.00</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="box-body">
            <div class="form-group">
              <div class="col-xs-12">
                <textarea id="despedida" name="despedida" rows="3" cols="80" placeholder="Contenido..." required="">
                  Despedida...
                </textarea>
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'Fecha*:', array('class'=>'col-sm-1 control-label'))}}
              <div class="col-xs-5">
                {{Form::text('lugar', null, array('class'=>'form-control input-sm',
                  'placeholder'=>'FECHA', 'required'=>''))}}
              </div>
            </div>
          </div>
          <div class="box-body">
            {{Form::button('Guardar', array('class'=>'btn btn-primary', 'type'=>'submit', 
              'id'=>'guardar'))}}
            <a href="<?=URL::to('costo/inicio/'.$empresa->ruc)?>"
              class="btn btn-warning pull-right">Atras</a>
          </div>
          {{Form::hidden('empresa_ruc', $empresa->ruc, array('id'=>'empresa_ruc'))}}
        {{Form::close()}}
      </div>
    </div>
  </div>
</section>
@stop

@section('scripts')
<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js" type="text/javascript"></script>
<script src="<?=URL::to('plugins/jQueryUI/jquery-ui.min.js')?>" type="text/javascript"></script>
<script>
  $(function(){
    var rucs = new Array();
    var nombres = new Array();
    var direcciones = new Array();
    @foreach($clientes as $cliente)
      rucs.push('{{$cliente->ruc}}');
      nombres.push('{{$cliente->nombre}}');
      direcciones.push('{{$cliente->direccion}}');
    @endforeach
    $("#ruc").autocomplete({ //Usamos el ID de la caja de texto donde lo queremos
      source: rucs //Le decimos que nuestra fuente es el arreglo
    });
    $("#nombre").autocomplete({ //Usamos el ID de la caja de texto donde lo queremos
      source: nombres //Le decimos que nuestra fuente es el arreglo
    });
    $("#direccion").autocomplete({ //Usamos el ID de la caja de texto donde lo queremos
      source: direcciones //Le decimos que nuestra fuente es el arreglo
    });
    $("#ruc").focusout(function() {
      if(!$("#ruc").attr('readonly')){
        $.ajax({
          url: "<?=URL::to('costo/buscar-ruc')?>",
          type: 'POST',
          data: {ruc: $("#ruc").val(), empresa_ruc: $("#empresa_ruc").val()},
          dataType: 'JSON',
          beforeSend: function() {
            $("#nombre").val('Buscando Cliente...');
            $("#direccion").val('Buscando Cliente...');
          },
          error: function() {
            $("#nombre").val('Ha surgido un error.');
            $("#direccion").val('Ha surgido un error.');
          },
          success: function(respuesta) {
            if (respuesta) {
              $("#nombre").val(respuesta['nombre']);
              $("#direccion").val(respuesta['direccion']);
              $("#nombre").attr('readonly', true);
            } else {
              $("#nombre").attr('readonly', false);
              $("#nombre").val('No se encontro ningun cliente con ese ruc.');
              $("#direccion").val('No se encontro ningun cliente con ese ruc.');
              $("#ruc").val('00000000000');
            }
          }
        });
      }
    });
    $("#nombre").focusout(function() {
      if(!$("#nombre").attr('readonly')){
        $.ajax({
          url: "<?=URL::to('costo/buscar-nombre')?>",
          type: 'POST',
          data: {nombre: $("#nombre").val(), empresa_ruc: $("#empresa_ruc").val()},
          dataType: 'JSON',
          beforeSend: function() {
            $("#ruc").val('Buscando Cliente...');
            $("#direccion").val('Buscando Cliente...');
          },
          error: function() {
            $("#ruc").val('Ha surgido un error.');
            $("#direccion").val('Ha surgido un error.');
          },
          success: function(respuesta) {
            if (respuesta) {
              $("#ruc").val(respuesta['ruc']);
              $("#direccion").val(respuesta['direccion']);
              $("#ruc").attr('readonly', true);
            } else {
              $("#ruc").attr('readonly', false);
              $("#ruc").val('00000000000');
              $("#direccion").val('No se encontro ningun cliente con ese nombre.');
              $("#nombre").val('No se encontro ningun cliente con ese nombre.');
            }
          }
        });
      }
    });

    CKEDITOR.replace('saludo');

    CKEDITOR.replace('despedida');
  });
</script>
@stop