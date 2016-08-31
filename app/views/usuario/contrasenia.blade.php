@extends('plantilla')

@section('titulo')
Usuario | Cambiar contraseña
@stop

@section('contenido')
<section class="content-header">
    <h1>
        Cambio de Contraseña
        <small>Usuario</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Usuario</a></li>
        <li class="active">Cambiar Contraseña</li>
    </ol>
</section>
<section class="content">
      <div class="row">
        <div class="col-md-8">
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
        	<div class="box box-info">
	            <div class="box-header with-border">
	              	<h3 class="box-title">Contraseña</h3>
	            </div>
	            {{Form::open(array('url'=>'usuario/contrasenia', 'class'=>'form-horizontal'))}}
	              	<div class="box-body">
		                <div class="form-group">
		                	{{Form::label('actual', 'Actual:', array('class'=>'col-sm-2 control-label'))}}
		                  	<div class="col-sm-10">
		                  		{{Form::password('actual', array('class'=>'form-control input-sm', 'required'=>''))}}
		                  	</div>
		                </div>
		                <div class="form-group">
		                  	{{Form::label('nueva', 'Nueva:', array('class'=>'col-sm-2 control-label'))}}
		                  	<div class="col-sm-10">
		                    	{{Form::password('nueva', array('class'=>'form-control input-sm', 'required'=>''))}}
		                  	</div>
		                </div>
		                <div class="form-group">
		                  	{{Form::label('confirmar', 'Confirmar:', array('class'=>'col-sm-2 control-label'))}}
		                  	<div class="col-sm-10">
		                    	{{Form::password('confirmar', array('class'=>'form-control input-sm', 'required'=>''))}}
		                  	</div>
		                </div>
	              	</div>
	              	<div class="box-footer">
	              		<a href="<?=URL::to('usuario/panel')?>" class="btn btn-default pull-right">Cancelar</a>
		                <button type="submit" class="btn btn-primary">Guardar</button>
	              	</div>
	            {{Form::close()}}
	        </div>
        </div>
      </div>
    </section>
@stop