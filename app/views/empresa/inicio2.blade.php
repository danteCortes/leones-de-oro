@extends('plantilla')

@section('titulo')
Empresa | Inicio
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
	    Empresas
	    <small>inicio</small>
  	</h1>
  	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
	    <li><a href="#">Empresas</a></li>
	    <li class="active">Inicio</li>
  	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
	      	<a class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
	        	<i class="fa fa-plus-square"></i> Nueva Empresa
	      	</a>
	      	<div class="modal fade modal-primary" id="nuevo" tabindex="-1" role="dialog"
				aria-labelledby="myModalLabel" aria-hidden="true">
			  	<div class="modal-dialog">
				    <div class="modal-content">
				      	<div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title">Nueva Empresa</h4>
				      	</div>
				      	{{Form::open(array('url'=>'empresa', 'class'=>'form-horizontal', 'method'=>'post'))}}
					      	<div class="modal-body">
				                <div class="form-group">
				                	{{Form::label(null, 'RUC:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('ruc', null, array('class'=>'form-control ruc', 'placeholder'=>'RUC',
				                  		'required'=>''))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Nombre:', array('class'=>'col-sm-2 control-label'))}}
				                  	<div class="col-sm-10">
				                  		{{Form::text('nombre', null, array('class'=>'form-control mayuscula', 'placeholder'=>'NOMBRE',
				                  		'required'=>''))}}
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
		          <h3 class="box-title">Empresas</h3>
		        </div>
		        <div class="box-body">
		          <table id="empresas" class="table table-bordered table-striped">
		            <thead>
			            <tr>
			              	<th>RUC</th>
			              	<th>Empresa</th>
			              	<th>Editar</th>
			              	<th>Borrar</th>
			            </tr>
		            </thead>
		            <tbody>
		            	@foreach($empresas as $empresa)
				            <tr>
				              	<td>{{$empresa->ruc}}</td>
				              	<td>{{$empresa->nombre}}</td>
				              	<td>
				              		<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#editar{{$empresa->ruc}}">
								  	Editar
									</button>
									<div class="modal fade modal-info" id="editar{{$empresa->ruc}}" tabindex="-1" role="dialog"
										aria-labelledby="myModalLabel" aria-hidden="true">
									  	<div class="modal-dialog">
										    <div class="modal-content">
										      	<div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											          <span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title">Editar Empresa</h4>
										      	</div>
										      	{{Form::open(array('url'=>'empresa/'.$empresa->ruc, 'class'=>'form-horizontal', 'method'=>'put'))}}
											      	<div class="modal-body">
										                <div class="form-group">
										                	{{Form::label(null, 'RUC:', array('class'=>'col-sm-2 control-label'))}}
										                  	<div class="col-sm-10">
										                  		{{Form::text('ruc', $empresa->ruc, array('class'=>'form-control ruc', 'placeholder'=>'RUC',
										                  		'required'=>''))}}
										                  	</div>
										                </div>
										                <div class="form-group">
										                  	{{Form::label(null, 'Nombre:', array('class'=>'col-sm-2 control-label'))}}
										                  	<div class="col-sm-10">
										                  		{{Form::text('nombre', $empresa->nombre, array('class'=>'form-control mayuscula', 'placeholder'=>'RUC',
										                  		'required'=>''))}}
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
				              		<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#borrar{{$empresa->ruc}}">
								  	Borrar
									</button>
									<div class="modal fade modal-danger" id="borrar{{$empresa->ruc}}" tabindex="-1" role="dialog"
										aria-labelledby="myModalLabel" aria-hidden="true">
									  	<div class="modal-dialog">
										    <div class="modal-content">
										      	<div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											          <span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title">Borrar Empresa</h4>
										      	</div>
										      	{{Form::open(array('url'=>'empresa/'.$empresa->ruc, 'class'=>'', 'method'=>'delete'))}}
											      	<div class="modal-body">
										                <div class="form-group">
										                	<label>Está a punto de eliminar la empresa "{{$empresa->nombre}}". Algunos datos como usuarios,
                        									trabajadores, documentos, etc. asociados a esta empresa serán borrados.<br>
                        									Le recomendamos cambiar los registros asociados a esta empresa antes de eliminarlo.</label>
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
