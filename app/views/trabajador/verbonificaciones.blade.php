@extends('plantilla')

@section('titulo')
Trabajador | Bonificaciones
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
      Bonificaciones
      <small>{{$trabajador->persona->nombre}} {{$trabajador->persona->apellidos}}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="#">Trabajador</a></li>
      <li class="active">Bonificaciones</li>
    </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <a class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
        <i class="fa fa-plus-square"></i> Nueva Bonificación
      </a>
      <div class="modal fade modal-primary" id="nuevo" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva Bonificación para {{$trabajador->persona->nombre}}
                  {{$trabajador->persona->apellidos}}</h4>
              </div>
              {{Form::open(array('url'=>'trabajador/bonificar/'.$trabajador->id, 'class'=>'form-horizontal', 'method'=>'post'))}}
                <div class="modal-body">
                  <div class="form-group">
                    {{Form::label(null, 'Bonificación*:', array('class'=>'col-sm-3 control-label'))}}
                    <div class="col-sm-9">
                      <select name="bonificacion_id" class="form-control input-sm" required="">
                        <option value="">SELECCIONAR</option>
                        @foreach(Bonificacion::all() as $bonificacion)
                          <option value="{{$bonificacion->id}}">{{$bonificacion->nombre}}</option>
                        @endforeach
                      </select>
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
      <div class="col-xs-8">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Bonificaciones de {{$trabajador->persona->nombre}}
                {{$trabajador->persona->apellidos}}</h3>
            </div>
            <div class="box-body">
              <table id="trabajadores" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Borrar</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach(BonificacionTrabajador::where('trabajador_id', '=', $trabajador->id)->get() as $bonificacion)
                    <tr>
                      <td>{{$bonificacion->bonificacion->nombre}}</td>
                      <td>
                        @if($bonificacion->bonificacion->porcentaje)
                          S/ {{number_format($trabajador->sueldo*$bonificacion->bonificacion->porcentaje/100, 2, '.', ' ')}}
                        @elseif($bonificacion->bonificacion->fijo)
                          S/ {{number_format($bonificacion->bonificacion->fijo, 2, '.', ' ')}}
                        @endif
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#borrar{{$bonificacion->id}}">
                          Borrar
                        </button>
                        <div class="modal fade modal-danger" id="borrar{{$bonificacion->id}}" tabindex="-1" role="dialog"
                          aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Borrar Bonificacion</h4>
                              </div>
                              {{Form::open(array('url'=>'trabajador/borrar-bonificacion/'.$bonificacion->id, 'class'=>'', 'method'=>'delete'))}}
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label>Está a punto de eliminar la bonificación del trabajador "{{$trabajador->persona->nombre}} 
                                      {{$trabajador->persona->apellidos}}".</label>
                                  </div>
                                  <div class="form-group">
                                    <label>Para confirmar esta acción se necesita su contraseña, de lo contrario pulse cancelar para
                                      declinar.</label>
                                    {{Form::password('password', array('class'=>'form-control input-sm', 'placeholder'=>'PASSWORD',
                                    'required'=>''))}}
                                  </div>
                                </div>
                                <div class="modal-footer clearfix">
                                  {{Form::hidden('trabajador_id', $trabajador->id)}}
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
<script>
    $(function () {
      //Datatable con traducción
      $('#trabajadores').dataTable({            
            "oLanguage": {
                "oPaginate": {
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior",                            
                },
                "sSearch": "Buscar" ,
                "sInfo": " Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sLengthMenu": "Mostrar _MENU_ resultados por página",
                "sInfoFiltered": " - filtrando de _MAX_ resultados"
            }
        });
        //fecha dd/mm/yyyy
      $("[data-mask]").inputmask();
    });
</script>
@stop