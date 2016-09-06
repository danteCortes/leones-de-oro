@extends('plantilla')

@section('titulo')
Trabajador | Ver
@stop

@section('contenido')
<section class="content-header">
  	<h1>
	    Trabajador
	    <small>mostrar</small>
  	</h1>
  	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
	    <li><a href="#">Trabajador</a></li>
	    <li class="active">Mostrar</li>
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
	    <div class="col-md-6">
	      	<div class="box">
		        <div class="box-header">
		          	<h3 class="box-title">Datos del Trabajador</h3><br>
		          	<img src="<?=URL::to('documentos/fotos/'.$trabajador->foto)?>"
		          		class="img-responsive center-block img-thumbnail col-xs-6 
		          		col-sm-6 col-md-6 col-lg-3">
		        </div>
		        <div class="box-body no-padding">
		          	<table class="table table-striped">
			            <tr>
			              	<th>DNI</th>
			              	<td>{{$trabajador->persona->dni}}</td>
			            </tr>
			            <tr>
			              	<th>Nombre</th>
			              	<td>{{$trabajador->persona->nombre}}</td>
			            </tr>
			            <tr>
			              	<th>Apellidos</th>
			              	<td>{{$trabajador->persona->apellidos}}</td>
			            </tr>
			            <tr>
			              	<th>Dirección</th>
			              	<td>{{$trabajador->persona->direccion}}</td>
			            </tr>
			            <tr>
			              	<th>Teléfono</th>
			              	<td>{{$trabajador->persona->telefono}}</td>
			            </tr>
			            <tr>
			              	<th>inicio</th>
			              	<td>{{date('d-m-Y', strtotime($trabajador->inicio))}}</td>
			            </tr>
			            <tr>
			              	<th>Fin</th>
			              	<td>{{date('d-m-Y', strtotime($trabajador->fin))}}</td>
			            </tr>
			            <tr>
			              	<th>Nro Cuenta</th>
			              	<td>{{$trabajador->cuenta}}</td>
			            </tr>
			            <tr>
			              	<th>Banco</th>
			              	<td>{{$trabajador->banco}}</td>
			            </tr>
		          	</table>
		        </div>
	      	</div>
	      	<a href="<?=URL::to('trabajador/inicio/'.$empresa->ruc)?>" class="btn btn-primary">
	      		Volver a {{$empresa->nombre}}</a>
	    </div>
	    <div class="col-md-6">
	    	<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Documento</h3>
            </div>
            {{Form::open(array('url'=>'trabajador/documentar', 'files'=>true))}}
              	<div class="box-body">
	                <div class="form-group">
	                  	{{Form::label(null, 'Tipo:*', array('class'=>'control-label'))}}
	                  	<select name="documento_id" class="form-control" required>
	                  		<option value="">SELECCIONAR</option>
	                  		@foreach(Documento::all() as $documento)
	                  			<option value="{{$documento->id}}">{{$documento->nombre}}</option>
	                  		@endforeach
	                  	</select>
	                </div>
	                <div class="form-group">
	                  	{{Form::label(null, 'Archivo:*', array('class'=>'control-label'))}}
	                  	{{Form::file('archivo', array('required'=>''))}}
	                </div>
              	</div>
              	<div class="box-footer">
              		{{Form::hidden('trabajador_id', $trabajador->id)}}
                	<button type="submit" class="btn btn-primary">Agregar</button>
              	</div>
            {{Form::close()}}
          </div>
	    </div>
  	</div>
  	<div class="row">
	    <div class="col-md-12">
	      	<div class="box">
		        <div class="box-header">
		          	<h3 class="box-title">Documentos</h3>
		        </div>
		        <div class="box-body no-padding">
		          	<table class="table table-striped">
		          		@foreach($trabajador->documentos as $documento)
			            <tr>
			            	<table class="table">
			            		<tr>
					              	<th>{{$documento->nombre}}</th>
					              	<td><a href="<?=URL::to('documentos/documentos/'.$documento->pivot->nombre)?>" 
					              		class="btn btn-warning btn-xs pull-right">Ver</a> </td>
			            		</tr>
			            		<tr>
			            			<td colspan="2	">
							            <div class="embed-responsive embed-responsive-16by9">
										  <iframe class="embed-responsive-item" src="<?=URL::to('documentos/documentos/'.$documento->pivot->nombre)?>"></iframe>
										</div>
			            			</td>
			            		</tr>
			            	</table>
			            </tr>
			            @endforeach
		          	</table>
		        </div>
	      	</div>
	    </div>
  	</div>
</section>
@stop