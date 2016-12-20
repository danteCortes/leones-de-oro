@extends('plantilla')

@section('titulo')
Configuración | Bonificaciones
@stop

@section('estilos')
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Configuración
    <small>Bonificaciones</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Configuración</a></li>
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
              <h4 class="modal-title">Nueva Bonificación</h4>
            </div>
            {{Form::open(array('url'=>'bonificacion', 'class'=>'form-horizontal', 'method'=>'post'))}}
              <div class="modal-body">
                <div class="form-group">
                  {{Form::label(null, 'Nombre*:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      {{Form::text('nombre', null, array('class'=>'form-control mayuscula input-sm'
                      , 'placeholder'=>'BONIFICACIÓN',
                      'required'=>''))}}
                    </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Porcentaje:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      {{Form::text('porcentaje', null, array('class'=>'form-control input-sm', 
                        'placeholder'=>'PORCENTAJE', 'required'=>'', 'id'=>'porcentaje'))}}
                    </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Fijo:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      {{Form::text('fijo', null, array('class'=>'form-control input-sm',
                        'placeholder'=>'FIJO', 'required'=>'', 'id'=>'fijo'))}}
                    </div>
                </div>
              </div>
              <div class="modal-footer clearfix">
                <button type="submit" class="btn btn-outline pull-left">Guardar</button>
                <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
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
    <div class="col-xs-7">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Bonificaciones</h3>
        </div>
        <div class="box-body">
          <table id="clientes" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Bonificacion</th>
                <th>Porcentaje</th>
                <th>Fijo</th>
                <th>Borrar</th>
              </tr>
            </thead>
            <tbody>
              @foreach($bonificaciones as $bonificacion)
                <tr>
                  <td>{{$bonificacion->nombre}}</td>
                  <td>
                    @if($bonificacion->porcentaje)
                      {{number_format($bonificacion->porcentaje, 2, '.', ' ')}} %
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    @if($bonificacion->fijo)
                      S/ {{number_format($bonificacion->fijo, 2, '.', ' ')}}
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" 
                      data-target="#borrar{{$bonificacion->id}}">
                      Borrar
                    </button>
                    <div class="modal fade modal-danger" id="borrar{{$bonificacion->id}}" 
                      tabindex="-1" role="dialog" aria-labelledby="myModalLabel" 
                      aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" 
                              aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Borrar Bonificación</h4>
                          </div>
                          {{Form::open(array('url'=>'bonificacion/'.$bonificacion->id, 
                            'method'=>'delete'))}}
                            <div class="modal-body">
                              <div class="form-group">
                                <label>Está a punto de eliminar la bonificación "{{$bonificacion->
                                  nombre}}". Deberá modificar los datos de los trabajadores que 
                                  estaban relacionados con esta bonificación para evitar errores 
                                  en el sistema.<br>Le recomendamos tomar medidas necesarias 
                                  antes de eliminarlo.</label>
                              </div>
                              <div class="form-group">
                                <label>Para confirmar esta acción se necesita su contraseña, de
                                  lo contrario pulse cancelar para declinar.</label>
                                  {{Form::password('password', array('class'=>'form-control
                                  input-sm', 'placeholder'=>'PASSWORD', 'required'=>''))}}
                              </div>
                            </div>
                            <div class="modal-footer clearfix">
                              <button type="button" class="btn btn-outline" 
                                data-dismiss="modal">Cancelar</button>
                              <button type="submit" class="btn btn-outline pull-left">Borrar
                              </button>
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
<script type="text/javascript">
  $(function(){
    $("#porcentaje").blur(function(){
      if ($("#porcentaje").val() == "") {
        $("#fijo").prop("disabled", false);
        $("#porcentaje").prop("disabled", true);
      } else{
        $("#fijo").prop("disabled", true);
        $("#porcentaje").prop("disabled", false);
      };
    });
    $("#fijo").blur(function(){
      if ($("#fijo").val() == "") {
        $("#porcentaje").prop("disabled", false);
        $("#fijo").prop("disabled", true);
      } else{
        $("#porcentaje").prop("disabled", true);
        $("#fijo").prop("disabled", false);
      };
    });
  });
</script>
@stop