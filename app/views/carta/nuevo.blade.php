@extends('plantilla')

@section('titulo')
Carta | Nuevo
@stop

@section('estilos')
<link rel="stylesheet" type="text/css" href="<?=URL::to('plugins/jQueryUI/jquery-ui.css')?>">
@stop

@section('contenido')
<section class="content-header">
  <h1>
    Carta
    <small>Nuevo</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Carta</a></li>
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
          <h3 class="box-title">CARTA Nº <label id="nro">
            @if(Variable::where('empresa_ruc', '=', $empresa->ruc)->where('anio', '=', date('Y'))->first())
              @if(Variable::where('empresa_ruc', '=', $empresa->ruc)->where('anio', '=', date('Y'))->first()->inicio_carta)
                @if(Carta::where('empresa_ruc', '=', $empresa->ruc)->where('redaccion', 'like', '%'.date('Y').'%')
                  ->orderBy('numero', 'desc')->first())
                  {{Carta::where('empresa_ruc', '=', $empresa->ruc)->orderBy('numero', 'desc')->first()->numero+1}}
                @else
                  {{Variable::where('empresa_ruc', '=', $empresa->ruc)->where('anio', '=', date('Y'))->first()->inicio_carta}}
                @endif
              @else
                {{Form::button('Configurar Numeración', array('class'=>'btn btn-primary btn-xs',
                  'data-toggle'=>'modal', 'data-target'=>'#modal'))}}
                <div class="modal fade bs-example-modal-sm" id="modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Ingrese numeración inicial</h4>
                      </div>
                      {{Form::open(array('url'=>'carta/numeracion', 'class'=>'form-horizontal'))}}
                        <div class="modal-body">
                          <div class="form-group">
                            {{Form::label(null, 'Numeración*:', array('class'=>'control-label col-sm-6'))}}
                            <div class="col-sm-6">
                              {{Form::text('numero', null, array('class'=>'form-control input-sm numero', 
                              'id'=>'numero', 'required'=>''))}}
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          {{Form::hidden('empresa_ruc', $empresa->ruc, array('id'=>'empresa_ruc'))}}
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-primary" id="numeracion">Guardar</button>
                        </div>
                      {{Form::close()}}
                    </div>
                  </div>
                </div>
              @endif
            @else
              {{Form::button('Configurar Numeración', array('class'=>'btn btn-primary btn-xs',
                'data-toggle'=>'modal', 'data-target'=>'#modal'))}}
              <div class="modal fade bs-example-modal-sm" id="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <h4 class="modal-title">Ingrese numeración inicial</h4>
                    </div>
                    {{Form::open(array('url'=>'carta/numeracion', 'class'=>'form-horizontal'))}}
                      <div class="modal-body">
                        <div class="form-group">
                          {{Form::label(null, 'Numeración*:', array('class'=>'control-label col-sm-6'))}}
                          <div class="col-sm-6">
                            {{Form::text('numero', null, array('class'=>'form-control input-sm numero', 
                            'id'=>'numero', 'required'=>''))}}
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        {{Form::hidden('empresa_ruc', $empresa->ruc, array('id'=>'empresa_ruc'))}}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="numeracion">Guardar</button>
                      </div>
                    {{Form::close()}}
                  </div>
                </div>
              </div>
            @endif
            </label> - {{date('Y')}}/{{$empresa->nombre}}  
            <small>Redactar</small>
          </h3><br>
          <h3 class="box-title">
              @if(Variable::where('empresa_ruc', '=', $empresa->ruc)->where('anio', '=', date('Y'))->first())
                @if(Variable::where('empresa_ruc', '=', $empresa->ruc)->where('anio', '=', date('Y'))->first()->nombre_anio)
                  {{Variable::where('empresa_ruc', '=', $empresa->ruc)->where('anio', '=', date('Y'))->first()->nombre_anio}}
                @else
                  {{Form::button('Ingresar Nombre del Año', array('class'=>'btn btn-warning btn-xs',
                    'data-toggle'=>'modal', 'data-target'=>'#modalanio'))}}
                  <div class="modal fade" id="modalanio" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <h4 class="modal-title">Ingrese nombre del Año</h4>
                        </div>
                        {{Form::open(array('url'=>'carta/anio', 'class'=>'form-horizontal'))}}
                          <div class="modal-body">
                            <div class="form-group">
                              {{Form::label(null, 'Nombre*:', array('class'=>'control-label col-sm-2'))}}
                              <div class="col-sm-10">
                                {{Form::text('nombre', '', array('class'=>'form-control input-sm mayuscula', 
                                'required'=>'', 'placeholder'=>'NOMBRE DEL AÑO'))}}
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            {{Form::hidden('empresa_ruc', $empresa->ruc, array('id'=>'empresa_ruc'))}}
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                          </div>
                        {{Form::close()}}
                      </div>
                    </div>
                  </div>
                @endif
              @else
                {{Form::button('Ingresar Nombre del Año', array('class'=>'btn btn-warning btn-xs',
                  'data-toggle'=>'modal', 'data-target'=>'#modalanio'))}}
                <div class="modal fade" id="modalanio" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Ingrese nombre del Año</h4>
                      </div>
                      {{Form::open(array('url'=>'carta/anio', 'class'=>'form-horizontal'))}}
                        <div class="modal-body">
                          <div class="form-group">
                            {{Form::label(null, 'Nombre*:', array('class'=>'control-label col-sm-2'))}}
                            <div class="col-sm-10">
                              {{Form::text('nombre', '', array('class'=>'form-control input-sm mayuscula', 
                              'required'=>'', 'placeholder'=>'NOMBRE DEL AÑO'))}}
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          {{Form::hidden('empresa_ruc', $empresa->ruc, array('id'=>'empresa_ruc'))}}
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                      {{Form::close()}}
                    </div>
                  </div>
                </div>
              @endif
          </h3>
        </div>
        {{Form::open(array('url'=>'carta/nuevo', 'class'=>'form-horizontal', 
          'method'=>'post'))}}
          <div class="box-body">
            <div class="form-group">
              {{Form::label(null, 'A*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('destinatario','' , array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'DESTINATARIO', 'required'=>''))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'LUGAR*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('lugar','' , array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'LUGAR', 'required'=>''))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'ASUNTO:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('asunto', '', array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'ASUNTO', 'id'=>'asunto'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'REFERENCIA:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('referencia', '', array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'REFERENCIA', 'id'=>'referencia'))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'FECHA*:', array('class'=>'control-label col-xs-2'))}}
              <div class="col-xs-10">
                {{Form::text('fecha', '', array('class'=>'form-control input-sm mayuscula'
                  ,'placeholder'=>'FECHA', 'required'=>'', 'id'=>'fecha'))}}
              </div>
            </div>
          </div>
          <div class="box-body">
              <div class="form-group">
                <div class="col-xs-12">
                  <textarea id="contenido" name="contenido" rows="10" cols="80" placeholder="Contenido..." required="">
                      Contenido...
                  </textarea>
                </div>
              </div>
              {{Form::button('Guardar', array('class'=>'btn btn-primary', 'type'=>'submit', 
                'id'=>'guardar'))}}
              <a href="<?=URL::to('carta/inicio/'.$empresa->ruc)?>"
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
<script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script>

<script src="<?=URL::to('plugins/jQueryUI/jquery-ui.min.js')?>" type="text/javascript"></script>

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('contenido');

    //desactiva el input text 
    $("#asunto").keypress(function(){
      if($("#referencia").val() == ""){
        $("#referencia").prop('readonly', true);
      }
    });

    $("#asunto").blur(function(){
      if($("#asunto").val() == ""){
        $("#referencia").prop('readonly', false);
      }else{
        $("#referencia").prop('readonly', true);
      }
    });

    $("#referencia").keypress(function(){
      if($("#asunto").val() == ""){
        $("#asunto").prop('readonly', true);
      }
    });

    $("#referencia").blur(function(){
      if($("#referencia").val() == ""){
        $("#asunto").prop('readonly', false);
      }else{
        $("#asunto").prop('readonly', true);
      }
    });

  });
</script>
@stop