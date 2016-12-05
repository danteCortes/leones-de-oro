@extends('plantilla')

@section('titulo')
Descuentos | Inicio
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
    Descuentos
    <small>{{$empresa->nombre}}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Descuentos</a></li>
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
                    <th>Descontar</th>
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
                      <a href="<?=URL::to('trabajador/ver-descuentos/'.$trabajador->id)?>" class="btn btn-warning btn-xs">Ver</a>
                    </td>
                    <td>
                      <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#borrar{{$trabajador->id}}">
                        Descontar
                      </button>
                      <div class="modal fade modal-success" id="borrar{{$trabajador->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Descontar a Trabajador {{$trabajador->persona->nombre}}
                                    {{$trabajador->persona->apellidos}}</h4>
                                </div>
                                  <div class="modal-body">
                                    {{Form::open(array('url'=>'trabajador/descontar/'.$trabajador->id, 'class'=>'form-horizontal', 'method'=>'post'))}}
                                      <div class="row">
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                            {{Form::label(null, 'Descuento*:', array('class'=>'control-label col-sm-3'))}}
                                            <div class="col-sm-9">
                                              <select class="form-control input-sm" name="descuento_id" required="">
                                                <option value="">SELECCIONAR</option>
                                                @foreach(Descuento::all() as $descuento)
                                                  <option value="{{$descuento->id}}">{{$descuento->nombre}}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                      </div><br>
                                      <div class="row">
                                        <div class="col-sm-12">
                                        <div class="form-group">
                                          <label class="control-label col-sm-3">Monto*:</label>
                                          <div class="col-sm-9">
                                            {{Form::text('monto', null, array('class'=>'form-control input-sm', 'placeholder'=>'MONTO',
                                            'required'=>''))}}
                                          </div>
                                        </div>
                                        </div>
                                      </div><br>
                                      <div class="row">
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                            {{Form::label(null, 'Descripción', array('class'=>'control-label col-sm-3'))}}
                                            <div class="col-sm-9">
                                              {{Form::textarea('descripcion', null, array('class'=>'form-control input-sm'))}}
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="modal-footer clearfix">
                                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-outline pull-left">Descontar</button>
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