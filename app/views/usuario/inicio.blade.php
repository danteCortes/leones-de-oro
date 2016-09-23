@extends('plantilla')

@section('titulo')
Usuario | Inicio
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
	    Usuarios
	    <small>inicio</small>
  	</h1>
  	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
	    <li><a href="#">Usuarios</a></li>
	    <li class="active">Inicio</li>
  	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
	      	<a class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
	        	<i class="fa fa-plus-square"></i> Nuevo Usuario
	      	</a>
	      	<div class="modal fade modal-primary" id="nuevo" tabindex="-1" role="dialog"
				aria-labelledby="myModalLabel" aria-hidden="true">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      	<div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title">Nuevo Usuario</h4>
				      	</div>
				      	{{Form::open(array('url'=>'usuario/nuevo', 'class'=>'form-horizontal', 'method'=>'post'))}}
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
		                  	{{Form::label(null, 'Dirección:', array('class'=>'col-sm-2 control-label'))}}
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
	                  	{{Form::label(null, 'Tipo*:', array('class'=>'col-sm-2 control-label'))}}
	                  	<div class="col-sm-10">
	                  		<div class="radio">
	                  			<label>
	                  				{{Form::radio('nivel', 1, 1)}} Usuario
	                  			</label><br>
	                  			<label>
	                  				{{Form::radio('nivel', 0)}} Administrador
	                  			</label>
	                  		</div>
	                  	</div>
		                </div>
					      	</div>
					      	<div class="modal-footer clearfix">
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
		          <h3 class="box-title">Usuarios</h3>
		        </div>
		        <div class="box-body">
		          <table id="usuarios" class="table table-bordered table-striped">
		            <thead>
			            <tr>
			              	<th>DNI</th>
			              	<th>Usuario</th>
			              	<th>Mostrar</th>
			              	<th>Editar</th>
			              	<th>Borrar</th>
			            </tr>
		            </thead>
		            <tbody>
		            	@foreach($usuarios as $usuario)
				            <tr>
				              	<td>{{$usuario->persona->dni}}</td>
				              	<td>{{$usuario->persona->nombre}} {{$usuario->persona->apellidos}}</td>
				              	<td><a href="<?=URL::to('usuario/mostrar/'.$usuario->id)?>" class="btn btn-warning btn-xs">Mostrar</a> </td>
				              	<td>
				              		<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#editar{{$usuario->id}}">
												  	Editar
													</button>
													<div class="modal fade modal-info" id="editar{{$usuario->id}}" tabindex="-1" role="dialog"
														aria-labelledby="myModalLabel" aria-hidden="true">
													  	<div class="modal-dialog">
														    <div class="modal-content">
														      	<div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
															          <span aria-hidden="true">&times;</span></button>
															        <h4 class="modal-title">Editar usuario</h4>
														      	</div>
														      	{{Form::open(array('url'=>'usuario/editar/'.$usuario->id, 'class'=>'form-horizontal', 'method'=>'put'))}}
															      	<div class="modal-body">
												                <div class="form-group">
												                	{{Form::label(null, 'DNI*:', array('class'=>'col-sm-2 control-label'))}}
												                  	<div class="col-sm-10">
												                  		{{Form::text('dni', $usuario->persona->dni, array('class'=>'form-control dni',
												                  		'required'=>''))}}
												                  	</div>
												                </div>
												                <div class="form-group">
												                  	{{Form::label(null, 'Nombre*:', array('class'=>'col-sm-2 control-label'))}}
												                  	<div class="col-sm-10">
												                  		{{Form::text('nombre', $usuario->persona->nombre, array('class'=>'form-control mayuscula',
												                  		'required'=>''))}}
												                  	</div>
												                </div>
												                <div class="form-group">
												                  	{{Form::label(null, 'Apellidos*:', array('class'=>'col-sm-2 control-label'))}}
												                  	<div class="col-sm-10">
												                  		{{Form::text('apellidos', $usuario->persona->apellidos, array('class'=>'form-control mayuscula',
												                  		'required'=>''))}}
												                  	</div>
												                </div>
												                <div class="form-group">
												                  	{{Form::label(null, 'Dirección:', array('class'=>'col-sm-2 control-label'))}}
												                  	<div class="col-sm-10">
												                  		{{Form::text('direccion', $usuario->persona->direccion, array('class'=>'form-control mayuscula'))}}
												                  	</div>
												                </div>
												                <div class="form-group">
												                  	{{Form::label(null, 'Teléfono:', array('class'=>'col-sm-2 control-label'))}}
												                  	<div class="col-sm-10">
												                  		{{Form::text('telefono', $usuario->persona->telefono, array('class'=>'form-control'))}}
												                  	</div>
												                </div>
												                <div class="form-group">
											                  	{{Form::label(null, 'Tipo*:', array('class'=>'col-sm-2 control-label'))}}
											                  	<div class="col-sm-10">
											                  		<div class="radio">
											                  			<label>
											                  				@if($usuario->nivel == 1)
											                  				{{Form::radio('nivel', 1, 1)}} Usuario
											                  				@else
											                  				{{Form::radio('nivel', 1)}} Usuario
											                  				@endif
											                  			</label><br>
											                  			<label>
											                  				@if($usuario->nivel == 0)
											                  				{{Form::radio('nivel', 0, 1)}} Administrador
											                  				@else
											                  				{{Form::radio('nivel', 0)}} Administrador
											                  				@endif
											                  			</label>
											                  		</div>
											                  	</div>
												                </div>
															      	</div>
															      	<div class="modal-footer clearfix">
																        <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
																        <button type="submit" class="btn btn-outline pull-left">Guardar</button>
															      	</div>
														      	{{Form::close()}}
														    </div>
													  	</div>
													</div>
												</td>
				              	<td>
				              		<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#borrar{{$usuario->id}}">
												  	Borrar
													</button>
													<div class="modal fade modal-danger" id="borrar{{$usuario->id}}" tabindex="-1" role="dialog"
														aria-labelledby="myModalLabel" aria-hidden="true">
													  	<div class="modal-dialog">
														    <div class="modal-content">
														      	<div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
															          <span aria-hidden="true">&times;</span></button>
															        <h4 class="modal-title">Borrar usuario</h4>
														      	</div>
														      	{{Form::open(array('url'=>'usuario/borrar/'.$usuario->id, 'class'=>'', 'method'=>'delete'))}}
															      	<div class="modal-body">
														                <div class="form-group">
														                	<label>Está a punto de eliminar la usuario "{{$usuario->persona->nombre}} 
														                		{{$usuario->persona->apellidos}}". Algunos datos como documentos
														                		emitidos, cargos,etc. asociados a esta usuario serán borrados.<br>
				                        								Le recomendamos cambiar los registros asociados a esta usuario antes de eliminarlo.</label>
														                </div>
														                <div class="form-group">
														                  	<label>Para confirmar esta acción se necesita su contraseña, de lo contrario pulse cancelar para
													                        declinar.</label>
													                        {{Form::password('password', array('class'=>'form-control input-sm', 'placeholder'=>'PASSWORD',
													                        'required'=>''))}}
														                </div>
															      	</div>
															      	<div class="modal-footer clearfix">
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