<!DOCTYPE html>
<html>
  <head>
    <title>Registro de Asistencia</title>
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?=URL::to('bootstrap/css/bootstrap.min.css')?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <style>
      #map{
        width: 100%;
        height: 200px;
        border: 1px solid #d0d0d0;
      }
      h1{
        font-size: 15px;
      }
    </style>
  </head>
  <body onLoad="localize()">
    <div class="container-fluid">
      <div class="page-header">
        <h1>Registro de asistencia {{$trabajador->persona->nombre}} 
          {{$trabajador->persona->apellidos}} <small id="estado"></small></h1>
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
        <div class="col-xs-12">
          <div>
            {{Form::open(array('url'=>'asistencia/registrar'))}}
              <div class="form-group">
                <select class="form-control input-sm" id="trabajo" required='' name="punto_id">
                  <option value="">TRABAJO</option>
                  @foreach($trabajador->puntos as $punto)
                    <option value="{{$punto->id}}">{{$punto->nombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <select class="form-control input-sm" id="turno_id" disabled='' required='' name='turno_id'>
                  <option value="">TURNO</option>
                  @foreach(Turno::all() as $turno)
                    <option value="{{$turno->id}}">{{$turno->nombre}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <select class="form-control input-sm" id="registro" disabled='' required='' name='registro'>
                  <option value="">REGISTRO</option>
                  <option value="1">ENTRADA</option>
                  <option value="0">SALIDA</option>
                </select>
              </div>
              <div class="form-group">
                {{Form::label('Día:')}}
                {{Form::label('dia', date('d-m-Y'))}}
              </div>
              <div class="form-group">
                {{Form::label('Hora de Registro:')}}
                {{Form::label('entrada', date('H:i:s'))}}
              </div>
              <div class="form-group">
                {{Form::button('Registrar', array('type'=>'submit', 'disabled'=>'',
                'id'=>'boton'))}}
              </div>
              {{Form::hidden('latitud', null, array('id'=>'latitud'))}}
              {{Form::hidden('longitud', null, array('id'=>'longitud'))}}
              {{Form::hidden('trabajador_id', $trabajador->id, array('id'=>'trabajador_id'))}}
              {{Form::hidden('cliente_ruc', null, array('id'=>'cliente_ruc'))}}
            {{Form::close()}}
          </div>
        </div>
        <div class="col-xs-12">
          Tu Ubicación actual es:
          <div id="map"></div>
        </div>
      </div>
    </div>
    <!-- jQuery 2.2.3 -->
    <script src="<?=URL::to('plugins/jQuery/jquery-2.2.3.min.js')?>"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="<?=URL::to('bootstrap/js/bootstrap.min.js')?>"></script>
    <script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=AIzaSyDDcLQ86bx3w8rFcuUMfoJuGmsz2hTMlbA'></script>
    <script type="text/javascript">
      function localize(){
        /* Si se puede obtener la localización */
        if (navigator.geolocation){
          navigator.geolocation.getCurrentPosition(mapa,error);
        }
        /* Si el navegador no soporta la recuperación de la geolocalización */
        else{
          alert('¡Oops! Tu navegador no soporta geolocalización.');
        }
      }

      function mapa(pos){

        /* Obtenemos los parámetros de la API de geolocalización HTML*/
        var latitud = pos.coords.latitude;
        var longitud = pos.coords.longitude;
        var precision = pos.coords.accuracy;

        $("#latitud").val(latitud);
        $("#longitud").val(longitud);

        /* A través del DOM obtenemos el div que va a contener el mapa */
        var contenedor = document.getElementById("map")

        /* Posicionamos un punto en el mapa con las coordenadas que nos ha proporcionado la API*/
        var centro = new google.maps.LatLng(latitud,longitud);

        /* Definimos las propiedades del mapa */
        var propiedades = {
          zoom: 15,
          center: centro,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        /* Creamos el mapa pasandole el div que lo va a contener y las diferentes propiedades*/
        var map = new google.maps.Map(contenedor, propiedades);

        /* Un servicio que proporciona la API de GM es colocar marcadores sobre el mapa */
        var marcador = new google.maps.Marker({
          position: centro,
          map: map,
          title: "Tu localizacion"
        });
      }

      /* Gestion de errores */
      function error(errorCode){
        if(errorCode.code == 1)
          alert("No has permitido buscar tu localizacion")
        else if (errorCode.code==2)
          alert("Posicion no disponible")
        else
          alert("Ha ocurrido un error")
      }
    </script>
    <script type="text/javascript">
      $(function(){
        $("#trabajo").change(function(){
          if($(this).val() != ""){
            $.ajax({
              url: "<?=URL::to('asistencia/posicion')?>",
              type: 'GET',
              data: {punto: $(this).val(), latitud: $("#latitud").val(),
                longitud: $("#longitud").val(), trabajador_id: $("#trabajador_id").val()},
              dataType: 'JSON',
              error: function(){
                alert("hubo un error en la conexión con el controlador");
              },
              success: function(respuesta){
                if(respuesta != 0){
                  $("#cliente_ruc").val(respuesta['ruc']);
                  $("#estado").html("Puede marcar su asistencia");
                  $("#turno_id").prop("disabled", false);
                  $("#registro").prop("disabled", false);
                  $("#boton").prop("disabled", false);
                }else{
                  alert("no esta en el punto trabajo");
                  $("#estado").html("");
                  $("#turno_id").prop("disabled", true);
                  $("#registro").prop("disabled", true);
                  $("#boton").prop("disabled", true);
                }
              }
            });
          }else{
            $("#estado").html("");
            $("#turno_id").prop("disabled", true);
            $("#registro").prop("disabled", true);
            $("#boton").prop("disabled", true);
          }
        });
      });
    </script>
  </body>
</html>