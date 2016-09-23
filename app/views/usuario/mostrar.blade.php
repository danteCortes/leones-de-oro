@extends('plantilla')

@section('titulo')
Usuario | Mostrar
@stop

@section('contenido')
<section class="content-header">
  	<h1>
	    Usuario
	    <small>mostrar</small>
  	</h1>
  	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
	    <li><a href="#">Usuario</a></li>
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
	</div>
  	<div class="row">
	    <div class="col-md-6">
	      	<div class="box">
		        <div class="box-header">
		          	<h3 class="box-title">Datos del Usuario</h3>
		        </div>
		        <div class="box-body no-padding">
		          	<table class="table table-striped">
			            <tr>
			              	<th>DNI</th>
			              	<td>{{$usuario->persona->dni}}</td>
			            </tr>
			            <tr>
			              	<th>Nombre y Apellidos</th>
			              	<td>{{$usuario->persona->nombre}} {{$usuario->persona->apellidos}}</td>
			            </tr>
			            <tr>
			              	<th>Dirección</th>
			              	<td>{{$usuario->persona->direccion}}</td>
			            </tr>
			            <tr>
			              	<th>Teléfono</th>
			              	<td>{{$usuario->persona->telefono}}</td>
			            </tr>
			            <tr>
			              	<th>Nivel</th>
			              	<td>
			              		@if($usuario->nivel == 0)
			              			ADMINISTRADOR
			              		@elseif($usuario->nivel == 1)
			              			USUARIO
			              		@endif
			              	</td>
			            </tr>
		          	</table>
		        </div>
	      	</div>
	    </div>
	    <div class="col-md-6">
	      	<div class="box">
		        <div class="box-header">
		          	<h3 class="box-title">Cargos</h3>
		        </div>
		        {{Form::open(array('url'=>'usuario/area/'.$usuario->id))}}
			        <div class="box-body">
			        	<div class="form-group">
			        		{{Form::label(null, 'Empresa*:', array('class'=>'control-label'))}}
			        		<select name="empresa_ruc" class="form-control input-sm" required>
                		<option value="">SELECCIONAR</option>
                		@foreach(Empresa::all() as $empresa)
                			<option value="{{$empresa->ruc}}">{{$empresa->nombre}}</option>
                		@endforeach
                	</select>
			        	</div>
			        	<div class="form-group">
			        		{{Form::label(null, 'Area*:', array('class'=>'control-label'))}}
			        		<select name="area_id" class="form-control input-sm" required>
                		<option value="">SELECCIONAR</option>
                		@foreach(Area::all() as $area)
                			<option value="{{$area->id}}">{{$area->nombre}}</option>
                		@endforeach
                	</select>
			        	</div>
			        </div>
			        <div class="box-footer">
			        	{{Form::button('Guardar', array('class'=>'btn btn-primary', 'type'=>'submit'))}}
			        </div>
		        {{Form::close()}}
	      	</div>
	    </div>
  	</div>
  	<div class="row">
	    <div class="col-md-12">
	      	<div class="box">
		        <div class="box-header">
		          	<h3 class="box-title">Cargos</h3>
		        </div>
		        <div class="box-body no-padding">
		          	<table class="table table-striped">
			            <tr>
			              	<th>Empresa</th>
			              	<th>Area</th>
			              	<th>Borrar</th>
			            </tr>
			            @foreach($usuario->areas as $area)
			            <tr>
			            	<td>{{Empresa::find($area->pivot->empresa_ruc)->nombre}}</td>
			            	<td>{{$area->nombre}}</td>
			            	<td>
			            		{{Form::button('Borrar', array('class'=>'btn btn-danger btn-xs', 'data-toggle'=>'modal',
			            		'data-target'=>'#borrar'.$area->id))}}
			            		<div class="modal fade modal-danger" id="borrar{{$area->id}}" tabindex="-1" role="dialog"
														aria-labelledby="myModalLabel" aria-hidden="true">
													  	<div class="modal-dialog">
														    <div class="modal-content">
														      	<div class="modal-header">
															        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
															          <span aria-hidden="true">&times;</span></button>
															        <h4 class="modal-title">Borrar Area de Usuario</h4>
														      	</div>
														      	{{Form::open(array('url'=>'usuario/area/'.$area->id, 'class'=>'', 'method'=>'delete'))}}
															      	<div class="modal-body">
														                <div class="form-group">
														                	<label>Está a punto de eliminar el cargo de {{$area->nombre}} del usuario 
														                		"{{$usuario->persona->nombre}} {{$usuario->persona->apellidos}}" en la empresa
														                		{{Empresa::find($area->pivot->empresa_ruc)->nombre}}.<br></label>
														                </div>
														                <div class="form-group">
														                  	<label>Para confirmar esta acción se necesita su contraseña, de lo contrario pulse cancelar para
													                        declinar.</label>
													                        {{Form::password('password', array('class'=>'form-control input-sm', 'placeholder'=>'PASSWORD',
													                        'required'=>''))}}
													                        {{Form::hidden('usuario_id', $usuario->id)}}
													                        {{Form::hidden('empresa_ruc', $area->pivot->empresa_ruc)}}
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
		          	</table>
		        </div>
	      	</div>
	      	<a href="<?=URL::to('usuario/inicio')?>" class="btn btn-primary">Volver</a>
	    </div>
  	</div>
</section>
@stop