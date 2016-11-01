@extends('plantilla')

@section('titulo')
Numeración | Inicio
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
    Numeración
    <small>inicio</small>
	</h1>
	<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Numeración</a></li>
    <li class="active">Inicio</li>
	</ol>
</section>
<section class="content">
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
	              	<th>Cartas</th>
	              	<th>Memorandums</th>
	              	<th>Informes</th>
	              	<th>Nombre de Año</th>
		            </tr>
	            </thead>
	            <tbody>
	            	@foreach($empresas as $empresa)
			            <tr>
		              	<td>{{$empresa->ruc}}</td>
		              	<td>{{$empresa->nombre}}</td>
		              	<td>
		              		<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#cartas{{$empresa->ruc}}">
										  	Cartas
											</button>
											<div class="modal fade modal-warning" id="cartas{{$empresa->ruc}}" tabindex="-1" role="dialog"
												aria-labelledby="myModalLabel" aria-hidden="true">
											  	<div class="modal-dialog">
												    <div class="modal-content">
												      	<div class="modal-header">
													        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													          <span aria-hidden="true">&times;</span></button>
													        <h4 class="modal-title">Numeración de las cartas de la Empresa</h4>
												      	</div>
												      	{{Form::open(array('url'=>'numeracion/cartas/'.$empresa->ruc, 'class'=>'form-horizontal', 'method'=>'post'))}}
													      	<div class="modal-body">
										                <p>
										                	Se le comunica que al cambiar una nueva numeración en la cartas se borrarán todas las
										                	cartas ingresadas anteriormente y comenzará con una nueva numeración. Por tanto se le
										                	pide su confirmación mediante su password.
										                </p>
										                <div class="form-group">
									                  	{{Form::label(null, 'Numeración:', array('class'=>'col-sm-2 control-label'))}}
									                  	<div class="col-sm-10">
									                  		{{Form::text('numeracion', null, array('class'=>'form-control', 'placeholder'=>'NUMERACION',
									                  		'required'=>''))}}
									                  	</div>
										                </div>
										                <div class="form-group">
									                  	{{Form::label(null, 'Password:', array('class'=>'col-sm-2 control-label'))}}
									                  	<div class="col-sm-10">
									                  		{{Form::password('password', array('class'=>'form-control', 'placeholder'=>'PASSWORD',
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
		              		<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#memorandums{{$empresa->ruc}}">
									  	Memorandums
											</button>
											<div class="modal fade modal-warning" id="memorandums{{$empresa->ruc}}" tabindex="-1" role="dialog"
												aria-labelledby="myModalLabel" aria-hidden="true">
											  	<div class="modal-dialog">
												    <div class="modal-content">
												      	<div class="modal-header">
													        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													          <span aria-hidden="true">&times;</span></button>
													        <h4 class="modal-title">Numeración de los Memorandums de la Empresa {{$empresa->nombre}}</h4>
												      	</div>
												      	{{Form::open(array('url'=>'numeracion/memorandums/'.$empresa->ruc, 'class'=>'form-horizontal', 'method'=>'post'))}}
													      	<div class="modal-body">
										                <p>
										                	Se le comunica que al cambiar una nueva numeración en los memorandums se borrarán todos
										                	los memorandums ingresados anteriormente y comenzará una nueva numeración. Por tanto se 
										                	le pide su confirmación mediante su password.
										                </p>
										                <div class="form-group">
									                  	{{Form::label(null, 'Numeración:', array('class'=>'col-sm-2 control-label'))}}
									                  	<div class="col-sm-10">
									                  		{{Form::text('numeracion', null, array('class'=>'form-control', 'placeholder'=>'NUMERACION',
									                  		'required'=>''))}}
									                  	</div>
										                </div>
										                <div class="form-group">
									                  	{{Form::label(null, 'Password:', array('class'=>'col-sm-2 control-label'))}}
									                  	<div class="col-sm-10">
									                  		{{Form::password('password', array('class'=>'form-control', 'placeholder'=>'PASSWORD',
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
		              		<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#informes{{$empresa->ruc}}">
									  	Informes
											</button>
											<div class="modal fade modal-warning" id="informes{{$empresa->ruc}}" tabindex="-1" role="dialog"
												aria-labelledby="myModalLabel" aria-hidden="true">
											  	<div class="modal-dialog">
												    <div class="modal-content">
												      	<div class="modal-header">
													        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													          <span aria-hidden="true">&times;</span></button>
													        <h4 class="modal-title">Numeración de los Informes de la Empresa {{$empresa->nombre}}</h4>
												      	</div>
												      	{{Form::open(array('url'=>'numeracion/informes/'.$empresa->ruc, 'class'=>'form-horizontal', 'method'=>'post'))}}
													      	<div class="modal-body">
										                <p>
										                	Se le comunica que al cambiar una nueva numeración en los informes se borrarán todos
										                	los informes ingresados anteriormente y comenzará una nueva numeración. Por tanto se 
										                	le pide su confirmación mediante su password.
										                </p>
										                <div class="form-group">
									                  	{{Form::label(null, 'Numeración:', array('class'=>'col-sm-2 control-label'))}}
									                  	<div class="col-sm-10">
									                  		{{Form::text('numeracion', null, array('class'=>'form-control', 'placeholder'=>'NUMERACION',
									                  		'required'=>''))}}
									                  	</div>
										                </div>
										                <div class="form-group">
									                  	{{Form::label(null, 'Password:', array('class'=>'col-sm-2 control-label'))}}
									                  	<div class="col-sm-10">
									                  		{{Form::password('password', array('class'=>'form-control', 'placeholder'=>'PASSWORD',
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
		              		<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#anio{{$empresa->ruc}}">
									  	Nombre de Año
											</button>
											<div class="modal fade modal-warning" id="anio{{$empresa->ruc}}" tabindex="-1" role="dialog"
												aria-labelledby="myModalLabel" aria-hidden="true">
											  	<div class="modal-dialog">
												    <div class="modal-content">
												      	<div class="modal-header">
													        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													          <span aria-hidden="true">&times;</span></button>
													        <h4 class="modal-title">Nombre de año para la Empresa {{$empresa->nombre}}</h4>
												      	</div>
												      	{{Form::open(array('url'=>'numeracion/anio/'.$empresa->ruc, 'class'=>'form-horizontal', 'method'=>'post'))}}
													      	<div class="modal-body">
										                <p>
										                	Se le comunica que al cambiar el nombre del año solo tomará efecto a partir de la edición 
										                	de los nuevos documentos, los documentos antiguos seguiran con el nombre del año que se le
										                	había configurado enteriormente. Por tanto se le pide su confirmación mediante su password.
										                </p>
										                <div class="form-group">
									                  	{{Form::label(null, 'Nombre:', array('class'=>'col-sm-2 control-label'))}}
									                  	<div class="col-sm-10">
									                  		{{Form::text('anio', null, array('class'=>'form-control mayuscula', 'placeholder'=>'NOMBRE DEL AÑO',
									                  		'required'=>''))}}
									                  	</div>
										                </div>
										                <div class="form-group">
									                  	{{Form::label(null, 'Password:', array('class'=>'col-sm-2 control-label'))}}
									                  	<div class="col-sm-10">
									                  		{{Form::password('password', array('class'=>'form-control', 'placeholder'=>'PASSWORD',
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