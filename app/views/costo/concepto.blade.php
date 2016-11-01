<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Estructura de Costos Detallado</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=URL::to('bootstrap/css/bootstrap.min.css')?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
	<div class="row">
	  <div class="col-md-12">
	    <div class="box">
	      <div class="box-header">
	        <h3 class="box-title">ESTRUCTURA DE COSTOS DETALLADO Nº {{$concepto->id}}</h3>
	      </div>
	      <div class="box-body no-padding">
	        <div class="embed-responsive embed-responsive-16by9">
	          <iframe class="embed-responsive-item"
	            src="<?=URL::to('documentos/costos/'.$concepto->costo->empresa_ruc.'/detalles/'
	            .$concepto->id.'.pdf')?>">
	          </iframe>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>

<!-- jQuery 2.2.3 -->
<script src="<?=URL::to('plugins/jQuery/jquery-2.2.3.min.js')?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=URL::to('bootstrap/js/bootstrap.min.js')?>"></script>
</body>
</html>
