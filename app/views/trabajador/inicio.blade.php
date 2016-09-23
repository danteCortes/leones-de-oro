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
				      	{{Form::open(array('url'=>'trabajador/contratar', 'class'=>'form-horizontal', 'method'=>'post', 'files'=>true))}}
					      	<div class="modal-body">
				                <div class="form-group">
				                	{{Form::label(null, 'DNI*:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		{{Form::text('dni', null, array('class'=>'form-control dni input-sm', 'placeholder'=>'DNI',
				                  		'required'=>''))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Nombre*:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		{{Form::text('nombre', null, array('class'=>'form-control mayuscula input-sm', 'placeholder'=>'NOMBRE',
				                  		'required'=>''))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Apellidos*:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		{{Form::text('apellidos', null, array('class'=>'form-control mayuscula input-sm', 'placeholder'=>'APELLIDOS',
				                  		'required'=>''))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Dirección:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		{{Form::text('direccion', null, array('class'=>'form-control mayuscula input-sm', 'placeholder'=>'DIRECCION'))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Teléfono:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		{{Form::text('telefono', null, array('class'=>'form-control mayuscula input-sm', 'placeholder'=>'TELEFONO'))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Inicio*:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		{{Form::text('inicio', null, array('class'=>'form-control input-sm', 'placeholder'=>'INICIO',
				                  		'data-inputmask'=>"'alias': 'dd/mm/yyyy'", 'data-mask'=>'', 'required'=>''))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Fin*:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		{{Form::text('fin', null, array('class'=>'form-control input-sm', 'placeholder'=>'FIN',
				                  		'data-inputmask'=>"'alias': 'dd/mm/yyyy'", 'data-mask'=>'', 'required'=>''))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Nro Cuenta:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		{{Form::text('cuenta', null, array('class'=>'form-control mayuscula input-sm', 'placeholder'=>'NRO DE CUENTA'))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Banco:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		{{Form::text('banco', null, array('class'=>'form-control mayuscula input-sm', 'placeholder'=>'BANCO'))}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'CCI:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		<div class="checkbox">
				                  			<label>
				                  				{{Form::checkbox('cci', 1)}}
				                  			</label>
				                  		</div>
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Foto:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		{{Form::file('foto')}}
				                  	</div>
				                </div>
				                <div class="form-group">
				                  	{{Form::label(null, 'Contrato*:', array('class'=>'col-sm-3 control-label'))}}
				                  	<div class="col-sm-9">
				                  		{{Form::file('contrato', array('required'=>''))}}
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
				              		<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#borrar{{$trabajador->id}}">
								  	Borrar
									</button>
									<div class="modal fade modal-danger" id="borrar{{$trabajador->id}}" tabindex="-1" role="dialog"
										aria-labelledby="myModalLabel" aria-hidden="true">
									  	<div class="modal-dialog">
										    <div class="modal-content">
										      	<div class="modal-header">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											          <span aria-hidden="true">&times;</span></button>
											        <h4 class="modal-title">Borrar Trabajador</h4>
										      	</div>
										      	{{Form::open(array('url'=>'trabajador/borrar/'.$trabajador->id, 'class'=>'', 'method'=>'delete'))}}
											      	<div class="modal-body">
										                <div class="form-group">
										                	<label>Está a punto de eliminar al trabajador "{{$trabajador->persona->nombre}}". Algunos datos como
                        									documentos, uniformes, herramientas, etc. asociados a este trabajador serán borrados.<br>
                        									Le recomendamos cambiar los registros asociados a este trabajador antes de eliminarlo.</label>
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

@section('scripts')
<script>
  	$(function () {
  		//Datatable con traducción
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
        //fecha dd/mm/yyyy
    	$("[data-mask]").inputmask();
  	});
</script>
@stop