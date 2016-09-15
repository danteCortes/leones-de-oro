@extends('plantilla')

@section('titulo')
Contratos | Nuevo
@stop

@section('estilos')
<link rel="stylesheet" type="text/css" href="<?=URL::to('plugins/jQueryUI/jquery-ui.css')?>">
@stop

@section('contenido')
<section class="content-header">
  	<h1>
	    Contratos
	    <small>nuevo</small>
  	</h1>
  	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Nuevo</a></li>
	    <li><a href="#">Contratos</a></li>
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
		<div class="col-xs-8">
			<div class="box box-primary">
	            <div class="box-header with-border">
	              <h3 class="box-title">Nuevo Contrato para {{$empresa->nombre}}</h3>
	            </div>
	            {{Form::open(array('url'=>'contrato/nuevo/'.$empresa->ruc, 'class'=>'form-horizontal', 'files'=>true))}}
	              	<div class="box-body">
		                <div class="form-group">
		                  	{{Form::label(null, 'RUC*:', array('class'=>'control-label col-xs-2'))}}
		                  	<div class="col-xs-10">
			                  	{{Form::text('ruc', null, array('class'=>'form-control input-sm'
			                  	, 'id'=>'ruc', 'readonly'=>'', 'required'=>'', 'placeholder'=>'RUC'))}}
		                  	</div>
		                </div>
		                <div class="form-group">
		                  	{{Form::label(null, 'Cliente*:', array('class'=>'control-label col-xs-2'))}}
		                  	<div class="col-xs-10">
			                  	{{Form::text('cliente', null, array('class'=>'form-control input-sm clientes mayuscula'
			                  	,'required'=>'', 'placeholder'=>'CLIENTE'))}}
		                  	</div>
		                </div>
		                <div class="form-group">
		                  	{{Form::label(null, 'Inicio*:', array('class'=>'col-sm-2 control-label'))}}
		                  	<div class="col-sm-10">
		                  		{{Form::text('inicio', null, array('class'=>'form-control input-sm', 'placeholder'=>'INICIO',
		                  		'data-inputmask'=>"'alias': 'dd/mm/yyyy'", 'data-mask'=>'', 'required'=>''))}}
		                  	</div>
		                </div>
		                <div class="form-group">
		                  	{{Form::label(null, 'Fin*:', array('class'=>'col-sm-2 control-label'))}}
		                  	<div class="col-sm-10">
		                  		{{Form::text('fin', null, array('class'=>'form-control input-sm', 'placeholder'=>'FIN',
		                  		'data-inputmask'=>"'alias': 'dd/mm/yyyy'", 'data-mask'=>'', 'required'=>''))}}
		                  	</div>
		                </div>
		                <div class="form-group">
		                  	{{Form::label(null, 'Total*:', array('class'=>'control-label col-xs-2'))}}
		                  	<div class="col-xs-10">
			                  	{{Form::text('total', null, array('class'=>'form-control input-sm precio'
			                  	,'required'=>'', 'placeholder'=>'TOTAL'))}}
		                  	</div>
		                </div>
		                <div class="form-group">
		                  	{{Form::label(null, 'IGV:', array('class'=>'control-label col-xs-2'))}}
		                  	<div class="col-xs-10">
		                  		<div class="checkbox">
		                  			<label>
		                  				{{Form::checkbox('igv', 1)}}
		                  			</label>
		                  		</div>
		                  	</div>
		                </div>
		                <div class="form-group">
		                  	{{Form::label(null, 'Contrato*:', array('class'=>'col-sm-2 control-label'))}}
		                  	<div class="col-sm-10">
		                  		{{Form::file('contrato', array('required'=>''))}}
		                  	</div>
		                </div>
	              	</div>
	              	<div class="box-footer">
	              		{{Form::hidden('empresa_ruc', $empresa->ruc, array('id'=>'empresa_ruc'))}}
	                	{{Form::button('Guardar', array('class'=>'btn btn-primary',
	                		'type'=>'submit'))}}
	                	{{Form::button('Limpiar', array('class'=>'btn btn-defaul',
	                		'type'=>'reset'))}}
	                	<a href="<?=URL::to('contrato/inicio/'.$empresa->ruc)?>" 
	                		class="btn btn-warning pull-right">Cancelar</a>
	              	</div>
	            {{Form::close()}}
          	</div>
		</div>
	</div>
</section>
@stop

@section('scripts')
<script src="<?=URL::to('plugins/jQueryUI/jquery-ui.min.js')?>" type="text/javascript"></script>
<script>
  	$(function(){
	    var autocompletar = new Array();
	    @foreach($clientes as $l)
	       	autocompletar.push('{{$l->nombre}}');
	    @endforeach
	    $(".clientes").autocomplete({ //Usamos el ID de la caja de texto donde lo queremos
	       	source: autocompletar //Le decimos que nuestra fuente es el arreglo
	    });
	    $(".clientes").focusout(function() {
            $.ajax({
                url: "<?=URL::to('contrato/buscar-ruc')?>",
                type: 'POST',
                data: {nombre: $(".clientes").val(), empresa_ruc: $("#empresa_ruc").val()},
                dataType: 'JSON',
                beforeSend: function() {
                   	$("#ruc").val('Buscando RUC...');
                },
                error: function() {
                   	$("#ruc").val('Ha surgido un error.');
                },
                success: function(respuesta) {
                   	if (respuesta) {
                   		$("#ruc").val(respuesta['ruc']);
                   	} else {
                      	$("#ruc").val('No se encontro ningun cliente con ese nombre.');
                   	}
                }
            });
        });
        //fecha dd/mm/yyyy
    	$("[data-mask]").inputmask();
  	});
</script>
@stop