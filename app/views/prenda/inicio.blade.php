@extends('plantilla')

@section('titulo')
Uniformes | Inicio
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
    Uniformes
    <small>{{$empresa->nombre}}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Uniformes</a></li>
    <li class="active">Inicio</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <a class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
        <i class="fa fa-plus-square"></i> Nueva Prenda
      </a>
      <div class="modal fade modal-primary" id="nuevo" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Nueva prenda en {{$empresa->nombre}}</h4>
            </div>
            {{Form::open(array('url'=>'prenda/nuevo', 'class'=>'form-horizontal', 
              'method'=>'post'))}}
              <div class="modal-body">
                <div class="form-group">
                  {{Form::label(null, 'Nombre*:', array('class'=>'col-sm-3 control-label'))}}
                  <div class="col-sm-9">
                    {{Form::text('nombre', null, array('class'=>'form-control mayuscula input-sm', 
                      'placeholder'=>'NOMBRE', 'required'=>''))}}
                  </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Talla*:', array('class'=>'col-sm-3 control-label'))}}
                  <div class="col-sm-9">
                    {{Form::text('talla', null, array('class'=>'form-control mayuscula input-sm',
                      'placeholder'=>'TALLA', 'required'=>''))}}
                  </div>
                </div>
              </div>
              <div class="modal-footer clearfix">
                {{Form::hidden('empresa', $empresa->ruc)}}
                <button type="submit" class="btn btn-outline pull-left">Guardar</button>
                <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
              </div>
            {{Form::close()}}
          </div>
        </div>
      </div>
      <a class="btn btn-primary" data-toggle="modal" data-target="#eliminar">
        <i class="fa fa-plus-square"></i> Eliminar Prenda
      </a>
      <div class="modal fade modal-primary" id="eliminar" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Eliminar prenda en {{$empresa->nombre}}</h4>
            </div>
            {{Form::open(array('url'=>'prenda/eliminar', 'class'=>'form-horizontal', 
              'method'=>'delete'))}}
              <div class="modal-body">
                <div class="form-group">
                  <label class="control-label col-sm-12">Sólo se podrá eliminar esta prenda si ningun trabajador tiene esta prenda 
                    y no tiene existencias en el almacen de la empresa.
                    Tome las medidas necesarias para continuar.</label>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Código*:', array('class'=>'col-sm-3 control-label'))}}
                  <div class="col-sm-9">
                    {{Form::text('codigo', null, array('class'=>'form-control mayuscula input-sm', 
                      'placeholder'=>'CÓDIGO', 'required'=>''))}}
                  </div>
                </div>
              </div>
              <div class="modal-footer clearfix">
                {{Form::hidden('empresa', $empresa->ruc)}}
                <button type="submit" class="btn btn-outline pull-left">Eliminar</button>
                <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
              </div>
            {{Form::close()}}
          </div>
        </div>
      </div>
      <a class="btn btn-primary" data-toggle="modal" data-target="#agregar">
        <i class="fa fa-plus-square"></i> Agregar Prenda
      </a>
      <div class="modal fade modal-primary" id="agregar" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Agregar prenda a {{$empresa->nombre}}</h4>
            </div>
            {{Form::open(array('url'=>'prenda/agregar', 'class'=>'form-horizontal', 
              'method'=>'post'))}}
              <div class="modal-body">
                <div class="form-group">
                  {{Form::label(null, 'Código*:', array('class'=>'col-sm-3 control-label'))}}
                  <div class="col-sm-9">
                    {{Form::text('codigo', null, array('class'=>'form-control mayuscula input-sm', 
                      'placeholder'=>'CÓDIGO', 'required'=>''))}}
                  </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Cantidad Primera*:', array('class'=>'col-sm-3 control-label'))}}
                  <div class="col-sm-9">
                    {{Form::text('cantidad_p', null, array('class'=>'form-control mayuscula input-sm',
                      'placeholder'=>'CANTIDAD PRIMERA', 'required'=>''))}}
                  </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Cantidad Segunda*:', array('class'=>'col-sm-3 control-label'))}}
                  <div class="col-sm-9">
                    {{Form::text('cantidad_s', null, array('class'=>'form-control mayuscula input-sm',
                      'placeholder'=>'CANTIDAD SEGUNDA', 'required'=>''))}}
                  </div>
                </div>
              </div>
              <div class="modal-footer clearfix">
                {{Form::hidden('empresa', $empresa->ruc)}}
                <button type="submit" class="btn btn-outline pull-left">Agregar</button>
                <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
              </div>
            {{Form::close()}}
          </div>
        </div>
      </div>
      <a class="btn btn-primary" data-toggle="modal" data-target="#quitar">
        <i class="fa fa-plus-square"></i> Quitar Prenda
      </a>
      <div class="modal fade modal-primary" id="quitar" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Quitar prenda a {{$empresa->nombre}}</h4>
            </div>
            {{Form::open(array('url'=>'prenda/quitar', 'class'=>'form-horizontal', 
              'method'=>'post'))}}
              <div class="modal-body">
                <div class="form-group">
                  {{Form::label(null, 'Código*:', array('class'=>'col-sm-3 control-label'))}}
                  <div class="col-sm-9">
                    {{Form::text('codigo', null, array('class'=>'form-control mayuscula input-sm', 
                      'placeholder'=>'CÓDIGO', 'required'=>''))}}
                  </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Cantidad Primera*:', array('class'=>'col-sm-3 control-label'))}}
                  <div class="col-sm-9">
                    {{Form::text('cantidad_p', null, array('class'=>'form-control mayuscula input-sm',
                      'placeholder'=>'CANTIDAD PRIMERA', 'required'=>''))}}
                  </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Cantidad Segunda*:', array('class'=>'col-sm-3 control-label'))}}
                  <div class="col-sm-9">
                    {{Form::text('cantidad_s', null, array('class'=>'form-control mayuscula input-sm',
                      'placeholder'=>'CANTIDAD SEGUNDA', 'required'=>''))}}
                  </div>
                </div>
              </div>
              <div class="modal-footer clearfix">
                {{Form::hidden('empresa', $empresa->ruc)}}
                <button type="submit" class="btn btn-outline pull-left">Quitar</button>
                <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
              </div>
            {{Form::close()}}
          </div>
        </div>
      </div>
      <a class="btn btn-primary" href="<?=URL::to('prenda/reporte/'.$empresa->ruc)?>" 
        target="_blank">
        <i class="fa fa-plus-square"></i> Reporte de Prendas
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
            <h3 class="box-title">Trabajadores de {{$empresa->nombre}}</h3>
          </div>
          <div class="box-body">
            <table id="trabajadores" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>DNI</th>
                  <th>Trabajador</th>
                  <th>Dotar / Recoger</th>
                  <th>Ver</th>
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
                      <a href="<?=URL::to('prenda/dotar/'.$trabajador->id)?>"
                        class="btn btn-warning btn-xs">Dotar / Recoger</a>
                    </td>
                    <td>
                      <a href="<?=URL::to('prenda/ver/'.$trabajador->id)?>" target="_blank"
                        class="btn btn-info btn-xs">Ver</a>
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