@extends('plantilla')

@section('titulo')
Cliente | Mostrar
@stop

@section('contenido')
<section class="content-header">
  	<h1>
	    Cliente
	    <small>mostrar</small>
  	</h1>
  	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
	    <li><a href="#">Cliente</a></li>
	    <li class="active">Mostrar</li>
  	</ol>
</section>
<section class="content">
  	<div class="row">
	    <div class="col-md-9">
	      	<div class="box">
		        <div class="box-header">
		          	<h3 class="box-title">Datos del Cliente</h3>
		        </div>
		        <div class="box-body no-padding">
		          	<table class="table table-striped">
			            <tr>
			              	<th>RUC</th>
			              	<td>{{$cliente->ruc}}</td>
			            </tr>
			            <tr>
			              	<th>Razón Social</th>
			              	<td>{{$cliente->nombre}}</td>
			            </tr>
			            <tr>
			              	<th>Dirección</th>
			              	<td>{{$cliente->direccion}}</td>
			            </tr>
			            <tr>
			              	<th>Teléfono</th>
			              	<td>{{$cliente->telefono}}</td>
			            </tr>
			            <tr>
			              	<th>Contacto</th>
			              	<td>{{$cliente->contacto}}</td>
			            </tr>
		          	</table>
		        </div>
	      	</div>
	    </div>
  	</div>
  	<div class="row">
	    <div class="col-md-12">
	      	<div class="box">
		        <div class="box-header">
		          	<h3 class="box-title">Contratos</h3>
		        </div>
		        <div class="box-body no-padding">
		          	<table class="table table-striped">
			            <tr>
			              	<th>DISPONIBLE CUANDO SE HAGAN CONTRATOS...</th>
			            </tr>
		          	</table>
		        </div>
	      	</div>
	      	<a href="<?=URL::to('cliente')?>" class="btn btn-primary">Volver</a>
	    </div>
  	</div>
</section>
@stop