@extends('plantilla')

@section('titulo')
Trabajador | Editar
@stop

@section('estilos')
<style type="text/css">
  .mayuscula{
    text-transform: uppercase;
  }
</style>
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Trabajador
    <small>editar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Trabajador</a></li>
    <li class="active">Editar</li>
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
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Trabajador</h3>
        </div>
        {{Form::open(array('url'=>'trabajador/editar/'.$trabajador->id, 'class'=>'form-horizontal'
          , 'method'=>'put'))}}
            <div class="box-body">
              <div class="form-group">
                {{Form::label(null, 'DNI*', array('class'=>'col-sm-2 control-label'))}}
                  <div class="col-sm-10">
                    {{Form::text('dni', $trabajador->persona->dni, array(
                      'class'=>'form-control input-sm dni', 'required'=>''))}}
                  </div>
              </div>
              <div class="form-group">
                {{Form::label(null, 'Nombre*', array('class'=>'col-sm-2 control-label'))}}
                  <div class="col-sm-10">
                    {{Form::text('nombre', $trabajador->persona->nombre, array(
                      'class'=>'form-control input-sm mayuscula', 'required'=>''))}}
                  </div>
              </div>
              <div class="form-group">
                {{Form::label(null, 'Apellidos*', array('class'=>'col-sm-2 control-label'))}}
                  <div class="col-sm-10">
                    {{Form::text('apellidos', $trabajador->persona->apellidos, array(
                      'class'=>'form-control input-sm mayuscula', 'required'=>''))}}
                  </div>
              </div>
              <div class="form-group">
                {{Form::label(null, 'Dirección', array('class'=>'col-sm-2 control-label'))}}
                  <div class="col-sm-10">
                    {{Form::text('direccion', $trabajador->persona->direccion, array(
                      'class'=>'form-control input-sm mayuscula'))}}
                  </div>
              </div>
              <div class="form-group">
                {{Form::label(null, 'Teléfono', array('class'=>'col-sm-2 control-label'))}}
                  <div class="col-sm-10">
                    {{Form::text('telefono', $trabajador->persona->telefono, array(
                      'class'=>'form-control input-sm mayuscula'))}}
                  </div>
              </div>
              <div class="form-group">
                {{Form::label(null, 'Inicio*', array('class'=>'col-sm-2 control-label'))}}
                  <div class="col-sm-10">
                    {{Form::text('inicio', date('d-m-Y', strtotime($trabajador->inicio)), array(
                      'data-inputmask'=>"'alias': 'dd/mm/yyyy'", 'data-mask'=>''
                      , 'class'=>'form-control input-sm', 'required'=>''))}}
                  </div>
              </div>
              <div class="form-group">
                {{Form::label(null, 'Fin*', array('class'=>'col-sm-2 control-label'))}}
                  <div class="col-sm-10">
                    {{Form::text('fin', date('d-m-Y', strtotime($trabajador->fin)), array(
                      'data-inputmask'=>"'alias': 'dd/mm/yyyy'", 'data-mask'=>''
                      , 'class'=>'form-control input-sm', 'required'=>''))}}
                  </div>
              </div>
              <div class="form-group">
                {{Form::label(null, 'Sueldo', array('class'=>'col-sm-2 control-label'))}}
                  <div class="col-sm-10">
                    {{Form::text('sueldo', $trabajador->sueldo, array(
                      'class'=>'form-control input-sm'))}}
                  </div>
              </div>
              <div class="form-group">
                {{Form::label(null, 'Nro. Cuenta', array('class'=>'col-sm-2 control-label'))}}
                  <div class="col-sm-10">
                    {{Form::text('cuenta', $trabajador->cuenta, array(
                      'class'=>'form-control input-sm mayuscula'))}}
                  </div>
              </div>
              <div class="form-group">
                {{Form::label(null, 'Banco', array('class'=>'col-sm-2 control-label'))}}
                  <div class="col-sm-10">
                    {{Form::text('banco', $trabajador->banco, array(
                      'class'=>'form-control input-sm mayuscula'))}}
                  </div>
              </div>
              <div class="form-group">
                {{Form::label(null, 'CCI', array('class'=>'col-sm-2 control-label'))}}
                  <div class="col-sm-10">
                    <div class="checkbox">
                  <label>
                    @if($trabajador->cci)
                      {{Form::checkbox('cci', 1, true)}}
                    @else
                      {{Form::checkbox('cci', 1, false)}}
                    @endif
                  </label>
                </div>
                  </div>
              </div>
              <div class="form-group">
                {{Form::label(null, 'Aseguradora:', array('class'=>'col-sm-3 control-label'))}}
                <div class="col-sm-9">
                  <select name="aseguradora_id" class="form-control input-sm">
                    <option value="{{$trabajador->aseguradora_id}}">
                      {{$trabajador->aseguradora->nombre}} (ACTUAL)</option>
                    <option value="">SELECCIONAR</option>
                    @foreach(Aseguradora::all() as $aseguradora)
                      <option value="{{$aseguradora->id}}">{{$aseguradora->nombre}}</option>
                    @endforeach
                  </select>
                </div>
            </div>
            </div>
            <div class="box-footer">
              <button type="reset" class="btn btn-warning">Limpiar</button>
              <button type="submit" class="btn btn-primary pull-right">Guardar</button>
            </div>
        {{Form::close()}}
      </div>
      <a href="<?=URL::to('trabajador/inicio/'.$trabajador->empresa->ruc)?>" 
        class="btn btn-info">Cancelar</a>
    </div>
    <div class="col-md-6">
      <div class="box box-info">
          <div class="box-header with-border">
              <h3 class="box-title">Cambiar Foto</h3>
              <img src="<?=URL::to('documentos/fotos/'.$trabajador->foto)?>"
                class="img-responsive center-block img-thumbnail col-md-4">
          </div>
          {{Form::open(array('url'=>'trabajador/foto/'.$trabajador->id, 'class'=>'form-horizontal'
            , 'method'=>'put', 'files'=>true))}}
              <div class="box-body">
                <div class="form-group">
                      {{Form::label(null, 'Foto:*', array('class'=>'col-sm-2 control-label'))}}
                    <div class="col-sm-10">
                        {{Form::file('foto', array('required'=>'', 'class'=>'form-control'))}}
                    </div>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Guardar</button>
              </div>
          {{Form::close()}}
      </div>
    </div>
  </div>
</section>
@stop

@section('scripts')
<script>
    $(function () {
        //fecha dd/mm/yyyy
      $("[data-mask]").inputmask();
    });
</script>
@stop