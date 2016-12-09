<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('titulo')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=URL::to('bootstrap/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=URL::to('dist/css/AdminLTE.min.css')?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=URL::to('dist/css/skins/_all-skins.min.css')?>">

  <style type="text/css">
    .mayuscula{
      text-transform: uppercase;
    }
  </style>
  @yield('estilos')

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?=URL::to('usuario/panel')?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>GM</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SISGEM</b> 1.0</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tienes una alerta</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 licencias expiradas.
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 licencias por expirar.
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">Ver todos</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=URL::to('dist/img/user2-160x160.jpg')?>" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Auth::user()->persona->nombre}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=URL::to('dist/img/user2-160x160.jpg')?>" class="img-circle" alt="User Image">

                <p>
                  {{Auth::user()->persona->nombre}} - Administrador
                  <small><optgroup></optgroup></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=URL::to('usuario/contrasenia')?>" class="btn btn-default btn-flat">Cambiar Contraseña</a>
                </div>
                <div class="pull-right">
                  <a href="<?=URL::to('usuario/salir')?>" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=URL::to('dist/img/user2-160x160.jpg')?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->persona->nombre}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu">
        @if(Auth::user()->nivel == 0)
          <li class="header">MENU ADMINISTRADOR</li>
          <li>
            <a href="<?=URL::to('empresa')?>">
              <i class="fa fa-bank"></i> <span>Empresas</span>
            </a>
          </li>
          <li>
            <a href="<?=URL::to('usuario/inicio')?>">
              <i class="fa fa-user"></i> <span>Usuarios</span>
            </a>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-briefcase"></i> <span>Clientes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('cliente/inicio/'.$empresa->ruc)?>"><i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Contratos</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('contrato/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-users"></i> <span>Personal</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('trabajador/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-users"></i> <span>Asistencia</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('asistencia/reporte/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-money"></i> <span>Pagos *</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('pago/reporte/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-money"></i> <span>Descuentos</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('trabajador/descuentos/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-gears"></i> <span>Herramientas *</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="#">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-user"></i> <span>Uniformes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('prenda/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Memorandums</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('memorandum/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Cartas</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('carta/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Informes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('informe/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Estructura de costos</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('costo/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Emisión de recibos *</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="#">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-gear"></i> <span>Configuración</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?=URL::to('documento')?>"><i class="fa fa-circle-o"></i> 
                Documentos</a></li>
              <li><a href="<?=URL::to('cargo')?>"><i class="fa fa-circle-o"></i> 
                Cargos</a></li>
              <li><a href="<?=URL::to('area')?>"><i class="fa fa-circle-o"></i> 
                Areas</a></li>
              <li><a href="<?=URL::to('tipoMemorandum')?>"><i class="fa fa-circle-o"></i> 
                Tipo Memorandums</a></li>
              <li><a href="<?=URL::to('turno')?>"><i class="fa fa-circle-o"></i> 
                Turnos</a></li>
              <li><a href="<?=URL::to('descuento')?>"><i class="fa fa-circle-o"></i> 
                Descuentos</a></li>
            </ul>
          </li>
        @elseif(Auth::user()->nivel == 1)
          <li class="header">MENU USUARIO</li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Memorandums</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('memorandum/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Cartas</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('carta/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Informes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('informe/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Estructura de costos</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('costo/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
        @elseif(Auth::user()->nivel == 2)
          <li class="header">MENU ASISTENTE</li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-briefcase"></i> <span>Clientes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('cliente/inicio/'.$empresa->ruc)?>"><i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Contratos</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('contrato/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-users"></i> <span>Personal</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('trabajador/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Memorandums</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('memorandum/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Cartas</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('carta/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Informes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('informe/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span>Estructura de costos</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @foreach(Empresa::all() as $empresa)
              <li><a href="<?=URL::to('costo/inicio/'.$empresa->ruc)?>">
                <i class="fa fa-circle-o"></i> {{$empresa->nombre}}</a></li>
              @endforeach
            </ul>
          </li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Aqui va el contenido de la página -->
  <div class="content-wrapper">
  @yield('contenido')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
  	<div class="row">
	    <div class="pull-right hidden-xs">
	      <b>Version</b> 0.4
	    </div>
	    <strong>Copyright &copy; 2016 <a href="http://sipromsac.com" target="_blank">SIPROM</a>.</strong> Derechos reservados.
  	</div>
  	<div class="row">
	    <div class="pull-right hidden-xs">
	      <b>Version</b> 2.3.6
	    </div>
	    <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com" target="_blank">Almsaeed Studio</a>.</strong> All rights
	    reserved.
  	</div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?=URL::to('plugins/jQuery/jquery-2.2.3.min.js')?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=URL::to('bootstrap/js/bootstrap.min.js')?>"></script>
<!-- SlimScroll -->
<script src="<?=URL::to('plugins/slimScroll/jquery.slimscroll.min.js')?>"></script>
<!-- FastClick -->
<script src="<?=URL::to('plugins/fastclick/fastclick.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?=URL::to('dist/js/app.min.js')?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=URL::to('dist/js/demo.js')?>"></script>
<!-- InputMask -->
<script src="<?=URL::to('plugins/input-mask/jquery.inputmask.js')?>"></script>
<script src="<?=URL::to('plugins/input-mask/jquery.inputmask.date.extensions.js')?>"></script>
<script src="<?=URL::to('plugins/input-mask/jquery.inputmask.extensions.js')?>"></script>

<script src="<?=URL::to('plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?=URL::to('plugins/datatables/dataTables.bootstrap.min.js')?>"></script>
@yield('scripts')
</body>
</html>
