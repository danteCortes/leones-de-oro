<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración | Primera Empresa</title>
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
		  			<h2>Bienvenido</h2>
			  		<p>Le ayudaremos en sus primeros pasos por su nuevo sistema de gestión
			  			administrativa, en donde usted y otros usuarios de su empresa podrán
			  			automatizar la mayoría de sus procesos, como gestionar el control de
			  			uniformes del personal, control de las armas, control de pagos al personal,
			  			supervisión de asistencia del personal de trabajo, emisión de proformas,
			  			emisión	de boletas y facturas, gestión de clientes, proveedores, y mucho más.
			  		</p>
			  		<p>
			  			Para comenzar, vamos a ingresar sus datos como administrador del sistema. 
			  			Posteriormente podrá ingresar los datos de los demás usuarios a quienes les 
			  			dará un nivel de ingreso al sistema. Entonces comencemos, de clic en siguiente.
			  		</p>
			  		<p>
			  			<a href="<?=URL::to('configuracion/usuario')?>" class="btn btn-primary">Siguiente</a>
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