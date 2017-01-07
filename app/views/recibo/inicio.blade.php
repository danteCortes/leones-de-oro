@extends('plantilla')

@section('titulo')
Recibos | Inicio
@stop

@section('contenido')
<section class="content-header">
	<h1>
		Recibos
		<small>inicio</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li><a href="#">Recibos</a></li>
		<li class="active">Inicio</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<a class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
				<i class="fa fa-plus-square"></i> Factura
			</a>
			<a class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
				<i class="fa fa-plus-square"></i> Boleta
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
						<h3 class="box-title">Recibos de {{$empresa->nombre}}</h3>
					</div>
					<div class="box-body">
						<table id="clientes" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Número</th>
									<th>Tipo</th>
									<th>Mostrar</th>
									<th>Editar</th>
									<th>Borrar</th>
								</tr>
							</thead>
							<tbody>
								
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