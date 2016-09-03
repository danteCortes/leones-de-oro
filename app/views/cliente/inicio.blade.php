@extends('plantilla')

@section('titulo')
Cliente | Inicio
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
	    Clientes
	    <small>inicio</small>
  	</h1>
  	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
	    <li><a href="#">Clientes</a></li>
	    <li class="active">Inicio</li>
  	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
	      	<a class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
	        	<i class="fa fa-plus-square"></i> Nuevo Cliente
	      	</a>
	      	<div class="modal fade modal-primary" id="nuevo" tabindex="-1" role="dialog"
				aria-labelledby="myModalLabel" aria-hidden="true">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      	<div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title">Nuevo Cliente de {{$empresa->nombre}}</h4>
				      	</div>
				      	{{Form::open(array('url'=>'cliente/guardar', 'class'=>'form-horizontal', 'method'=>'post'))}}
					      	<div class="modal-body">
				                <div class="form-group">
				                	{{Form::label(null, 'RUC*:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('ruc', null, array('class'=>'form-control ruc input-sm', 'placeholder'=>'RUC',
				                  		'required'=>''))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Nombre*:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('nombre', null, array('class'=>'form-control mayuscula input-sm', 'placeholder'=>'NOMBRE',
				                  		'required'=>''))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Dirección*:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('direccion', null, array('class'=>'form-control mayuscula input-sm', 'placeholder'=>'DIRECCION'))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Teléfono:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('telefono', null, array('class'=>'form-control mayuscula input-sm', 'placeholder'=>'TELEFONO'))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Contacto:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('contacto', null, array('class'=>'form-control mayuscula input-sm', 'placeholder'=>'CONTACTO'))}}
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
		          <h3 class="box-title">Clientes de {{$empresa->nombre}}</h3>
		        </div>
		        <div class="box-body">
		          <table id="clientes" class="table table-bordered table-striped">
		            <thead>
			            <tr>
			              	<th>RUC</th>
			              	<th>Razón Social</th>
			              	<th>Mostrar</th>
			              	<th>Editar</th>
			              	<th>Borrar</th>
			            </tr>
		            </thead>
		            <tbody>
		            	@foreach($clientes as $cliente)
				            <tr>
				              	<td>{{$cliente->ruc}}</td>
				              	<td>{{$cliente->nombre}}</td>
				              	<td><a href="<?=URL::to('cliente/mostrar/'.$cliente->ruc)?>" class="btn btn-warning btn-xs">Mostrar</a>
				              	</td>
				              	<td>
				              		<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#editar{{$cliente->ruc}}">
								  	Editar
									</button>
									<div class="modal fade modal-info" id="editar{{$cliente->ruc}}" tabindex="-1" role="dialog">
									  	<div class="modal-dialog document">
										    <div class="modal-content">
										      	<div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											          <span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title">Editar Cliente</h4>
										      	</div>
										      	{{Form::open(array('url'=>'cliente/editar/'.$cliente->ruc, 'class'=>'form-horizontal', 'method'=>'put'))}}
											      	<div class="modal-body">
											      		<div class="row">
											      			<div class="col-xs-12">
											      				<div class="row">
											      					<div class="col-xs-12">
													                	{{Form::label(null, 'RUC:', array('class'=>'col-sm-2 control-label'))}}
													                  	<div class="col-sm-10">
													                  		{{Form::text('ruc', $cliente->ruc, array('class'=>'form-control input-sm ruc', 'placeholder'=>'RUC',
													                  		'required'=>''))}}
													                  	</div>
											      					</div>
											      				</div><br>
										                  		<div class="row">
											      					<div class="col-xs-12">
													                  	{{Form::label(null, 'Nombre:', array('class'=>'col-sm-2 control-label'))}}
													                  	<div class="col-sm-10">
													                  		{{Form::text('nombre', $cliente->nombre, array('class'=>'form-control input-sm mayuscula', 'placeholder'=>'NOMBRE',
													                  		'required'=>'', 'size'=>'80'))}}
													                  	</div>
											      					</div>
											      				</div><br>
											      				<div class="row">
											      					<div class="col-xs-12">
													                  	{{Form::label(null, 'Dirección*:', array('class'=>'col-sm-2 control-label'))}}
													                  	<div class="col-sm-10">
													                  		{{Form::text('direccion', $cliente->direccion, array('class'=>'form-control input-sm mayuscula', 'placeholder'=>'DIRECCION',
													                  		'size'=>'80'))}}
													                  	</div>
											      					</div>
											      				</div><br>
												                <div class="row">
												                	<div class="col-sm-12">
													                  	{{Form::label(null, 'Teléfono:', array('class'=>'col-sm-2 control-label'))}}
													                  	<div class="col-sm-10">
													                  		{{Form::text('telefono', $cliente->telefono, array('class'=>'form-control input-sm mayuscula', 'placeholder'=>'TELEFONO'))}}
													                  	</div>
												                	</div>
												                </div><br>
												                <div class="row">
												                	<div class="col-sm-12">
													                  	{{Form::label(null, 'Contacto:', array('class'=>'col-sm-2 control-label'))}}
													                  	<div class="col-sm-10">
													                  		{{Form::text('contacto', $cliente->contacto, array('class'=>'form-control input-sm mayuscula', 'placeholder'=>'CONTACTO'
													                  		, 'size'=>'80'))}}
													                  	</div>
												                	</div>
												                </div>
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
								</td>
				              	<td>
				              		<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#borrar{{$cliente->ruc}}">
								  	Borrar
									</button>
									<div class="modal fade modal-danger" id="borrar{{$cliente->ruc}}" tabindex="-1" role="dialog"
										aria-labelledby="myModalLabel" aria-hidden="true">
									  	<div class="modal-dialog">
										    <div class="modal-content">
										      	<div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											          <span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title">Borrar cliente</h4>
										      	</div>
										      	{{Form::open(array('url'=>'cliente/borrar/'.$cliente->ruc, 'class'=>'', 'method'=>'delete'))}}
											      	<div class="modal-body">
										                <div class="form-group">
										                	<label>Está a punto de eliminar la cliente "{{$cliente->nombre}}". Algunos datos como trabajadores,
                        									contratos, etc. asociados a este cliente serán borrados.<br>
                        									Le recomendamos cambiar los trabajadores asociados a este cliente antes de eliminarlo.</label>
										                </div>
										                <div class="form-group">
										                  	<label>Para confirmar esta acción se necesita su contraseña, de lo contrario pulse cancelar para
									                        declinar.</label>
									                        {{Form::password('password', array('class'=>'form-control input-sm', 'placeholder'=>'PASSWORD',
									                        'required'=>''))}}
										                </div>
											      	</div>
											      	<div class="modal-footer clearfix">
											      		{{Form::hidden('empresa', $empresa->ruc)}}
												        <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
												        <button type="submit" class="btn btn-outline pull-left">Borrar</button>
											      	</div>
										      	{{Form::close()}}
										    </div>
									  	</div>
									</div>
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
    	$('#clientes').dataTable({            
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