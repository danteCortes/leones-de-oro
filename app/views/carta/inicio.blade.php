@extends('plantilla')

@section('titulo')
Carta | Inicio
@stop

@section('estilos')
<link rel="stylesheet" href="<?=URL::to('plugins/datatables/dataTables.bootstrap.css')?>">
@stop

@section('contenido')
<section class="content-header">
  	<h1>
	    Cartas de {{$empresa->nombre}}
	    <small>inicio</small>
  	</h1>
  	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
	    <li><a href="#">Cartas</a></li>
	    <li class="active">Inicio</li>
  	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
	      	<a class="btn btn-primary" href="<?=URL::to('carta/nuevo/'.$empresa->ruc)?>">
	        	<i class="fa fa-plus-square"></i> Nueva Carta
	      	</a>
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
          <h3 class="box-title">Cartas de {{$empresa->nombre}}</h3>
        </div>
        <div class="box-body">
          <table id="cartas" class="table table-bordered table-striped">
            <thead>
	            <tr>
              	<th>Carta</th>
              	<th>Remitente</th>
              	<th>Destinatario</th>
              	<th>Mostrar</th>
              	<th>Editar</th>
              	<th>Borrar</th>
	            </tr>
            </thead>
            <tbody>
            	@foreach($cartas as $carta)
            		@if($carta->usuario)
			            <tr>
		              	<td>{{$carta->codigo}}</td>
		              	<td>{{Usuario::find($carta->remite)->persona->nombre}}</td>
		              	<td>{{Trabajador::find($carta->trabajador_id)->persona->nombre}}
		              		{{Trabajador::find($carta->trabajador_id)->persona->apellidos}}</td>
		              	<td><a href="<?=URL::to('carta/mostrar/'.$carta->id)?>" class="btn btn-warning btn-xs">Mostrar</a>
		              	</td>
		              	<td>
		              		<a class="btn btn-primary btn-xs" href="<?=URL::to('carta/editar/'.$carta->id)?>">
							        	Editar
							      	</a>
										</td>
		              	<td>
		              		<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#borrar{{$carta->id}}">
										  	Borrar
											</button>
											<div class="modal fade modal-danger" id="borrar{{$carta->id}}" tabindex="-1" role="dialog"
												aria-labelledby="myModalLabel" aria-hidden="true">
											  	<div class="modal-dialog">
												    <div class="modal-content">
												      	<div class="modal-header">
													        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													          <span aria-hidden="true">&times;</span></button>
													        <h4 class="modal-title">Borrar carta</h4>
												      	</div>
												      	{{Form::open(array('url'=>'carta/borrar/'.$carta->id, 'method'=>'delete'))}}
													      	<div class="modal-body">
										                <div class="form-group">
										                	<label>Está a punto de eliminar el carta "{{$carta->codigo}}". Esta acción quitará
										                		la sanción o amonestación de la historia del personal de trabajo.</label>
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
		            @endif
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
    	$('#cartas').dataTable({            
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