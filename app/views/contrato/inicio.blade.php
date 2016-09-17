@extends('plantilla')

@section('titulo')
Contratos | Inicio
@stop

@section('estilos')
<link rel="stylesheet" href="<?=URL::to('plugins/datatables/dataTables.bootstrap.css')?>">
@stop

@section('contenido')
<section class="content-header">
  	<h1>
	    Contratos
	    <small>inicio</small>
  	</h1>
  	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
	    <li><a href="#">Contratos</a></li>
	    <li class="active">Inicio</li>
  	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
	      	<a class="btn btn-primary" href="<?=URL::to('contrato/nuevo/'.$empresa->ruc)?>">
	        	<i class="fa fa-plus-square"></i> Nuevo Contrato
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
		<div class="row">
		    <div class="col-xs-12">
		      	<div class="box">
			        <div class="box-header">
			          <h3 class="box-title">Contratos de {{$empresa->nombre}}</h3>
			        </div>
			        <div class="box-body">
			          <table id="contratos" class="table table-bordered table-striped">
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
			            	@foreach($contratos as $contrato)
					            <tr>
					              	<td>{{$contrato->cliente->ruc}}</td>
					              	<td>{{$contrato->cliente->nombre}}</td>
					              	<td><a href="<?=URL::to('contrato/mostrar/'.$contrato->id)?>" class="btn btn-warning btn-xs">Mostrar</a>
					              	</td>
					              	<td>
					              		<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#editar{{$contrato->ruc}}">
									  	Editar
										</button>
									</td>
					              	<td>
					              		<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#borrar{{$contrato->ruc}}">
									  	Borrar
										</button>
					              	</td>
					            </tr>
				            @endforeach
			            </tbody>
			          </table>
			        </div>
		      	</div>
		    </div>
	  	</div>
	</div>
</section>
@stop

@section('scripts')
<script>
  	$(function () {
    	$('#contratos').dataTable({            
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