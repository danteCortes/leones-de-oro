@extends('plantilla')

@section('titulo')
Trabajador | Inicio
@stop

@section('estilos')
<link rel="stylesheet" href="<?=URL::to('plugins/datatables/dataTables.bootstrap.css')?>">
<style type="text/css">
	.mayuscula{
		text-transform: uppercase;
	}
</style>
@stop

@section('contenido')
<section class="content-header">
  	<h1>
	    Trabajadores
	    <small>{{$empresa->nombre}}</small>
  	</h1>
  	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
	    <li><a href="#">Trabajadores</a></li>
	    <li class="active">Inicio</li>
  	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
	      	<a class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
	        	<i class="fa fa-plus-square"></i> Nuevo Trabajador
	      	</a>
	      	<div class="modal fade modal-primary" id="nuevo" tabindex="-1" role="dialog"
				aria-labelledby="myModalLabel" aria-hidden="true">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      	<div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title">Nuevo Trabajador de {{$empresa->nombre}}</h4>
				      	</div>
				      	{{Form::open(array('url'=>'trabajador/contratar', 'class'=>'form-horizontal', 'method'=>'post'))}}
					      	<div class="modal-body">
				                <div class="form-group">
				                	{{Form::label(null, 'DNI*:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('dni', null, array('class'=>'form-control dni', 'placeholder'=>'DNI',
				                  		'required'=>''))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Nombre*:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('nombre', null, array('class'=>'form-control mayuscula', 'placeholder'=>'NOMBRE',
				                  		'required'=>''))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Apellidos*:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('apellidos', null, array('class'=>'form-control mayuscula', 'placeholder'=>'APELLIDOS',
				                  		'required'=>''))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Dirección*:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('direccion', null, array('class'=>'form-control mayuscula', 'placeholder'=>'DIRECCION'))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Teléfono:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('telefono', null, array('class'=>'form-control mayuscula', 'placeholder'=>'TELEFONO'))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Nro Cuenta:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('cuenta', null, array('class'=>'form-control mayuscula', 'placeholder'=>'NRO DE CUENTA'))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Banco:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('banco', null, array('class'=>'form-control mayuscula', 'placeholder'=>'BANCO'))}}
				                  	</div>
				                </div>
					      	</div>
					      	<div class="modal-footer clearfix">
					      		{{Form::hidden('empresa', $empresa->ruc)}}
						        <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
						        <button type="submit" class="btn btn-outline pull-left">Guardar</button>
					      	</div>
				      	{{Form::close()}}
				    </div>
			  	</div>
			</div>
		</div>
	</div>
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
	    <div class="col-xs-12">
	      	<div class="box">
		        <div class="box-header">
		          <h3 class="box-title">Trabajadores de {{$empresa->nombre}}</h3>
		        </div>
		        <div class="box-body">
		          <table id="trabajadores" class="table table-bordered table-striped">
		            <thead>
			            <tr>
			              	<th>DNI</th>
			              	<th>Trabajador</th>
			              	<th>Ver</th>
			              	<th>Editar</th>
			              	<th>Borrar</th>
			            </tr>
		            </thead>
		            <tbody>
		            	@foreach($trabajadores as $trabajador)
				            <tr>
				              	<td>{{Trabajador::find($trabajador->id)->persona->dni}}</td>
				              	<td>{{Trabajador::find($trabajador->id)->persona->nombre}}
				              		{{Trabajador::find($trabajador->id)->persona->apellidos}}</td>
				              	<td>
				              		<a href="<?=URL::to('trabajador/ver/'.$trabajador->id)?>" class="btn btn-warning btn-xs">Ver</a>
								</td>
				              	<td>
				              		<a href="<?=URL::to('trabajador/editar/'.$trabajador->id)?>" class="btn btn-info btn-xs">Editar</a>
								</td>
				              	<td>
				              		<a href="<?=URL::to('trabajador/borrar/'.$trabajador->id)?>" class="btn btn-danger btn-xs">Borrar</a>
				              	</td>
				            </tr>
			            @endforeach
		            </tbody>
		          </table>
		        </div>
	      	</div>
	    </div>
  	</div>
</section>
@stop

@section('scripts')
<script>
  	$(function () {
    	$('#trabajadores').dataTable({            
            "oLanguage": {
                "oPaginate": {
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior",                            
                },
                "sSearch": "Buscar" ,
                "sInfo": " Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sLengthMenu": "Mostrar _MENU_ resultados por página",
                "sInfoFiltered": " - filtrando de _MAX_ resultados"
            }
        });
  	});
</script>
@stop