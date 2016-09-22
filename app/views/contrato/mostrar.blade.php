@extends('plantilla')

@section('titulo')
contrato | mostrar
@stop

@section('contenido')
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
            <tr>
            	<th>Monto</th>
            	<td>
            		S/. {{$contrato->total}}.00</td>
            </tr>
            @if($contrato->igv)
            	<tr>
              	<th>IGV</th>
              	<td>
              		@if(strpos(round($contrato->total*1.8/1.18)/10, '.') !== false)
              			S/. {{round($contrato->total*1.8/1.18)/10}}0
              		@else
              			S/. {{round($contrato->total*1.8/1.18)/10}}.00
              		@endif
              	</td>
            	</tr>
            @endif
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
	        			<th>BORRAR</th>
	        		</tr>
	            <tr>
	            	<th>{{$contrato->retencion->porcentaje}} %</th>
	            	<td>{{$contrato->retencion->partes}}</td>
	            	<td>
	            		@if(strpos($contrato->total * $contrato->retencion->porcentaje / 100, '.') !== false)
              			S/. {{$contrato->total * $contrato->retencion->porcentaje / 100}}0
              		@else
              			S/. {{$contrato->total * $contrato->retencion->porcentaje / 100}}.00
              		@endif</td>
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