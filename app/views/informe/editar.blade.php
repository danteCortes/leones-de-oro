@extends('plantilla')

@section('titulo')
Informe | Editar
@stop

@section('estilos')
<link rel="stylesheet" type="text/css" href="<?=URL::to('plugins/jQueryUI/jquery-ui.css')?>">
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Informe
    <small>Editar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Informe</a></li>
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
          <h3 class="box-title">INFORME Nº {{$informe->numero}}-{{date('Y', strtotime($informe->redaccion))}}/
            <label id="codigo">{{$informe->area->abreviatura}}</label>/{{$informe->empresa->nombre}}
            <small>Editar</small>
          </h3><br>
          <h3 class="box-title">{{$informe->anio}}
          </h3>
        </div>
        {{Form::open(array('url'=>'informe/editar/'.$informe->id, 'class'=>'form-horizontal', 
          'method'=>'put'))}}
          <div class="box-body">
            <div class="form-group">
              {{Form::label(null, 'DE*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-5">
                <select name="remite" class="form-control input-sm" required id="usuario">
                  <option value="{{$informe->remite}}">{{$informe->remitente->persona->nombre}}
                    {{$informe->remitente->persona->apellidos}} (ACTUAL)</option>
                  <option value="">SELECIONAR</option>
                  @foreach($informe->empresa->usuarios as $usuario)
                    <option value="{{$usuario->id}}">{{$usuario->persona->nombre}} {{$usuario->persona->apellidos}}</option>
                  @endforeach
                </select>
                {{Form::label(null, $informe->area->nombre, array('class'=>'control-label', 'id'=>'area'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'SEÑORES*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('destinatario', $informe->destinatario, array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'DESTINATARIO', 'required'=>''))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'CARGO*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('cargo', $informe->cargo, array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'CARGO', 'required'=>''))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'ASUNTO*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('asunto', $informe->asunto, array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'ASUNTO', 'required'=>'', 'id'=>'asunto'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'FECHA*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('fecha', $informe->fecha, array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'FECHA', 'required'=>'', 'id'=>'fecha'))}}
              </div>
            </div>
          </div>
          <div class="box-body">
              <div class="form-group">
                <div class="col-xs-12">
                  <textarea id="contenido" name="contenido" rows="10" cols="80" placeholder="Contenido..." required="">
                      {{$informe->contenido}}
                  </textarea>
                </div>
              </div>
              {{Form::hidden('empresa_ruc', $informe->empresa->ruc, array('id'=>'empresa_ruc'))}}
              {{Form::button('Guardar', array('class'=>'btn btn-primary', 'type'=>'submit', 
                'id'=>'guardar'))}}
              <a href="<?=URL::to('informe/inicio/'.$informe->empresa_ruc)?>"
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

    //Rescata el area del remitente y el código de la carta
    $('#usuario').change(function(){
      $.ajax({
        url: "<?=URL::to('memorandum/area')?>",
        type: 'POST',
        data:{usuario_id: $("#usuario").val(), empresa_ruc: $("#empresa_ruc").val()},
        dataType: 'JSON',
        beforeSend: function() {
          $("#area").text('Buscando area...');
        },
        error: function() {
            $("#area").text('Ha surgido un error.');
        },
        success: function(respuesta) {
          if (respuesta) {
            $("#area").text(respuesta['nombre']);
            $("#codigo").text(respuesta['abreviatura']);
          } else {
            $("#area").text('El usuario no tiene un area definida.');
          }
        }
      });
    });

  });
</script>
@stop