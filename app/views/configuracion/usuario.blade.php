<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración | Primer Usuario</title>
    <!-- Bootstrap -->
    <link href="<?=URL::to('css/bootstrap.min.css')?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
    	.mayuscula{
    		text-transform: uppercase;
    	}
    </style>
</head>
<body>
	<div class="container">
		<div class="col-sm-12">
		  	<div class="row">
		  		<div class="page-header">
					<h1>Sistema de Gestión Administrativa Leones <small>Configuración</small></h1>
		  		</div>
		  	</div>
		  	<div class="row">
		  		<div class="jumbotron">
		  			<h2>Administrador</h2>
			  		<p>
			  			Es hora de gestionar nuestros procesos de todas las empresas. Entonces primero guardaremos
			  			nuestros datos personales para registrarnos como administradores del sistema, para esto
			  			rellene los campos del formulario, escoja una empresa y de clic en siguiente para terminar.
			  		</p>
		  		</div>
		  	</div>
		  	<div class="row">
		  		<div class="col-sm-6">
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
		  			<div class="panel panel-default">
		  				<div class="panel-body">
		  					{{Form::open(array('url'=>'configuracion/usuario', 'class'=>'form-horizontal'))}}
		  						<div class="form-group">
		  							{{Form::label('dni', 'DNI:', array('class'=>'col-sm-2 control-label'))}}
		  							<div class="col-sm-10">
		  								{{Form::text('dni', null, array('class'=>'form-control input-sm dni', 
		  									'placeholder'=>'DNI', 'required'=>'', 'id'=>'dni'))}}
		  							</div>
		  						</div>
		  						<div class="form-group">
		  							{{Form::label('nombre', 'Nombre:', array('class'=>'col-sm-2 control-label'))}}
		  							<div class="col-sm-10">
		  								{{Form::text('nombre', null, array('class'=>'form-control input-sm mayuscula', 
		  									'placeholder'=>'NOMBRE', 'required'=>''))}}
		  							</div>
		  						</div>
		  						<div class="form-group">
		  							{{Form::label('apellidos', 'Apellidos:', array('class'=>'col-sm-2 control-label'))}}
		  							<div class="col-sm-10">
		  								{{Form::text('apellidos', null, array('class'=>'form-control input-sm mayuscula', 
		  									'placeholder'=>'APELLIDOS', 'required'=>''))}}
		  							</div>
		  						</div>
		  						<div class="form-group">
		  							{{Form::label('direccion', 'Dirección:', array('class'=>'col-sm-2 control-label'))}}
		  							<div class="col-sm-10">
		  								{{Form::text('direccion', null, array('class'=>'form-control input-sm mayuscula', 
		  									'placeholder'=>'DIRECCION'))}}
		  							</div>
		  						</div>
		  						<div class="form-group">
		  							{{Form::label('telefono', 'Teléfono:', array('class'=>'col-sm-2 control-label'))}}
		  							<div class="col-sm-10">
		  								{{Form::text('telefono', null, array('class'=>'form-control input-sm', 
		  									'placeholder'=>'TELEFONO', 'id'=>'telefono'))}}
		  							</div>
		  						</div>
		  						<div class="form-group">
		  							{{Form::label('password', 'Password:', array('class'=>'col-sm-2 control-label'))}}
		  							<div class="col-sm-10">
		  								{{Form::password('password', array('class'=>'form-control input-sm', 
		  									'placeholder'=>'Password', 'required'=>''))}}
		  							</div>
		  						</div>
		  						<div class="form-group">
		  							{{Form::label('confirmar', 'Confirmar:', array('class'=>'col-sm-2 control-label'))}}
		  							<div class="col-sm-10">
		  								{{Form::password('confirmar', array('class'=>'form-control input-sm', 
		  									'placeholder'=>'CONFIRMAR', 'required'=>''))}}
		  							</div>
		  						</div>
		  						<div class="form-group">
								    <div class="col-sm-offset-2 col-sm-10">
								      	{{Form::button('Siguiente', array('class'=>'btn btn-primary', 'type'=>'submit'))}}
								    </div>
								</div>
		  					{{Form::close()}}
		  				</div>
		  			</div>
		  		</div>
		  	</div>
		</div>
	</div>
	<!-- Plugin jQuery Inputmask -->
    <script src="<?=URL::to('plugins/input-mask/jquery.inputmask.js')?>" type="text/javascript"></script>
    <script src="<?=URL::to('plugins/input-mask/jquery.inputmask.date.extensions.js')?>" type="text/javascript"></script>
	<script src="<?=URL::to('plugins/input-mask/jquery.inputmask.extensions.js')?>" type="text/javascript"></script>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=URL::to('plugins/jQuery/jquery-2.2.3.min.js')?>" type="text/javascript"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=URL::to('js/bootstrap.min.js')?>" type="text/javascript"></script>
</body>
</html>