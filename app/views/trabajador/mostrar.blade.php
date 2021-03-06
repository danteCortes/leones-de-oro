@extends('plantilla')

@section('titulo')
Trabajador | Ver
@stop

@section('estilos')
<link rel="stylesheet" type="text/css" href="<?=URL::to('plugins/jQueryUI/jquery-ui.css')?>">
@stop

@section('contenido')
<?php
  function moneda($moneda){
    $aux = explode('.', $moneda);
    if (count($aux) > 1) {
      if (strlen($aux[1]) == 1) {
        $moneda = $moneda."0";
      }
    }else{
      $moneda = $moneda.".00";
    }
    return $moneda;
  }
?>
<section class="content-header">
  <h1>
    Trabajador
    <small>mostrar</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Trabajador</a></li>
    <li class="active">Mostrar</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      @if(!$trabajador->documentos(8)->first())
        <div class="alert alert-warning alert-dismissable">
          <i class="fa fa-info"></i>
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <b>Cuidado!</b> Este personal de trabajo no tiene un contrato asignado.
        </div>
      @endif
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
        <div class="box-header">
          <h3 class="box-title">Datos del Trabajador</h3><br>
          <img src="<?=URL::to('documentos/fotos/'.$trabajador->foto)?>"
            class="img-responsive center-block img-thumbnail col-xs-6 
            col-sm-6 col-md-6 col-lg-3">
        </div>
        <div class="box-body no-padding">
          <table class="table table-striped">
            <tr>
                <th>DNI</th>
                <td>{{$trabajador->persona->dni}}</td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td>{{$trabajador->persona->nombre}}</td>
            </tr>
            <tr>
                <th>Apellidos</th>
                <td>{{$trabajador->persona->apellidos}}</td>
            </tr>
            <tr>
                <th>Dirección</th>
                <td>{{$trabajador->persona->direccion}}</td>
            </tr>
            <tr>
                <th>Teléfono</th>
                <td>{{$trabajador->persona->telefono}}</td>
            </tr>
            <tr>
                <th>Empresa</th>
                <td>{{$trabajador->empresa->nombre}}</td>
            </tr>
            <tr>
                <th>inicio</th>
                <td>{{date('d-m-Y', strtotime($trabajador->inicio))}}</td>
            </tr>
            <tr>
                <th>Fin</th>
                <td>{{date('d-m-Y', strtotime($trabajador->fin))}}</td>
            </tr>
            <tr>
                <th>Sueldo</th>
                <td>S/ {{moneda($trabajador->sueldo)}}</td>
            </tr>
            <tr>
              <th>Asignación Familiar</th>
              <td>
                @if($trabajador->af)
                  SI
                @else
                  NO
                @endif
              </td>
            </tr>
            <tr>
              <th>Horas Extras</th>
              <td>{{$trabajador->he}}</td>
            </tr>
            <tr>
              <th>Nro Cuenta
                @if($trabajador->cci)
                  (CCI)
                @endif
              </th>
              <td>{{$trabajador->cuenta}}</td>
            </tr>
            <tr>
                <th>Banco</th>
                <td>{{$trabajador->banco}}</td>
            </tr>
            <tr>
                <th>Aseguradora</th>
                <td>
                  @if($trabajador->aseguradora_id)
                    {{$trabajador->aseguradora->nombre}}
                  @endif
                    </td>
            </tr>
          </table>
        </div>
      </div>
      <a href="<?=URL::to('trabajador/codigo/'.$trabajador->id)?>" class="btn btn-success"
        target="_blank">Generar Código QR</a>
      <a href="<?=URL::to('trabajador/inicio/'.$empresa->ruc)?>" class="btn btn-primary">
        Volver a {{$empresa->nombre}}</a>
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Agregar Documento</h3>
        </div>
        {{Form::open(array('url'=>'trabajador/documentar', 'files'=>true))}}
            <div class="box-body">
              <div class="form-group">
                  {{Form::label(null, 'Tipo:*', array('class'=>'control-label'))}}
                  <select name="documento_id" class="form-control" required>
                    <option value="">SELECCIONAR</option>
                    @foreach(Documento::all() as $documento)
                      <option value="{{$documento->id}}">{{$documento->nombre}}</option>
                    @endforeach
                  </select>
              </div>
              <div class="form-group">
                  {{Form::label(null, 'Archivo:*', array('class'=>'control-label'))}}
                  {{Form::file('archivo', array('required'=>''))}}
              </div>
            </div>
            <div class="box-footer">
              {{Form::hidden('trabajador_id', $trabajador->id)}}
              <button type="submit" class="btn btn-primary">Agregar</button>
            </div>
        {{Form::close()}}
      </div>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Asignar Cargo y Cliente</h3>
        </div>
        {{Form::open(array('url'=>'trabajador/cargo'))}}
            <div class="box-body">
              <div class="form-group">
                  {{Form::label(null, 'RUC:', array('class'=>'control-label'))}}
                  {{Form::text('ruc', null, array('class'=>'form-control input-sm'
                  , 'id'=>'ruc', 'readonly'=>'', 'required'=>''))}}
              </div>
              <div class="form-group">
                  {{Form::label(null, 'Cliente:*', array('class'=>'control-label'))}}
                  {{Form::text('cliente', null, array('class'=>'form-control input-sm clientes mayuscula'
                  ,'required'=>''))}}
              </div>
              <div class="form-group">
                  {{Form::label(null, 'Cargo:*', array('class'=>'control-label'))}}
                  <select name="cargo" class="form-control input-sm" required>
                    <option value="">SELECCIONAR</option>
                    @foreach(Cargo::all() as $cargo)
                      <option value="{{$cargo->id}}">{{$cargo->nombre}}</option>
                    @endforeach
                  </select>
              </div>
              <div class="form-group">
                  {{Form::label(null, 'Pto de Trabajo:', array('class'=>'control-label'))}}
                  <select name="punto" class="form-control input-sm" id="punto" required disabled="">
                    <option value="">SELECCIONAR</option>
                  </select>
              </div>
            </div>
            <div class="box-footer">
              {{Form::hidden('trabajador_id', $trabajador->id, array('id'=>'trabajador_id'))}}
              <button type="submit" class="btn btn-primary">Agregar</button>
            </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
            <h3 class="box-title">Cargos</h3>
        </div>
        <div class="box-body no-padding">
            <table class="table table-striped">
              <tr>
                <th>CLIENTE</th>
                <th>CARGO</th>
                <th>PTO. TRABAJO</th>
                <th>BORRAR</th>
              </tr>
              @foreach($trabajador->puntos as $punto)
              <tr>
                <th>{{$punto->contrato->cliente->nombre}}</th>
                <td>{{Cargo::find($punto->pivot->cargo_id)->nombre}}</td>
                <td>{{$punto->nombre}}</td>
                <td>
                  {{Form::button('Borrar', array('class'=>'btn btn-danger btn-xs', 'data-toggle'=>'modal'
                    , 'data-target'=>'#borrarPunto'.$punto->id))}}
                  <div class="modal fade modal-danger" id="borrarPunto{{$punto->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Borrar Cargo en {{$punto->contrato->cliente->nombre}}</h4>
                        </div>
                        {{Form::open(array('url'=>'trabajador/cargo/'.$punto->id,
                          'class'=>'form-horizontal', 'method'=>'delete'))}}
                          <div class="modal-body">
                            <div class="form-group">
                              <p class="col-sm-12">PARA BORRAR EL CARGO DE ESTE TRABAJADOR EN {{$punto->contrato
                                ->cliente->nombre}} DEBE INTRODUCIR SU CONTRASEÑA PARA AUTORIZAR ESTE PROCESO.</p>
                            </div>
                            <div class="form-group">
                                {{Form::label(null, 'Contraseña:', array('class'=>'control-label col-sm-2'))}}
                                <div class="col-sm-10">
                                  {{Form::password('password', array('class'=>'form-control input-sm',
                                    'required'=>''))}}
                                </div>
                            </div>
                          </div>
                          <div class="modal-footer clearfix">
                            {{Form::hidden('trabajador_id', $trabajador->id, array('id'=>'trabajador_id'))}}
                            {{Form::hidden('punto_ruc', $punto->ruc, array('id'=>'cliente_ruc'))}}
                            <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-outline pull-left">Guardar</button>
                          </div>
                        {{Form::close()}}
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </table>
        </div>
      </div>
    </div>
  </div>
  @if(count($trabajador->memorandums) != 0)
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Memorandums</h3>
          </div>
          <div class="box-body no-padding">
            <table class="table table-striped">
              <tr>
                <th>MEMORANDUM</th>
                <th>REMITENTE</th>
                <th>RAZON</th>
                <th>MOSTRAR</th>
              </tr>
              @foreach($trabajador->memorandums as $memorandum)
              <tr>
                <td>{{$memorandum->codigo}}</td>
                <td>{{Usuario::find($memorandum->remite)->persona->nombre}}</td>
                <td>{{TipoMemorandum::find($memorandum->tipo_memorandum_id)->nombre}}</td>
                <td>
                  <a href="<?=URL::to('memorandum/mostrar/'.$memorandum->id)?>" class="btn btn-warning btn-xs">Mostrar</a>
                </td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  @endif
  <div class="row">
    <div class="col-md-12">
        <div class="box">
          <div class="box-header">
              <h3 class="box-title">Documentos</h3>
          </div>
          <div class="box-body no-padding">
              <table class="table table-striped">
                @foreach($trabajador->documentos as $documento)
                <tr>
                  <table class="table">
                    <tr>
                        <th>{{$documento->nombre}}</th>
                    </tr>
                    <tr>
                      <td>
                        <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" src="<?=URL::to('documentos/documentos/'.$documento->pivot->nombre)?>"></iframe>
                  </div>
                      </td>
                    </tr>
                  </table>
                </tr>
                @endforeach
              </table>
          </div>
        </div>
    </div>
  </div>
