@extends('plantilla')

@section('titulo')
Memorandum | Nuevo
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Memorandum
    <small>Nuevo</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Memorandum</a></li>
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
          <h3 class="box-title">MEMORANDUM Nº <label id="nro">
            @if(Memorandum::where('empresa_ruc', '=', $empresa->ruc)->orderBy('numero', 'desc')->first())
              {{Memorandum::where('empresa_ruc', '=', $empresa->ruc)->orderBy('numero', 'desc')->first()->numero+1}}
            @else
              1
            @endif
            </label> - {{date('Y')}}/
            	<label id="codigo">X</label>/{{$empresa->nombre}}	
            <small>Redactar</small>
          </h3>
        </div>
        {{Form::open(array('url'=>'memorandum/nuevo', 'class'=>'form-horizontal', 
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
	        			{{Form::text('destinatario', null, array('class'=>'form-control input-sm mayuscula'
	        				,'placeholder'=>'DESTINATARIO', 'required'=>''))}}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		{{Form::label(null, 'ASUNTO*:', array('class'=>'control-label col-xs-2'))}}
	        		<div class="col-xs-10">
	        			{{Form::text('asunto', null, array('class'=>'form-control input-sm mayuscula'
	        				,'placeholder'=>'ASUNTO', 'required'=>''))}}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		{{Form::label(null, 'FECHA*:', array('class'=>'control-label col-xs-2'))}}
	        		<div class="col-xs-10">
	        			{{Form::text('fecha', null, array('class'=>'form-control input-sm mayuscula'
	        				,'placeholder'=>'FECHA', 'required'=>''))}}
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
                'id'=>'guardar', 'target'=>'_blank'))}}
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
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('contenido');
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