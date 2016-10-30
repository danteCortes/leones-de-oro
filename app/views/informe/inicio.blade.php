@extends('plantilla')

@section('titulo')
Informe | Inicio
@stop

@section('estilos')
<link rel="stylesheet" href="<?=URL::to('plugins/datatables/dataTables.bootstrap.css')?>">
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Informes de {{$empresa->nombre}}
    <small>inicio</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Informes</a></li>
    <li class="active">Inicio</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <a class="btn btn-primary" href="<?=URL::to('informe/nuevo/'.$empresa->ruc)?>">
          <i class="fa fa-plus-square"></i> Nuevo Informe
        </a>
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
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Informes de {{$empresa->nombre}}</h3>
        </div>
        <div class="box-body">
          <table id="informes" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Informe</th>
                <th>Remitente</th>
                <th>Destinatario</th>
                <th>Redactor</th>
                <th>Mostrar</th>
                <th>Editar</th>
                <th>Borrar</th>
              </tr>
            </thead>
            <tbody>
              @foreach($informes as $informe)
                @if($informe->usuario_id)
                  <tr>
                    <td>{{$informe->codigo}}</td>
                    <td>{{$informe->remite}}</td>
                    <td>{{$informe->destinatario}}</td>
                    <td>{{Usuario::find($informe->usuario_id)->persona->nombre}}</td>
                    <td><a href="<?=URL::to('informe/mostrar/'.$informe->id)?>" class="btn btn-warning btn-xs">Mostrar</a>
                    </td>
                    <td>
                      <a class="btn btn-primary btn-xs" href="<?=URL::to('informe/editar/'.$informe->id)?>">
                        Editar
                      </a>
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#borrar{{$informe->id}}">
                        Borrar
                      </button>
                      <div class="modal fade modal-danger" id="borrar{{$informe->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Borrar informe</h4>
                              </div>
                              {{Form::open(array('url'=>'informe/borrar/'.$informe->id, 'method'=>'delete'))}}
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label>Está a punto de eliminar el informe "{{$informe->codigo}}". Esta acción quitará
                                      el informe de la lista y no podra ser vista o impresa.</label>
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
                @endif
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
    $('#informes').dataTable({            
      "oLanguage": {
        "oPaginate": {
          "sNext": "Siguiente",
          "sPrevious": "Anterior",                            
        },
        "sSearch": "Buscar",
        "sInfo": " Mostrando _START_ a _END_ de _TOTAL_ registros",
        "sLengthMenu": "Mostrar _MENU_ resultados por página",
        "sInfoFiltered": " - filtrando de _MAX_ resultados"
      }
    });
  });
</script>
@stop