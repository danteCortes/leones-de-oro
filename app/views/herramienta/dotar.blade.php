@extends('plantilla')

@section('titulo')
Herramienta | Dotar
@stop

@section('estilos')

@stop

@section('contenido')
<section class="content-header">
  <h1>
    Herramienta
    <small>Dotar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Herramienta</a></li>
    <li class="active">Dotar</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12" id="mensaje">
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
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{$trabajador->persona->nombre}}
            {{$trabajador->persona->apellidos}}</h3>
        </div>
        {{Form::open(array('url'=>'prenda/dotar/'.$trabajador->empresa->ruc.'/'.$trabajador->id,
          'class'=>'form-horizontal'))}}
          {{Form::hidden('ruc', $trabajador->empresa->ruc, array('id'=>'ruc'))}}
          {{Form::hidden('id', $trabajador->id, array('id'=>'id'))}}
          <div class="box-body">
            <div class="form-group">
              <label class="control-label col-md-4">Serie:</label>
              <div class="col-md-6">
                <input type="text" name="serie" class="form-control mayuscula" required
                placeholder="SERIE" id="serie">
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="button" class="btn btn-primary pull-left" id="btnDotar">Agregar</button>
            <button type="button" class="btn btn-warning" id="btnRecoger">Recoger</button>
            <a href="<?=URL::to('herramienta/inicio/'.$trabajador->empresa->ruc)?>" 
              class="btn btn-success pull-right">Terminar</a>
          </div>
        {{Form::close()}}
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Herramientas</h3>
        </div>
        <div class="box-body" id="cargar">
          <div class="box-body table-responsive no-padding" id="cargar">
            <table class="table table-hover">
              <tr>
                <th>Serie</th>
                <th>Herramienta</th>
                <th>Marca</th>
                <th>Modelo</th>
              </tr>
              @foreach($trabajador->herramientas as $herramienta)
              <tr>
                <td>{{$herramienta->serie}}</td>
                <td>{{$herramienta->herramienta->nombre}}</td>
                <td>{{$herramienta->marca}}</td>
                <td>{{$herramienta->modelo}}</td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop

@section('scripts')
<script type="text/javascript">
  $(function(){
    $("#btnRecoger").click(function(){
      if ($("#serie").val() == "") {
        return false;
      } else{
        $.post("<?=URL::to('herramienta/recoger')?>",
          {
            serie: $("#serie").val(),
            ruc: $("#ruc").val(),
            id: $("#id").val()
          },
          function(respuesta){
              $("#serie").val("");
              $("#cargar").html(respuesta['html']);
              $("#mensaje").html(respuesta['mensaje']);
          }
        );
      };
    });

    $("#btnDotar").click(function(){
      if ($("#serie").val() == "") {
        return false;
      } else{
        $.post("<?=URL::to('herramienta/dotar')?>",
          {
            serie: $("#serie").val(),
            ruc: $("#ruc").val(),
            id: $("#id").val()
          },
          function(respuesta){
            $("#serie").val("");
            $("#cargar").html(respuesta['html']);
            $("#mensaje").html(respuesta['mensaje']);
          }
        );
      };
    });
  });
</script>
@stop