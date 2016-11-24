@extends('plantilla')

@section('titulo')
contrato | mostrar
@stop

@section('estilos')
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
    Contrato
    <small>mostrar</small>
	</h1>
	<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Contrato</a></li>
    <li class="active">Mostrar</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
    	@if(Session::has('rojo'))
      	<div class="alert alert-danger alert-dismissable">
        	<i class="fa fa-info"></i>
        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
        		</button>
        	<b>Alerta!</b> {{ Session::get('rojo')}}
      	</div>
	  	@elseif(Session::has('verde'))
      	<div class="alert alert-success alert-dismissable">
        	<i class="fa fa-info"></i>
        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
        		</button>
        	<b>Excelente!</b> {{ Session::get('verde')}}
      	</div>
	  	@elseif(Session::has('naranja'))
      	<div class="alert alert-warning alert-dismissable">
        	<i class="fa fa-info"></i>
        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
        		</button>
        	<b>Cuidado!</b> {{ Session::get('naranja')}}
      	</div>
	  	@endif
		</div>
    <div class="col-md-6">
    	<div class="box">
        <div class="box-header">
          	<h3 class="box-title">Datos del Contrato</h3><br>
        </div>
        <div class="box-body no-padding">
        	<table class="table table-striped">
            <tr>
            	<th>Empresa</th>
            	<td>{{$contrato->empresa->nombre}}</td>
            </tr>
            <tr>
            	<th>Cliente</th>
            	<td>{{$contrato->cliente->nombre}}</td>
            </tr>
            <tr>
            	<th>inicio</th>
            	<td>{{date('d-m-Y', strtotime($contrato->inicio))}}</td>
            </tr>
            <tr>
            	<th>Fin</th>
            	<td>{{date('d-m-Y', strtotime($contrato->fin))}}</td>
            </tr>
            @if($contrato->igv)
              <tr>
                <th>Sub Total</th>
                <td>S/. {{moneda($contrato->subtotal)}}</td>
              </tr>
            	<tr>
              	<th>IGV</th>
              	<td>S/. {{moneda($contrato->igv)}}</td>
            	</tr>
            @endif
            <tr>
              <th>Total</th>
              <td>
                S/. {{moneda($contrato->total)}}</td>
            </tr>
        	</table>
        </div>
    	</div>
    	<a href="<?=URL::to('contrato/inicio/'.$contrato->empresa->ruc)?>" class="btn 
    		btn-primary">Volver a {{$contrato->empresa->nombre}}</a>
    </div>
    <div class="col-md-6">
    	<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Agregar Retención</h3>
        </div>
        {{Form::open(array('url'=>'contrato/retencion/'.$contrato->id, 'class'=>'form-horizontal'))}}
        	<div class="box-body">
            <div class="form-group">
            	{{Form::label(null, 'Porcentaje %*:', array('class'=>'control-label col-sm-4'))}}
            	<div class="col-sm-8">
            		{{Form::text('porcentaje', null, array('class'=>'form-control input-sm porcentaje',
            			'placeholder'=>'PORCENTAJE', 'required'=>''))}}
            	</div>
            </div>
            <div class="form-group">
            	{{Form::label(null, 'Partes*:', array('class'=>'control-label col-sm-4'))}}
            	<div class="col-sm-8">
            		{{Form::text('partes', null, array('class'=>'form-control input-sm',
            			'placeholder'=>'PARTES', 'required'=>''))}}
            	</div>
            </div>
        	</div>
        	<div class="box-footer">
          	<button type="submit" class="btn btn-primary">Agregar</button>
        	</div>
        {{Form::close()}}
      </div>
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Agregar Punto de Trabajo</h3>
        </div>
        {{Form::open(array('url'=>'punto', 'class'=>'form-horizontal'))}}
          <div class="box-body">
            <div class="form-group">
              {{Form::label(null, 'Nombre*:', array('class'=>'control-label col-sm-4'))}}
              <div class="col-sm-8">
                {{Form::text('nombre', null, array('class'=>'form-control input-sm mayuscula',
                  'placeholder'=>'NOMBRE', 'required'=>''))}}
              </div>
            </div>
            <div class="form-group">
              {{Form::label(null, 'Coordenadas*:', array('class'=>'control-label col-sm-4'))}}
              <div class="col-sm-8">
                {{Form::text('coordenadas', null, array('class'=>'form-control input-sm',
                  'placeholder'=>'COORDENADAS', 'required'=>''))}}
              </div>
            </div>
          </div>
          <div class="box-footer">
            {{Form::hidden('contrato_id', $contrato->id)}}
            <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
  @if($contrato->retencion)
		<div class="row">
	    <div class="col-md-12">
	    	<div class="box">
	        <div class="box-header">
	          	<h3 class="box-title">Retención</h3>
	        </div>
	        <div class="box-body no-padding">
	        	<table class="table table-striped">
	        		<tr>
	        			<th>PORCENTAJE</th>
	        			<th>PARTES</th>
	        			<th>MONTO</th>
                <th>VER PAGOS</th>
	        			<th>BORRAR</th>
	        		</tr>
	            <tr>
	            	<th>{{$contrato->retencion->porcentaje}} %</th>
	            	<td>{{$contrato->retencion->partes}}</td>
	            	<td>S/. {{moneda(round($contrato->subtotal * $contrato->retencion->porcentaje)/100)}}</td>
                <td>
                  {{Form::button('Ver Pagos', array('class'=>'btn btn-info btn-xs', 'data-toggle'=>'modal'
                    , 'data-target'=>'#verPagos'.$contrato->retencion->id))}}
                  <div class="modal fade modal-info" id="verPagos{{$contrato->retencion->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">PAGOS DE {{$contrato->cliente->nombre}}</h4>
                        </div>
                        <div class="modal-body">
                          
                        </div>
                        <div class="modal-footer clearfix">
                          <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-outline pull-left">Guardar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
	            	<td>
	            		{{Form::button('Borrar', array('class'=>'btn btn-danger btn-xs', 'data-toggle'=>'modal'
	            			, 'data-target'=>'#borrar'.$contrato->retencion->id))}}
	            		<div class="modal fade modal-danger" id="borrar{{$contrato->retencion->id}}" tabindex="-1" role="dialog"
										aria-labelledby="myModalLabel" aria-hidden="true">
								  	<div class="modal-dialog">
									    <div class="modal-content">
								      	<div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title">Borrar Retencion en {{$contrato->cliente->nombre}}</h4>
								      	</div>
								      	{{Form::open(array('url'=>'contrato/retencion/'.$contrato->retencion->id,
								      		'class'=>'form-horizontal', 'method'=>'delete'))}}
									      	<div class="modal-body">
						                <div class="form-group">
						                	<p class="col-sm-12">PARA BORRAR LA RETENCION DE ESTE CONTRATO DEBE INTRODUCIR
						                		SU CONTRASEÑA PARA AUTORIZAR ESTE PROCESO.</p>
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
										        <button type="button" class="btn btn-outline" data-dismiss="modal">Cancelar</button>
										        <button type="submit" class="btn btn-outline pull-left">Guardar</button>
									      	</div>
								      	{{Form::close()}}
									    </div>
								  	</div>
									</div>
	            	</td>
	            </tr>
	        	</table>
	        </div>
	    	</div>
	    </div>
		</div>
	@endif
  @if($contrato->puntos)
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
              <h3 class="box-title">Puntos de Trabajo</h3>
          </div>
          <div class="box-body no-padding">
            <table class="table table-striped">
              <tr>
                <th>NOMBRE</th>
                <th>LATITUD</th>
                <th>LONGITUD</th>
                <th>BORRAR</th>
              </tr>
              @foreach($contrato->puntos as $punto)
              <tr>
                <td>{{$punto->nombre}}</td>
                <td>{{$punto->latitud}}</td>
                <td>{{$punto->longitud}}</td>
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
                          <h4 class="modal-title">Borrar Punto {{$punto->nombre}} en {{$contrato->cliente->nombre}}</h4>
                        </div>
                        {{Form::open(array('url'=>'punto/'.$punto->id,
                          'class'=>'form-horizontal', 'method'=>'delete'))}}
                          <div class="modal-body">
                            <div class="form-group">
                              <p class="col-sm-12">PARA BORRAR EL PUNTO DE TRABAJO DE ESTE CONTRATO DEBE INTRODUCIR
                                SU CONTRASEÑA PARA AUTORIZAR ESTE PROCESO.</p>
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
  @endif
	<div class="row">
    <div class="col-md-12">
      	<div class="box">
	        <div class="box-header">
	          	<h3 class="box-title">Documentos</h3>
	        </div>
	        <div class="box-body no-padding">
	          	<table class="table table-striped">
	          		@foreach($contrato->documentos as $documento)
		            <tr>
		            	<table class="table">
		            		<tr>
				              	<th>{{$documento->nombre}}</th>
		            		</tr>
		            		<tr>
		            			<td>
						            <div class="embed-responsive embed-responsive-16by9">
									  	<iframe class="embed-responsive-item" src="<?=URL::to('documentos/contratos/'.$documento->pivot->nombre)?>"></iframe>
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
@stop