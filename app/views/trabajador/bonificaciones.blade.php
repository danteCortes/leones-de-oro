@extends('plantilla')

@section('titulo')
Bonificaciones | Inicio
@stop

@section('estilos')
<link rel="stylesheet" href="<?=URL::to('plugins/datatables/dataTables.bootstrap.css')?>">
<style type="text/css">
  .mayuscula{
    text-transform: uppercase;
  }
  .modal-body .form-horizontal .col-sm-3,
  .modal-body .form-horizontal .col-sm-9 {
    width: 100%
  }

  .modal-body .form-horizontal .form-group .control-label {
    text-align: left;
  }
</style>
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Bonificaciones
    <small>{{$empresa->nombre}}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Bonificacones</a></li>
    <li class="active">Inicio</li>
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
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Trabajadores de {{$empresa->nombre}}</h3>
          </div>
          <div class="box-body">
            <table id="trabajadores" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>DNI</th>
                    <th>Trabajador</th>
                    <th>Ver</th>
                    <th>Bonificar</th>
                </tr>
              </thead>
              <tbody>
                @foreach($empresa->trabajadores as $trabajador)
                  <tr>
                    <td>{{Trabajador::find($trabajador->id)->persona->dni}}</td>
                    <td>{{Trabajador::find($trabajador->id)->persona->nombre}}
                      {{Trabajador::find($trabajador->id)->persona->apellidos}}
                    </td>
                    <td>
                      <a href="<?=URL::to('trabajador/ver-bonificaciones/'.$trabajador->id)?>" class="btn btn-warning btn-xs">Ver</a>
                    </td>
                    <td>
                      <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#borrar{{$trabajador->id}}">
                        Bonificar
                      </button>
                      <div class="modal fade modal-success" id="borrar{{$trabajador->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Bonificar a Trabajador {{$trabajador->persona->nombre}}
                                    {{$trabajador->persona->apellidos}}</h4>
                                </div>
                                  <div class="modal-body">
                                    {{Form::open(array('url'=>'trabajador/bonificar/'.$trabajador->id, 'class'=>'form-horizontal', 'method'=>'post'))}}
                                      <div class="row">
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                            {{Form::label(null, 'Bonificación*:', array('class'=>'control-label col-sm-3'))}}
                                            <div class="col-sm-9">
                                              <select class="form-control input-sm" name="bonificacion_id" required="">
                                                <option value="">SELECCIONAR</option>
                                                @foreach(Bonificacion::all() as $bonificacion)
                                                  <option value="{{$bonificacion->id}}">{{$bonificacion->nombre}}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="modal-footer clearfix">
                                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-outline pull-left">Bonificar</button>
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