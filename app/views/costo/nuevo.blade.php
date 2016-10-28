@extends('plantilla')

@section('titulo')
Estructura de Costos | Nuevo
@stop

@section('estilos')
<link rel="stylesheet" type="text/css" href="<?=URL::to('plugins/jQueryUI/jquery-ui.css')?>">
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Estructura de Costos
    <small>Nuevo</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Estructura de Costos</a></li>
    <li class="active">Nuevo</li>
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
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Nueva Estructura de Costos
            <small>Redactar</small>
          </h3><br>
        </div>
        {{Form::open(array('url'=>'costo/nuevo/'.$empresa->ruc, 'class'=>'form-horizontal', 
          'method'=>'post'))}}
          <div class="box-body">
            <div class="form-group">
              {{Form::label(null, 'SEÑORES*:', array('class'=>'control-label col-xs-1'))}}
              <div class="col-xs-7">
                {{Form::text('destinatario','' , array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'SEÑORES', 'required'=>'', 'id'=>'cliente'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'LUGAR*:', array('class'=>'control-label col-xs-1'))}}
              <div class="col-xs-5">
                {{Form::text('lugar','' , array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'LUGAR', 'required'=>'', 'id'=>'lugar'))}}
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="form-group">
              <div class="col-xs-12">
                <textarea id="saludo" name="saludo" rows="3" cols="80" placeholder="Contenido..." required="">
                  Saludo...
                </textarea>
              </div>
            </div>
          </div>
          <div class="box-body">
            {{Form::button('Agregar Concepto', array('class'=>'btn btn-success', 
              'data-toggle'=>'modal', 'data-target'=>'#nuevo'))}}
            <div class="modal fade modal-info" id="nuevo" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nuevo Concepto</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group" id="frgNombre">
                      {{Form::label(null, 'Nombre del Puesto*:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-9">
                        {{Form::text('nombre', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'NOMBRE DEL PUESTO', 'id'=>'nombre'))}}
                      </div>
                    </div>
                    <div class="form-group">
                      {{Form::label(null, 'Nº Puestos Diurno*:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3" id="frgDiurno">
                        {{Form::text('rmv', null, array('class'=>'form-control input-sm',
                          'placeholder'=>'PTS DIURNO', 'id'=>'diurno'))}}
                      </div>
                      {{Form::label(null, 'Nº Puestos Nocturno*:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('rmv', null, array('class'=>'form-control input-sm',
                          'placeholder'=>'PTS NOCTURNO', 'id'=>'nocturno'))}}
                      </div>
                    </div><hr>
                    <div class="form-group" id="frgRmv">
                      {{Form::label(null, 'Sueldo Básico Mensual*:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('rmv', null, array('class'=>'form-control input-sm', 
                        'placeholder'=>'RVM S/.', 'id'=>'rmv'))}}
                      </div>
                    </div>
                    <div class="form-group">
                      {{Form::label(null, 'Asignación Familiar:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="asignacionFamiliar" value="1" id="asignacionFamiliar">
                          </label>
                        </div>
                      </div>
                      {{Form::label(null, 'Jornada Nocturna:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="jornadaNocturna" value="1" id="jornadaNocturna">
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      {{Form::label(null, 'Sobre Tiempo:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_st" value="1" id="chb_st">
                          </span>
                          {{Form::text('txt_st', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'ST HRS', 'id'=>'txt_st', 'readonly'=>''))}}
                        </div>
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'Descansero:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="descansero" value="1" id="descansero">
                            </label>
                          </div>
                        </div>
                      </div>
                      {{Form::label(null, 'Feriados:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="feriados" value="1" id="feriados">
                            </label>
                          </div>
                        </div>
                      </div>
                    </div><hr>  
                    <div class="form-group">
                      {{Form::label(null, 'Gratificaciones:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="gratificaciones" value="1" id="gratificaciones">
                            </label>
                          </div>
                        </div>
                      </div>
                      {{Form::label(null, 'C.T.S.:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="cts" value="1" id="cts">
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      {{Form::label(null, 'Vacaciones:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="vacaciones" value="1" id="vacaciones">
                            </label>
                          </div>
                        </div>
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'EsSalud:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="essalud" value="1" id="essalud">
                            </label>
                          </div>
                        </div>
                      </div>
                      {{Form::label(null, 'S.C.T.R.:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_sctr" value="1" id="chb_sctr">
                          </span>
                          {{Form::text('txt_sctr', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'S.C.T.R. %', 'id'=>'txt_sctr', 'readonly'=>''))}}
                        </div>
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'Unif. Equip, Sup.:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'UNIFORME, EQUIPO, SUPERVISION', 'id'=>'ueas'))}}
                      </div>
                      {{Form::label(null, 'Capacitación:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'CAPACITACION', 'id'=>'capacitacion'))}}
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'Movilidad:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'MOVILIDAD', 'id'=>'movilidad'))}}
                      </div>
                      {{Form::label(null, 'Refrigerio:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'REFRIGERIO', 'id'=>'refrigerio'))}}
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'Gastos Generales:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'GASTOS GENERALES', 'id'=>'gastosgenerales'))}}
                      </div>
                      {{Form::label(null, 'Utilidad:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'UTILIDAD', 'id'=>'utilidad'))}}
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'I.G.V.:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_igv" value="1" id="chb_igv">
                          </span>
                          {{Form::text('txt_igv', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'I.G.V. %', 'id'=>'txt_igv', 'readonly'=>''))}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="guardarConcepto">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Cant.</th>
                    <th>Descripción</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody id="conceptos">
                  @if($costo->id)
                    @foreach($costo->conceptos as $concepto)
                    <tr>
                      <td>{{$concepto->numero}} AVP</td>
                      <td>{{$concepto->nombre}}</td>
                      <th style="text-align: right;">
                        @if(strpos($concepto->total, '.') === false)
                          {{$concepto->total}}.00
                        @elseif(strlen(substr($concepto->total, strpos($concepto->total, '.'))) == 3)
                          {{$concepto->total}}
                        @else
                          {{$concepto->total}}.0
                        @endif
                      </th>
                    </tr>
                    @endforeach
                    <tr>
                      <th colspan="2" style="text-align: right;">SUBTOTAL MENSUAL</th>
                      <th style="text-align: right;">
                        @if(strpos($costo->subtotal, '.') === false)
                          {{$costo->subtotal}}.00
                        @else
                          @if(strlen(substr($costo->subtotal, strpos($costo->subtotal, '.'))) == 3)
                            {{$costo->subtotal}}
                          @else
                            {{$costo->subtotal}}0
                          @endif
                        @endif
                      </th>
                    </tr>
                    <tr>
                      @if($costo->igv != 0)
                        <th colspan="2" style="text-align: right;">IGV</th>
                      @else
                        <th colspan="2" style="text-align: right;">IGV EXONERADO POR LEY Nº 27037</th>
                      @endif
                      <th style="text-align: right;">
                        @if(strpos($costo->igv, '.') === false)
                          {{$costo->igv}}.00
                        @else
                          @if(strlen(substr($costo->igv, strpos($costo->igv, '.'))) == 3)
                            {{$costo->igv}}
                          @else
                            {{$costo->igv}}0
                          @endif
                        @endif
                      </th>
                    </tr>
                    <tr>
                      <th colspan="2" style="text-align: right;">TOTAL</th>
                      <th style="text-align: right;">
                        @if(strpos($costo->total, '.') === false)
                          {{$costo->total}}.00
                        @else
                          @if(strlen(substr($costo->total, strpos($costo->total, '.'))) == 3)
                            {{$costo->total}}
                          @else
                            {{$costo->total}}0
                          @endif
                        @endif
                      </th>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
          <div class="box-body">
            <div class="form-group">
              <div class="col-xs-12">
                <textarea id="despedida" name="despedida" rows="3" cols="80" placeholder="Contenido..." required="">
                  Despedida...
                </textarea>
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'Fecha*:', array('class'=>'col-sm-1 control-label'))}}
              <div class="col-xs-5">
                {{Form::text('fecha', null, array('class'=>'form-control input-sm mayuscula',
                  'placeholder'=>'FECHA', 'required'=>'', 'id'=>'fecha'))}}
              </div>
            </div>
          </div>
          <div class="box-body">
            {{Form::button('Guardar', array('class'=>'btn btn-primary', 'type'=>'submit',))}}
            @if($costo->id)
            <a href="<?=URL::to('costo/cancelar/'.$costo->id)?>"
              class="btn btn-danger">Atras</a>
            @endif
            <a href="<?=URL::to('costo/inicio/'.$empresa->ruc)?>"
              class="btn btn-warning pull-right">Cancelar</a>
          </div>
          {{Form::hidden('empresa_ruc', $empresa->ruc, array('id'=>'empresa_ruc'))}}
        {{Form::close()}}
      </div>
    </div>
  </div>
</section>
@stop

@section('scripts')
<!-- CK Editor -->
<script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js" type="text/javascript"></script>
<script src="<?=URL::to('plugins/jQueryUI/jquery-ui.min.js')?>" type="text/javascript"></script>
<script>
  $(function(){

    CKEDITOR.replace('saludo');

    CKEDITOR.replace('despedida');

    $("#chb_st").change(function(){
      $("#txt_st").val('');
      if($("#chb_st").prop("checked")){
        $("#txt_st").prop('readonly', false);
      }else{
        $("#txt_st").prop('readonly', true);
      }
    });

    $("#chb_sctr").change(function(){
      $("#txt_sctr").val('');
      if($("#chb_sctr").prop("checked")){
        $("#txt_sctr").prop('readonly', false);
      }else{
        $("#txt_sctr").prop('readonly', true);
      }
    });

    $("#chb_igv").change(function(){
      $("#txt_igv").val('');
      if($("#chb_igv").prop("checked")){
        $("#txt_igv").prop('readonly', false);
      }else{
        $("#txt_igv").prop('readonly', true);
      }
    });

    $("#guardarConcepto").click(function(){
      if($("#nombre").val() == ''){
        $("#nombre").focus();
      }else if($("#diurno").val() == ''){
        $("#diurno").focus();
      }else if($("#nocturno").val() == ''){
        $("#nocturno").focus();
      }else if($("#rmv").val() == ''){
        $("#rmv").focus();
      }else{
        $.ajax({
          url: "<?=URL::to('costo/guardar-concepto')?>",
          type: 'POST',
          data: {empresa_ruc: $("#empresa_ruc").val(), nombre: $("#nombre").val(),
            diurno: $("#diurno").val(), nocturno: $("#nocturno").val(), rmv: $("#rmv").val(), 
            asignacionfamiliar: $("#asignacionFamiliar:checked").val(), txt_st: $("#txt_st").val(),
            jornadanocturna: $("#jornadaNocturna:checked").val(), descansero: $("#descansero:checked").val(),
            feriados: $("#feriados:checked").val(), gratificaciones: $("#gratificaciones:checked").val(),
            cts: $("#cts:checked").val(), vacaciones: $("#vacaciones:checked").val(),
            essalud: $("#essalud:checked").val(), txt_sctr: $("#txt_sctr").val(), ueas: $("#ueas").val(),
            capacitacion: $("#capacitacion").val(), movilidad: $("#movilidad").val(), 
            refrigerio: $("#refrigerio").val(), gastosgenerales: $("#gastosgenerales").val(),
            utilidad: $("#utilidad").val(), txt_igv: $("#txt_igv").val()},
          
          error: function(){
            alert("hubo un error en la conexión con el controlador");
          },
          success: function(respuesta){
            $("#conceptos").html(respuesta);
          }
        });
        $('#nuevo').modal('toggle');
      }
    });

    $('input').keypress(function(e){
      if(e.which == 13){
        return false;
    }
  });
  });
</script>
@stop