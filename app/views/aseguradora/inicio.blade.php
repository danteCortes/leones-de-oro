@extends('plantilla')

@section('titulo')
Configuración | Aseguradoras
@stop

@section('estilos')
@stop

@section('contenido')
<?php
  function moneda($moneda){
    if ($moneda) {
      $aux = explode('.', $moneda);
      if (count($aux) > 1) {
        if (strlen($aux[1]) == 1) {
          $moneda = $moneda."0";
        }else{
          $moneda = $moneda."";
        }
      }else{
        $moneda = $moneda.".00";
      }
    }
    return $moneda;
  }
?>
<section class="content-header">
  <h1>
    Configuración
    <small>Aseguradoras</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Configuración</a></li>
    <li class="active">Aseguradoras</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <a class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
        <i class="fa fa-plus-square"></i> Nueva Aseguradora
      </a>
      <div class="modal fade modal-primary" id="nuevo" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Nueva Aseguradora</h4>
            </div>
            {{Form::open(array('url'=>'aseguradora', 'class'=>'form-horizontal', 'method'=>'post'))}}
              <div class="modal-body">
                <div class="form-group">
                  {{Form::label(null, 'Nombre*:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      {{Form::text('nombre', null, array('class'=>'form-control mayuscula input-sm'
                      , 'placeholder'=>'ASEGURADORA',
                      'required'=>''))}}
                    </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Fondo:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      {{Form::text('fondo', null, array('class'=>'form-control afp 
                      input-sm', 'placeholder'=>'APORTE AL FONDO DE PENSIONES', 'required'=>''))}}
                    </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Prima:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      {{Form::text('prima', null, array('class'=>'form-control afp 
                      input-sm', 'placeholder'=>'PRIMA DE SEGURO', 'required'=>''))}}
                    </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'Flujo:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      {{Form::text('flujo', null, array('class'=>'form-control afp 
                      input-sm', 'placeholder'=>'COMISIÓN SOBRE LA REMUNERACIÓN', 'required'=>''))}}
                    </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'ONP:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      <div class="checkbox">
                        <label>
                          {{Form::checkbox('chbOnp', 1, false, array('id'=>'chbOnp'))}}
                        </label>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  {{Form::label(null, 'COMISIÓN:', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                      {{Form::text('fijo', null, array('class'=>'form-control onp 
                      input-sm', 'placeholder'=>'COMISIÓN', 'disabled'=>'', 'required'=>''))}}
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
          <h3 class="box-title">Aseguradoras</h3>
        </div>
        <div class="box-body">
          <table id="clientes" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Aseguradora</th>
                <th>Fondo</th>
                <th>Prima</th>
                <th>Flujo</th>
                <th>ONP</th>
                <th>Borrar</th>
              </tr>
            </thead>
            <tbody>
              @foreach($aseguradoras as $aseguradora)
                <tr>
                  <td>{{$aseguradora->nombre}}</td>
                  <td>
                    @if($aseguradora->fondo)
                      {{number_format($aseguradora->fondo, 2, '.', ' ')}} %
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    @if($aseguradora->prima)
                      {{number_format($aseguradora->prima, 2, '.', ' ')}} %
                    @else
                      -
                    @endif</td>
                  <td>
                    @if($aseguradora->flujo)
                      {{number_format($aseguradora->flujo, 2, '.', ' ')}} %
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    @if($aseguradora->fijo)
                      {{number_format($aseguradora->fijo, 2, '.', ' ')}} %
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" 
                      data-target="#borrar{{$aseguradora->id}}">
                      Borrar
                    </button>
                    <div class="modal fade modal-danger" id="borrar{{$aseguradora->id}}" 
                      tabindex="-1" role="dialog" aria-labelledby="myModalLabel" 
                      aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" 
                              aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Borrar Aseguradora</h4>
                          </div>
                          {{Form::open(array('url'=>'aseguradora/'.$aseguradora->id, 
                            'method'=>'delete'))}}
                            <div class="modal-body">
                              <div class="form-group">
                                <label>Está a punto de eliminar la aseguradora "{{$aseguradora->
                                  nombre}}". Deberá modificar los datos de los trabajadores que 
                                  estaban relacionados con esta aseguradora para evitar errores 
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
    $("#chbOnp").change(function(){
      if($("#chbOnp").prop('checked') == true){
        $(".afp").val("");
        $(".afp").prop("disabled", true);
        $(".onp").prop("disabled", false);
      }else{
        $(".onp").val("");
        $(".onp").prop("disabled", true);
        $(".afp").prop("disabled", false);
      }
    });
  });
</script>
@stop