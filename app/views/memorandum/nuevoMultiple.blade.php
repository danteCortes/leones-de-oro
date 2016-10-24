@extends('plantilla')

@section('titulo')
Memorandum | Nuevo
@stop

@section('estilos')
<link rel="stylesheet" type="text/css" href="<?=URL::to('plugins/jQueryUI/jquery-ui.css')?>">
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Memorandum Múltiple
    <small>Nuevo</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Memorandum Múltiple</a></li>
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
          <h3 class="box-title">MEMORANDUM MULTIPLE Nº <label id="nro">
            @if(Variable::where('empresa_ruc', '=', $empresa->ruc)->where('anio', '=', date('Y'))->first())
              @if(Variable::where('empresa_ruc', '=', $empresa->ruc)->where('anio', '=', date('Y'))->first()->inicio_memorandum)
                @if(Memorandum::where('empresa_ruc', '=', $empresa->ruc)->where('redaccion', 'like', '%'.date('Y').'%')
                  ->orderBy('numero', 'desc')->first())
                  {{Memorandum::where('empresa_ruc', '=', $empresa->ruc)->orderBy('numero', 'desc')->first()->numero+1}}
                @else
                  {{Variable::where('empresa_ruc', '=', $empresa->ruc)->where('anio', '=', date('Y'))->first()->inicio_memorandum}}
                @endif
              @else
                {{Form::button('Configurar Numeración', array('class'=>'btn btn-primary btn-xs',
                  'data-toggle'=>'modal', 'data-target'=>'#modal'))}}
                <div class="modal fade bs-example-modal-sm" id="modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Ingrese numeración inicial</h4>
                      </div>
                      {{Form::open(array('url'=>'memorandum/numeracion', 'class'=>'form-horizontal'))}}
                        <div class="modal-body">
                          <div class="form-group">
                            {{Form::label(null, 'Numeración*:', array('class'=>'control-label col-sm-6'))}}
                            <div class="col-sm-6">
                              {{Form::text('numero', null, array('class'=>'form-control input-sm numero', 
                              'id'=>'numero', 'required'=>''))}}
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          {{Form::hidden('empresa_ruc', $empresa->ruc, array('id'=>'empresa_ruc'))}}
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-primary" id="numeracion">Guardar</button>
                        </div>
                      {{Form::close()}}
                    </div>
                  </div>
                </div>
              @endif
            @else
              {{Form::button('Configurar Numeración', array('class'=>'btn btn-primary btn-xs',
                'data-toggle'=>'modal', 'data-target'=>'#modal'))}}
              <div class="modal fade bs-example-modal-sm" id="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <h4 class="modal-title">Ingrese numeración inicial</h4>
                    </div>
                    {{Form::open(array('url'=>'memorandum/numeracion', 'class'=>'form-horizontal'))}}
                      <div class="modal-body">
                        <div class="form-group">
                          {{Form::label(null, 'Numeración*:', array('class'=>'control-label col-sm-6'))}}
                          <div class="col-sm-6">
                            {{Form::text('numero', null, array('class'=>'form-control input-sm numero', 
                            'id'=>'numero', 'required'=>''))}}
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        {{Form::hidden('empresa_ruc', $empresa->ruc, array('id'=>'empresa_ruc'))}}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="numeracion">Guardar</button>
                      </div>
                    {{Form::close()}}
                  </div>
                </div>
              </div>
            @endif
            </label> - {{date('Y')}}/<label id="codigo">X</label>/{{$empresa->nombre}}  
            <small>Redactar</small>
          </h3>
        </div>
        {{Form::open(array('url'=>'memorandum/nuevo-multiple', 'class'=>'form-horizontal', 
          'method'=>'post', 'id'=>'formulario'))}}
          <div class="box-body">
            <div class="form-group">
              {{Form::label(null, 'DE*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-5">
                <select name="remite" class="form-control input-sm" required id="usuario">
                  <option value="">SELECIONAR</option>
                  @foreach($empresa->usuarios as $usuario)
                    <option value="{{$usuario->id}}">{{$usuario->persona->nombre}} 
                      {{$usuario->persona->apellidos}}</option>
                  @endforeach
                </select>
                {{Form::label(null, '', array('class'=>'control-label', 'id'=>'area'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'A*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="todos" value="1" id="todos"> Todos de {{$empresa->nombre}}
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, '', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                <select name="cliente" class="form-control input-sm" id="cliente">
                  <option value="">SELECIONAR</option>
                  @foreach($empresa->clientes as $cliente)
                    <option value="{{$cliente->ruc}}">{{$cliente->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, '', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10" id="trabajadores">
                {{Form::text('destinatario','' , array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'DESTINATARIO', 'id'=>'trabajador'))}}
                {{Form::button('Agregar', array('id'=>'btnAgregar', 
                  'class'=>'btn btn-success btn-xs'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'ASUNTO*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('asunto', '', array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'ASUNTO', 'required'=>'', 'id'=>'asunto'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'FECHA*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('fecha', '', array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'FECHA', 'required'=>'', 'id'=>'fecha'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'RAZON*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-5">
                <select name="razon" class="input-sm form-control" required>
                  <option value=''>SELECCIONE RAZON</option>
                  @foreach(TipoMemorandum::all() as $tipo)
                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="box-body">
              <div class="form-group">
                <div class="col-xs-12">
                  <textarea id="contenido" name="contenido" rows="10" cols="80" placeholder="Contenido..." required="">
                      Contenido...
                  </textarea>
                </div>
              </div>
              {{Form::button('Guardar', array('class'=>'btn btn-primary', 'type'=>'submit', 
                'id'=>'guardar'))}}
              <a href="<?=URL::to('memorandum/inicio/'.$empresa->ruc)?>"
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
<script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script>

<script src="<?=URL::to('plugins/jQueryUI/jquery-ui.min.js')?>" type="text/javascript"></script>

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('contenido');

    //Rescata el area del remitente y el código del memorandum
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

    //autocompletar los trabajadores
    var arreglo = new Array();
    @foreach($trabajadores as $trabajador)
        arreglo.push('{{$trabajador->persona->nombre}} {{$trabajador->persona->apellidos}}');
    @endforeach
    $("#trabajador").autocomplete({ //Usamos el ID de la caja de texto donde lo queremos
        source: arreglo //Le decimos que nuestra fuente es el arreglo
    });

    //verificamos si el trabajador existe.
    $("#trabajador").focus(function(){
      $("#trabajador_dni").text("");
      $("#trabajador_id").val('');
    });

    $("#todos").change(function(){
      $("#trabajador").val("");
      if($("#todos").prop("checked")){
        $("#cliente").prop("disabled", true);
        $("#trabajador").prop("disabled", true);
        $("#btnAgregar").addClass("disabled");
        $("#trabajadores > label").remove();
        $("#trabajadores > br").remove();
        $("#trabajadores > :hidden").remove();
      }else{
        $("#cliente").prop("disabled", false);
        $("#trabajador").prop("disabled", false);
        $("#btnAgregar").removeClass("disabled");
      }
    });

    $("#btnAgregar").click(function(){
      if(!$(this).hasClass("disabled")){
        if($("#trabajador").val() != ""){
          $.ajax({
            url: "<?=URL::to('memorandum/agregar-trabajador')?>",
            type: 'POST',
            data: {trabajador_nombre_apellidos: $("#trabajador").val(), empresa_ruc: 
              $("#empresa_ruc").val()},
            error: function(){
              alert("hubo un error en la conexión con el controlador");
            },
            success: function(respuesta){
              if(respuesta != 0){
                $("#trabajador").val("");
                $("#trabajadores").append("<br><label class='control-label'>"+
                  respuesta['persona']['nombre']+" "+respuesta['persona']['apellidos']+
                  "</label>");
                $("#trabajadores").append("<input type='hidden' name='trabajador"+
                  respuesta['persona']['dni']+"' value='"+
                  respuesta['persona']['dni']+"'/>")
              }
            }
          });
        }
      }
    });
  });
</script>
@stop