</section>
@stop

@section('scripts')
<script src="<?=URL::to('plugins/jQueryUI/jquery-ui.min.js')?>" type="text/javascript"></script>
<script>
  $(function(){
    var autocompletar = new Array();
    @foreach($clientes as $l)
      autocompletar.push('{{$l->nombre}}');
    @endforeach
    $(".clientes").autocomplete({ //Usamos el ID de la caja de texto donde lo queremos
      source: autocompletar //Le decimos que nuestra fuente es el arreglo
    });
    $(".clientes").focusout(function() {
      $.ajax({
        url: "<?=URL::to('trabajador/buscar-ruc')?>",
        type: 'POST',
        data: {nombre: $(".clientes").val(), trabajador_id: $("#trabajador_id").val()},
        dataType: 'JSON',
        beforeSend: function() {
          $("#ruc").val('Buscando RUC...');
        },
        error: function() {
          $("#ruc").val('Ha surgido un error.');
        },
        success: function(respuesta) {
          if (respuesta) {
            $("#ruc").val('');
            $("#punto").prop('disabled', false);
            $(respuesta).each(function(i, v){
              $("#punto").append('<option value="' + v.id + '">' + v.nombre + '</option>');
            });
          } else {
            $("#ruc").val('No se encontro contrato vigente del cliente.');
            $("#punto").prop('disabled', true);
          }
        }
      });
    });
  });
</script>
@stop