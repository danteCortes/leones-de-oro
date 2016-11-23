@extends('plantilla')

@section('titulo')
Contratos | Inicio
@stop

@section('estilos')
<link rel="stylesheet" href="<?=URL::to('plugins/datatables/dataTables.bootstrap.css')?>">
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Contratos
    <small>inicio</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Contratos</a></li>
    <li class="active">Inicio</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <a class="btn btn-primary" href="<?=URL::to('contrato/nuevo/'.$empresa->ruc)?>">
        <i class="fa fa-plus-square"></i> Nuevo Contrato
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
          <h3 class="box-title">Contratos de {{$empresa->nombre}}</h3>
        </div>
        <div class="box-body">
          <table id="contratos" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>RUC</th>
                <th>Razón Social</th>
                <th>Mostrar</th>
                <th>Editar</th>
                <th>Borrar</th>
              </tr>
            </thead>
            <tbody>
              @foreach($contratos as $contrato)
                <tr>
                  <td>{{$contrato->cliente->ruc}}</td>
                  <td>{{$contrato->cliente->nombre}}</td>
                  <td><a href="<?=URL::to('contrato/mostrar/'.$contrato->id)?>" class="btn btn-warning btn-xs">Mostrar</a>
                  </td>
                  <td>
                    <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#editar{{$contrato->id}}">
                    Editar
                    </button>
                    <div class="modal fade modal-info" id="editar{{$contrato->id}}" tabindex="-1" role="dialog"
                      aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Editar Contrato con {{$contrato->cliente->nombre}}</h4>
                          </div>
                          {{Form::open(array('url'=>'contrato/editar/'.$contrato->id, 'method'=>'put'))}}
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-xs-12">
                                  <div class="row">
                                    <div class="col-xs-12">
                                      {{Form::label(null, 'Inicio*:', array('class'=>'control-label col-xs-2'))}}
                                      <div class="col-xs-10">
                                        {{Form::text('inicio', date('d-m-Y', strtotime($contrato->inicio)), 
                                          array('class'=>'form-control input-sm', 'data-inputmask'=>"'alias': 'dd/mm/yyyy'", 
                                          'data-mask'=>'', 'required'=>''))}}
                                      </div>
                                    </div>
                                  </div><br>
                                  <div class="row">
                                    <div class="col-xs-12">
                                      {{Form::label(null, 'Fin*:', array('class'=>'control-label col-xs-2'))}}
                                      <div class="col-xs-10">
                                        {{Form::text('fin', date('d-m-Y', strtotime($contrato->fin)), 
                                          array('class'=>'form-control input-sm', 'data-inputmask'=>"'alias': 'dd/mm/yyyy'", 
                                          'data-mask'=>'', 'required'=>''))}}
                                      </div>
                                    </div>
                                  </div><br>
                                  <div class="row">
                                    <div class="col-xs-12">
                                      {{Form::label(null, 'Total*:', array('class'=>'control-label col-xs-2'))}}
                                      <div class="col-xs-10">
                                        {{Form::text('total', $contrato->total, array('class'=>'form-control input-sm precio',
                                          'required'=>''))}}
                                      </div>
                                    </div>
                                  </div><br>
                                  <div class="row">
                                    <div class="col-xs-12">
                                      {{Form::label(null, 'IGV:', array('class'=>'control-label col-xs-2'))}}
                                      <div class="col-xs-10">
                                        <div class="checkbox">
                                          <label>
                                            @if($contrato->igv)
                                              {{Form::checkbox('igv', 1, 1)}}
                                            @else
                                              {{Form::checkbox('igv', 1, 0)}}
                                            @endif
                                          </label>
                                        </div>
                                      </div>
                                    </div>
                                  </div><br>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer clearfix">
                              <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
                              <button type="submit" class="btn btn-outline pull-left">Guardar</button>
                              <button type="reset" class="btn btn-outline pull-left">Limpiar</button>
                            </div>
                          {{Form::close()}}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#borrar{{$contrato->id}}">
                      Borrar
                    </button>
                    <div class="modal fade modal-danger" id="borrar{{$contrato->id}}" tabindex="-1" role="dialog"
                      aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Borrar Contrato</h4>
                              </div>
                              {{Form::open(array('url'=>'contrato/borrar/'.$contrato->id, 'class'=>'', 'method'=>'delete'))}}
                                <div class="modal-body">
                                      <div class="form-group">
                                        <label>Está a punto de eliminar el contrato con "{{$contrato->cliente->nombre}}". 
                                            Todos los documentos asociados a este contrato serán borrados.<br></label>
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
<script>
    $(function () {
      $('#contratos').dataTable({            
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