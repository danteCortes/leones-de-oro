@extends('plantilla')

@section('titulo')
Empresa | Inicio
@stop

@section('estilos')
<link rel="stylesheet" href="<?=URL::to('plugins/datatables/dataTables.bootstrap.css')?>">
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
				              		<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal">
								  	Edit
									</button>
								</td>
				              	<td><a href="" class="btn btn-danger btn-xs">Borrar</a></td>
				            </tr>
			            @endforeach
		            </tbody>
		          </table>
		        </div>
	      	</div>
	    </div>
  	</div>
</section>
<div class="example-modal">
	<div class="modal modal-info">
	  	<div class="modal-dialog">
		    <div class="modal-content">
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">Info Modal</h4>
		      	</div>
		      	<div class="modal-body">
		        	<p>One fine body&hellip;</p>
		      	</div>
		      	<div class="modal-footer">
			        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-outline">Save changes</button>
		      	</div>
		    </div>
	  	</div>
	</div>
</div>
@stop

@section('scripts')
<script src="<?=URL::to('plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?=URL::to('plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
<script>
	$(function () {
	    $("#empresas").DataTable({
			"oLanguage": {
				"oPaginate": {
					"sNext": "Siguiente",
					"sPrevious": "Anterior",
				},
				"sSearch": "Buscar",
				"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
				"sLengthMenu": "Mostrar _MENU_ resultados por página",
				"sInfoFiltered": " - filtrado de _MAX_ resultados"
			}
	    });
	});
</script>
@stop