@extends('plantilla')

@section('titulo')
Configuración | Turnos
@stop

@section('estilos')
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="<?=URL::to('plugins/timepicker/bootstrap-timepicker.min.css')?>">
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Configuración
    <small>Turnos</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Configuración</a></li>
    <li class="active">Turnos</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <a class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
        <i class="fa fa-plus-square"></i> Nuevo Turno
      </a>
      <div class="modal fade modal-primary" id="nuevo" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Nuevo Turno</h4>
            </div>
            {{Form::open(array('url'=>'turno', 'class'=>'form-horizontal', 'method'=>'post'))}}
              <div class="modal-body">
                <div class="form-group">
                  {{Form::label(null, 'Nombre*:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      {{Form::text('nombre', null, array('class'=>'form-control mayuscula input-sm'
                      , 'placeholder'=>'TURNO',
                      'required'=>''))}}
                    </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Entrada*:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      {{Form::text('entrada', null, array('class'=>'form-control timepicker 
                      input-sm', 'placeholder'=>'ENTRADA', 'required'=>''))}}
                    </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Salida*:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      {{Form::text('salida', null, array('class'=>'form-control timepicker 
                      input-sm', 'placeholder'=>'SALIDA', 'required'=>''))}}
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
    </div>
  </div>
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
      <div class="col-xs-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Turnos</h3>
          </div>
          <div class="box-body">
            <table id="clientes" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Turno</th>
                  <th>Entrada</th>
                  <th>Salida</th>
                  <th>Borrar</th>
                </tr>
              </thead>
              <tbody>
                @foreach($turnos as $turno)
                  <tr>
                    <td>{{$turno->id}}</td>
                    <td>{{$turno->nombre}}</td>
                    <td>{{date('h:i A', strtotime($turno->entrada))}}</td>
                    <td>{{date('h:i A', strtotime($turno->salida))}}</td>
                    <td>
                      <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#borrar{{$turno->id}}">
                        Borrar
                      </button>
                      <div class="modal fade modal-danger" id="borrar{{$turno->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Borrar Turno</h4>
                              </div>
                              {{Form::open(array('url'=>'turno/'.$turno->id, 'class'=>'', 'method'=>'delete'))}}
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label>Está a punto de eliminar el turno "{{$turno->nombre}}". Todas las asistencias
                                    que registraron los trabajadores en este turno se borraran .<br>
                                    Le recomendamos tomar medidas necesarias antes de eliminarlo.</label>
                                  </div>
                                  <div class="form-group">
                                    <label>Para confirmar esta acción se necesita su contraseña, de lo contrario pulse cancelar para
                                      declinar.</label>
                                      {{Form::password('password', array('class'=>'form-control input-sm', 'placeholder'=>'PASSWORD',
                                      'required'=>''))}}
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
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</section>
@stop

@section('scripts')
<!-- bootstrap time picker -->
<script src="<?=URL::to('plugins/timepicker/bootstrap-timepicker.min.js')?>"></script>
<script type="text/javascript">
  $(function(){
    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
@stop