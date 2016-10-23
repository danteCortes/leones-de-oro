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
                  ,'placeholder'=>'SEÑORES', 'required'=>''))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'LUGAR*:', array('class'=>'control-label col-xs-1'))}}
              <div class="col-xs-5">
                {{Form::text('lugar','' , array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'LUGAR', 'required'=>''))}}
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
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nuevo Concepto</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      {{Form::label(null, 'Nombre del Puesto*:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-9">
                        {{Form::text('nombre', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'NOMBRE DEL PUESTO', 'required'=>''))}}
                      </div>
                    </div>
                    <div class="form-group">
                      {{Form::label(null, 'Nº Puestos Diurno*:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('rmv', null, array('class'=>'form-control input-sm',
                          'placeholder'=>'PUESTOS DIURNO', 'required'=>''))}}
                      </div>
                      {{Form::label(null, 'Nº Puestos Nocturno*:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('rmv', null, array('class'=>'form-control input-sm',
                          'placeholder'=>'PUESTOS NOCTURNO', 'required'=>''))}}
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'Sueldo Básico Mensual*:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('rmv', null, array('class'=>'form-control input-sm', 'placeholder'=>
                          'SUELDO BASICO MENSUAL'))}}
                      </div>
                    </div>
                    <div class="form-group">
                      {{Form::label(null, 'Asignación Familiar:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_af" value="1" id="chb_af">
                          </span>
                          {{Form::text('txt_af', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'ASIGNACION FAMILIAR', 'id'=>'txt_af', 'readonly'=>''))}}
                        </div>
                      </div>
                      {{Form::label(null, 'Jornada Nocturna:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_jn" value="1" id="chb_jn">
                          </span>
                          {{Form::text('txt_jn', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'JORNADA NOCTURNA', 'id'=>'txt_jn', 'readonly'=>''))}}
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
                            'placeholder'=>'SOBRE TIEMPO', 'id'=>'txt_st', 'readonly'=>''))}}
                        </div>
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'Descancero:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_descancero" value="1" id="chb_descancero">
                          </span>
                          {{Form::text('txt_descancero', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'DESCANCERO', 'id'=>'txt_descancero', 'readonly'=>''))}}
                        </div>
                      </div>
                      {{Form::label(null, 'Feriados:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_feriados" value="1" id="chb_feriados">
                          </span>
                          {{Form::text('txt_feriados', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'FERIADOS', 'id'=>'txt_feriados', 'readonly'=>''))}}
                        </div>
                      </div>
                    </div><hr>  
                    <div class="form-group">
                      {{Form::label(null, 'Gratificaciones:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_gratificaciones" value="1" id="chb_gratificaciones">
                          </span>
                          {{Form::text('txt_gratificaciones', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'GRATIFICACIONES', 'id'=>'txt_gratificaciones', 'readonly'=>''))}}
                        </div>
                      </div>
                      {{Form::label(null, 'C.T.S.:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_cts" value="1" id="chb_cts">
                          </span>
                          {{Form::text('txt_cts', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'C.T.S.', 'id'=>'txt_cts', 'readonly'=>''))}}
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      {{Form::label(null, 'Vacaciones:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_vacaciones" value="1" id="chb_vacaciones">
                          </span>
                          {{Form::text('txt_vacaciones', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'VACACIONES', 'id'=>'txt_vacaciones', 'readonly'=>''))}}
                        </div>
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'EsSalud:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_essalud" value="1" id="chb_essalud">
                          </span>
                          {{Form::text('txt_essalud', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'ESSALUD', 'id'=>'txt_essalud', 'readonly'=>''))}}
                        </div>
                      </div>
                      {{Form::label(null, 'S.C.T.R.:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="chb_sctr" value="1" id="chb_sctr">
                          </span>
                          {{Form::text('txt_sctr', null, array('class'=>'form-control input-sm mayuscula',
                            'placeholder'=>'S.C.T.R', 'id'=>'txt_sctr', 'readonly'=>''))}}
                        </div>
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'Unif. Equip, Sup.:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'UNIFORME, EQUIPO, SUPERVISION'))}}
                      </div>
                      {{Form::label(null, 'Capacitación:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'CAPACITACION'))}}
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'Movilidad:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'MOVILIDAD'))}}
                      </div>
                      {{Form::label(null, 'Refrigerio:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'REFRIGERIO'))}}
                      </div>
                    </div><hr>
                    <div class="form-group">
                      {{Form::label(null, 'Gastos Generales:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'GASTOS GENERALES'))}}
                      </div>
                      {{Form::label(null, 'Utilidad:', array('class'=>'col-xs-3 control-label'))}}
                      <div class="col-xs-3">
                        {{Form::text('cmb_st', null, array('class'=>'form-control input-sm mayuscula',
                          'placeholder'=>'UTILIDAD'))}}
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
                    <button type="button" class="btn btn-primary">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Cant.</th>
                    <th>Descripción</th>
                    <th>Prec. Uni.</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2</td>
                    <td>SERVICIO DE SEGURIDAD Y VIGILANCIA PARA LA INTENDENCIA REGIONAL DE HUANUCO<br>
                      SERVICIO DE 24 HORAS DE LUNES A DOMINGO INCLUIDO FERIADOS</td>
                    <td>7304.00</td>
                    <td>14608.00</td>
                  </tr>
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
                {{Form::text('lugar', null, array('class'=>'form-control input-sm',
                  'placeholder'=>'FECHA', 'required'=>''))}}
              </div>
            </div>
          </div>
          <div class="box-body">
            {{Form::button('Guardar', array('class'=>'btn btn-primary', 'type'=>'submit', 
              'id'=>'guardar'))}}
            <a href="<?=URL::to('costo/inicio/'.$empresa->ruc)?>"
              class="btn btn-warning pull-right">Atras</a>
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

    $("#chb_af").change(function(){
      $("#txt_af").val('');
      if($("#chb_af").prop("checked")){
        $("#txt_af").prop('readonly', false);
      }else{
        $("#txt_af").prop('readonly', true);
      }
    });

    $("#chb_jn").change(function(){
      $("#txt_jn").val('');
      if($("#chb_jn").prop("checked")){
        $("#txt_jn").prop('readonly', false);
      }else{
        $("#txt_jn").prop('readonly', true);
      }
    });

    $("#chb_st").change(function(){
      $("#txt_st").val('');
      if($("#chb_st").prop("checked")){
        $("#txt_st").prop('readonly', false);
      }else{
        $("#txt_st").prop('readonly', true);
      }
    });

    $("#chb_descancero").change(function(){
      $("#txt_descancero").val('');
      if($("#chb_descancero").prop("checked")){
        $("#txt_descancero").prop('readonly', false);
      }else{
        $("#txt_descancero").prop('readonly', true);
      }
    });

    $("#chb_feriados").change(function(){
      $("#txt_feriados").val('');
      if($("#chb_feriados").prop("checked")){
        $("#txt_feriados").prop('readonly', false);
      }else{
        $("#txt_feriados").prop('readonly', true);
      }
    });

    $("#chb_gratificaciones").change(function(){
      $("#txt_gratificaciones").val('');
      if($("#chb_gratificaciones").prop("checked")){
        $("#txt_gratificaciones").prop('readonly', false);
      }else{
        $("#txt_gratificaciones").prop('readonly', true);
      }
    });

    $("#chb_cts").change(function(){
      $("#txt_cts").val('');
      if($("#chb_cts").prop("checked")){
        $("#txt_cts").prop('readonly', false);
      }else{
        $("#txt_cts").prop('readonly', true);
      }
    });

    $("#chb_vacaciones").change(function(){
      $("#txt_vacaciones").val('');
      if($("#chb_vacaciones").prop("checked")){
        $("#txt_vacaciones").prop('readonly', false);
      }else{
        $("#txt_vacaciones").prop('readonly', true);
      }
    });

    $("#chb_essalud").change(function(){
      $("#txt_essalud").val('');
      if($("#chb_essalud").prop("checked")){
        $("#txt_essalud").prop('readonly', false);
      }else{
        $("#txt_essalud").prop('readonly', true);
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
  });
</script>
@stop