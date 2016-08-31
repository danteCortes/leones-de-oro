<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración | Terminar</title>
    <!-- Bootstrap -->
    <link href="<?=URL::to('css/bootstrap.min.css')?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
		  			<h2>Felicitaciones</h2>
			  		<p>
			  			Sr. {{$usuario->persona->nombre}} {{$usuario->persona->apellidos}}, Ahora ya podrá
			  			comenzar a utilizar su sistema de gestión para su empresa {{$usuario->empresa->nombre}}
			  			y demás empresas que esten en este sistema.
			  			Recuerde que puede seguir creando más empresas para ser gestionada por este sistema, así 
			  			como otros usuario a los que les dará niveles de acceso a este sistema.
			  		</p>
			  		<p>
			  			Le deseamos buena suerte y cuente con nosotros, &copy;Siprom, para despejar cualquier duda
			  			con nuestro servicio garantizado de soporte al consumidor. Ahora de clic en terminar para 
			  			que inicie sesión y comience a trabajar.
			  		</p>
			  		<p>
			  			<a href="<?=URL::to('/')?>" class="btn btn-primary">Siguiente</a>
			  		</p>
		  		</div>
		  	</div>
		</div>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.1.0.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>