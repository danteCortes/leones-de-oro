@extends('plantilla')

@section('titulo')
Prenda | Dotar
@stop

@section('estilos')

@stop

@section('contenido')
<section class="content-header">
  <h1>
    Prenda
    <small>Dotar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Prenda</a></li>
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
              <label class="control-label col-md-4">Código:</label>
              <div class="col-md-6">
                <input type="text" name="codigo" class="form-control mayuscula" required
                placeholder="CÓDIGO" id="codigo">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-4">Cantidad Primera:</label>
              <div class="col-md-6">
                <input type="text" name="cantidad_p" class="form-control" required
                  placeholder="CANTIDAD PRIMERA" id="cantidad_p">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-4">Cantidad Segunda:</label>
              <div class="col-md-6">
                <input type="text" name="cantidad_s" class="form-control" required
                  placeholder="CANTIDAD SEGUNDA" id="cantidad_s">
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-left">Agregar</button>
            <button type="button" class="btn btn-warning" id="btnRecoger">Recoger</button>
            <a href="<?=URL::to('prenda/inicio/'.$trabajador->empresa->ruc)?>" 
              class="btn btn-success pull-right">Terminar</a>
          </div>
        {{Form::close()}}
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Uniforme</h3>
        </div>
        <div class="box-body" id="cargar">
          <div class="box-body table-responsive no-padding" id="cargar">
            <table class="table table-hover">
              <tr>
                <th>Código</th>
                <th>Prenda</th>
                <th>Primera</th>
                <th>Segunda</th>
              </tr>
              @foreach($trabajador->prendas as $prenda)
              <tr>
                <td>{{$trabajador->empresa->prendas->find($prenda->id)->pivot->codigo}}</td>
                <td>{{$prenda->nombre}} {{$prenda->talla}}</td>
                <td>{{$prenda->pivot->cantidad_p}}</td>
                <td>{{$prenda->pivot->cantidad_s}}</td>
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
      $.post("<?=URL::to('prenda/recoger')?>",
        {
          codigo: $("#codigo").val(), 
          cantidad_p: $("#cantidad_p").val(), 
          cantidad_s: $("#cantidad_s").val(),
          ruc: $("#ruc").val(),
          id: $("#id").val()
        },
        function(respuesta){
          if (respuesta['respuesta'] == 1) {
            $("#codigo").val("");
            $("#cantidad_p").val("");
            $("#cantidad_s").val("");
            $("#cargar").html(respuesta['html']);
            
          } else{
            $("#codigo").val("");
            $("#cantidad_p").val("");
            $("#cantidad_s").val("");
            $("#mensaje").html(respuesta['html']);
          };
        }
      );
    });
  });
</script>
@stop