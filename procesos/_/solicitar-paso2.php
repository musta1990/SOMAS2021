<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/base.php';
include_once 'lib/funciones.php';
include_once 'lib/mysqlclass.php';
include_once 'lib/config.php';

$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

$base = base();

session_start();
$iniuser = $_COOKIE['iniuser'];
$login = $_COOKIE['login'];
$perfil = $_COOKIE['perfil'];

(isset($_GET['c'])) ? $getcateg_id=$_GET['c'] :$getcateg_id='';
(isset($_GET['s'])) ? $getsubcateg_id=$_GET['s'] :$getsubcateg_id='';

$conexion = new ConexionBd();

$arrresultado = ObtenerDatosCompania($SistemaCuentaId, $SistemaCompaniaId);
foreach($arrresultado as $i=>$valor){

    $compania_id = utf8_encode($valor["compania_id"]);
    $compania_nombre = utf8_encode($valor["compania_nombre"]);
    $compania_img = utf8_encode($valor["compania_img"]);
    $compania_imgicono = utf8_encode($valor["compania_imgicono"]);
    $compania_urlweb = utf8_encode($valor["compania_urlweb"]);

    $urlcompaniaimg = $UrlFiles."admin/arch/$compania_img";
    $urlcompaniaimgicono = $UrlFiles."admin/arch/$compania_imgicono";

    $titulopagina = "Detalla tu Solicitud - ".$compania_nombre;
    $descripcionpagina = "Detalla tu Solicitud - $compania_nombre. Hazle saber al prestador lo que te encuentras necesitando para que puedan ayudarte de una forma mas rápida. ";

}

  $arrresultado = ObtenerListaSubCategorias($getsubcateg_id, null, $SistemaCuentaId, $SistemaCompaniaId);
  
  foreach($arrresultado as $i=>$valor){

    $subcateg_id = utf8_encode($valor["lista_id"]);  
    $subcateg_nombre = utf8_encode($valor["lista_nombre"]);            
    $subcateg_img = utf8_encode($valor["lista_img"]);   

    $categ_id = utf8_encode($valor["listarel_id"]);  
    $categ_nombre = utf8_encode($valor["listarel_nombre"]);            
    $categ_img = utf8_encode($valor["listarel_img"]);   


    if ($subcateg_img=="" || $subcateg_img=="0.jpg"){
      $subcateg_img  = $categ_img;
    }

    $subcategurl = "solicitar-paso3?c=$getcateg_id&s=$subcateg_id";

    $urlsubcategimg = $UrlFiles."admin/arch/$subcateg_img";    

    $urlcategimg = $UrlFiles."admin/arch/$categ_img";    

  }

/*
$arrresultado = $conexion->doSelect("distinct blog.blog_id, blog_nombre, blog_resumen, blog_url","blog","blog_activo = '1'", null, "blog_orden desc");

$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
$repl = array('a', 'e', 'i', 'o', 'u', 'n');

foreach($arrresultado as $i=>$valor){

    $blog_id = utf8_encode($valor["blog_id"]);
    $blog_nombre = utf8_encode($valor["blog_nombre"]);
    $blog_nombre = utf8_encode($valor["blog_nombre"]);
    $blog_resumen = utf8_encode($valor["blog_resumen"]);
    $blog_fecha = utf8_encode($valor["blog_fecha"]);
    $blog_activo = utf8_encode($valor["blog_activo"]);
    $blog_img = utf8_encode($valor["blog_img"]);
    $blog_orden = utf8_encode($valor["blog_orden"]);
    $blog_categ_nombre = utf8_encode($valor["categ_nombre"]);
    $blog_url = utf8_encode($valor["blog_url"]);
    
    $blog_resumen1 = str_replace($find, $repl, $blog_resumen);
    $blog_resumen1 = preg_replace("/[\r\n|\n|\r]+/", " ", $blog_resumen1);
   

    $urlblog = "art/$blog_id/$blog_url/"; 

    if ( $opcionesblog!=""){
      $colocarsigno = ",";
    }

     $opcionesblog .= "
          $colocarsigno 
          {
            value: '$blog_id',
            label: '$blog_nombre'            
          }

     ";

}

*/

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php echo $base; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">  

    <meta name="description" content="<?php echo $descripcionpagina;?>">
    <meta name="author" content="<?php echo $compania_nombre;?>">

    <title><?php echo $titulopagina;?></title>

    <meta name="keywords" content="<?php echo $titulopagina;?>">
    <meta name="description" content="<?php echo $descripcionpagina;?>">

    <meta property="og:image" content="<?php echo $urlcompaniaimg;?>">
    <meta property="og:title" content="<?php echo $descripcionpagina;?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $compania_urlweb;?>" />
    <meta property="og:description" content="<?php echo $descripcionpagina;?>">
    <meta property="og:site_name" content="<?php echo $compania_nombre;?>" />
    <meta name="robots" content="index, follow">
        
    <meta name="twitter:card" content="summary" />
    
    <meta name="twitter:title" content="<?php echo $descripcionpagina;?>" />
    <meta name="twitter:description" content="<?php echo $descripcionpagina;?>" />
    <meta name="twitter:image" content="<?php echo $urlcompaniaimg;?>" />
  
    <link href="<?php echo $urlcompaniaimgicono;?>" rel="shortcut icon">

      <!-- PLUGINS CSS STYLE -->
      <!-- <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"> -->
      <!-- Bootstrap -->
      <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap-slider.css">
      <!-- Font Awesome -->
      <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <!-- Owl Carousel -->
      <link href="plugins/slick-carousel/slick/slick.css" rel="stylesheet">
      <link href="plugins/slick-carousel/slick/slick-theme.css" rel="stylesheet">
      <!-- Fancy Box -->
      <link href="plugins/fancybox/jquery.fancybox.pack.css" rel="stylesheet">
      <link href="plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet">
      <!-- CUSTOM CSS -->
      <link href="css/style2.css" rel="stylesheet">


      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous"> -->

    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

  <script>
    $( function() {
      var projects = [
        <?php echo $opcionescategoria;?>
      ];
   
      $( "#buscador" ).autocomplete({
        minLength: 0,
        source: projects,
        focus: function( event, ui ) {
          $( "#buscador" ).val( ui.item.label);
          return false;
        },
        select: function( event, ui ) {
          //$( "#project" ).val( ui.item.label );
          $( "#art" ).val(ui.item.value );
          //$( "#project-description" ).html( ui.item.desc );
          //$( "#project-icon" ).attr( "src", "images/" + ui.item.icon );
   
          return false;
        }
      })
      .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          .append( "<div>" + item.label + "</div>" )
          .appendTo( ul );
      };
    } );
    </script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo GoogleAnalytics?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo GoogleAnalytics;?>');
</script>

</head>
<body class="body-wrapper" onload="initialize()">
<style>    
  #map {
    height: 400px;
  }
</style>

<?php include_once "header.php"; ?>

<!--================================
  =            Page Title            =
  =================================-->
<section class="page-title">
  <!-- Container Start -->
  <div class="container">
      <div class="row">
          <div class="col-md-8 offset-md-2 text-center">
              <!-- Title text -->
              <h3>Paso 2.- Detalla tu Solicitud</h3>
          </div>
      </div>
  </div>
  <!-- Container End -->
</section>

<section class="hero-area text-center" style="padding-top: 0px; margin-bottom: 40px">
	<!-- Container Start -->
	<div class="container">
    <div class='row'>
        <div class='col-lg-10 col-10'>
            <div class='heading pb-2' style="text-align: left; padding-top: 10px">
                <h3 style='font-size: 20px; color: #2B2B2B'>
                  Servicio: <img src='<?php echo $urlcategimg;?>' class='img-responsive' style='height: 40px' />             <?php echo $categ_nombre;?>   
                  <a href="solicitar" style="font-size: 16px; color: #A1A1A1">
                    (Modificar)                 
                  </a>                
                </h3>
            </div>               
        </div>
    </div> 
    <div class='row'>
        <div class='col-lg-10 col-10'>
            <div class='heading pb-2' style="text-align: left; padding-top: 10px">
                <h3 style='font-size: 20px; color: #2B2B2B'>
                  Sub Servicio: <img src='<?php echo $urlsubcategimg;?>' class='img-responsive' style='height: 40px' />             <?php echo $subcateg_nombre;?> 
                  <a href="solicitar-paso?c=<?php echo $categ_id;?>" style="font-size: 16px; color: #A1A1A1">
                    (Modificar)                 
                  </a>
                </h3>
            </div>               
        </div>
    </div>  

    <div class='row' style='margin-top:0px;'>      
       
        <div class="col-lg-12">            
          <form target='iframeupload'  action="uploadguardarsolicitud" enctype="multipart/form-data" method="POST">
              <fieldset class="p-3">
                  <div class="form-group">
                      <div class="row">
                          <div class="col-lg-6 py-2s" style="text-align: left !important; margin-top: 10px">
                              <label style="font-size: 16px; font-weight: 600">
                                Titulo de su Solicitud: <span style="color: red">*</span>
                              </label>
                              <input type="text" name="titulo" placeholder="Ej: tengo una falla en... Requiero de..." class="form-control" required >
                          </div>
                          <div class="col-lg-6 py-2s" style="text-align: left !important; margin-top: 10px">
                              <label style="font-size: 16px; font-weight: 600">
                                Ubicación del Servicio:  <span style="color: red">*</span> <span style="font-weight: normal;" id="spaninfoubicacion"></span>
                              </label>
                              <input type="text" id="txtPlaces" name="ubicacion" placeholder="Ej: Busque su dirección" class="form-control" required >
                              <input type="hidden" id="infolatitud" name="infolatitud">
                              <input type="hidden" id="infolongitud" name="infolongitud">    
                              <input type="hidden" id="infocountry" name="infocountry">
                              <input type="hidden" id="infodir" name="infodir"> 
                              <input type="hidden" id="infocalle" name="infocalle">
                              <input type="hidden" id="infocodpostal" name="infocodpostal"> 
                              <input type="hidden" id="infosublocalidad" name="infosublocalidad"> 
                              <input type="hidden" id="inforegion" name="inforegion">  
                              <input type="hidden" id="infociudad" name="infociudad">  
                              <input type="hidden" id="infociudad2" name="infociudad2">
                              <div style="margin-top: 10px"></div>
                              <div id="map"></div>

                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-12 py-2" style="text-align: left;">
                          <label style="font-size: 16px; font-weight: 600">
                            Descripción de la Falla: <span style="color: red">*</span>
                          </label>
                          <textarea class="form-control" name="descripcion" required="required" style="width: 100%" placeholder="Ej: Tengo un problema cuando... Se me rompió... "></textarea>
                      </div>                                
                  </div>                                              
                  <div class="btn-grounp">
                      <button type="submit" class="btn btn-primary mt-2 float-right">Enviar Solicitud</button>
                  </div>
              </fieldset>
              <input type="hidden" name="categ_id" value="<?php echo $categ_id;?>">
              <input type="hidden" name="subcateg_id" value="<?php echo $subcateg_id;?>">
          </form>

          <iframe id="iframeupload" name="iframeupload" height="0" width="0" style="display: none;" ></iframe>
      </div>
    </div>		
	</div>
	<!-- Container End -->
</section>


<?php include_once "footer.php"; ?>

<!-- JAVASCRIPTS -->

<script src="plugins/bootstrap/js/popper.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap-slider.js"></script>
  <!-- tether js -->
<script src="plugins/tether/js/tether.min.js"></script>
<script src="plugins/raty/jquery.raty-fa.js"></script>
<script src="plugins/slick-carousel/slick/slick.min.js"></script>
<script src="plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="plugins/fancybox/jquery.fancybox.pack.js"></script>
<script src="plugins/smoothscroll/SmoothScroll.min.js"></script>

<script async defer  type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPhrxAS4PTETtyWsUE3blCecc7hGacoms&libraries=places&callback=initMap"></script>

<script src="js/script.js"></script>


<script type="text/javascript">

  var geocoder;

  function initialize() {
    geocoder = new google.maps.Geocoder();
  }
  

  function codeLatLng(lat, lng) {          

      //console.log(lat);

      //console.log(lng);

      var latlng = new google.maps.LatLng(lat, lng);

      geocoder.geocode({latLng: latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[1]) {
            var arrAddress = results;



            //var address_component = arrAddress[0];

            console.log(arrAddress[0]);

            var address_components = arrAddress[0].address_components;

            var direccion = arrAddress[0].formatted_address;
            var place_id = arrAddress[0].place_id;

            //console.log(place_id);

            document.getElementById("txtPlaces").value = direccion;
            document.getElementById("infolatitud").value = lat;
            document.getElementById("infolongitud").value = lng;
            document.getElementById("spaninfoubicacion").innerHTML = " (Asignada por Ubicación Actual)";


            var components={}; 
            jQuery.each(address_components, function(k,v1) {jQuery.each(v1.types, function(k2, v2){components[v2]=v1.long_name});})

            //console.log(components);
                
            var country = components.country;
            var calle = components.route;
            var codpostal = components.postal_code;
            var sublocalidad = components.sublocality;
            var ciudad = components.administrative_area_level_1;
            var ciudad2 = components.administrative_area_level_2;

            document.getElementById("infocountry").value = country;
            document.getElementById("infodir").value = direccion;
            document.getElementById("infocalle").value = calle;
            document.getElementById("infociudad").value = ciudad;
            document.getElementById("infociudad2").value = ciudad2;
            document.getElementById("infocodpostal").value = codpostal;
            document.getElementById("infosublocalidad").value = sublocalidad;



          } else {
            alert("No results found");
          }
        } else {
          alert("Geocoder failed due to: " + status);
        }
      });
  }

  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
      infoWindow.setPosition(pos);
      infoWindow.setContent(browserHasGeolocation ?
                            'Error: The Geolocation service failed.' :
                            'Error: Your browser doesn\'t support geolocation.');
      infoWindow.open(map);
    }

  function initMap() {

      var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 0, lng: 0},
        zoom: 12
      });
      var infoWindow = new google.maps.InfoWindow;
      var input = document.getElementById('txtPlaces');
      //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      var autocomplete = new google.maps.places.Autocomplete(input);
      autocomplete.bindTo('bounds', map);

      var infowindow = new google.maps.InfoWindow();
      var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
      });

      // Try HTML5 geolocation.
      if (navigator.geolocation) {        
        navigator.geolocation.getCurrentPosition(function(position) {
          var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };

          codeLatLng(position.coords.latitude, position.coords.longitude);


          //console.log(position);

          infoWindow.setPosition(pos);
          infoWindow.setContent('Ubicación Actual.');
          infoWindow.open(map);
          map.setCenter(pos);
        }, function() {
          handleLocationError(true, infoWindow, map.getCenter());
        });
      } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
      }




      autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
              window.alert("Autocomplete's returned place contains no geometry");
              return;
          }
    
          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
              map.fitBounds(place.geometry.viewport);                    
              map.setZoom(12);
          } else {
              map.setCenter(place.geometry.location);
              map.setZoom(12);
          }
        
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);
      
          var address = '';
          if (place.address_components) {                   
              var address_components = place.address_components;   

              var components={}; 
              jQuery.each(address_components, function(k,v1) {jQuery.each(v1.types, function(k2, v2){components[v2]=v1.long_name});})

              var latitude = place.geometry.location.lat();
              var longitude = place.geometry.location.lng();
              var direccion = place.formatted_address;
              var country = components.country;
              var calle = components.route;
              var codpostal = components.postal_code;
              var sublocalidad = components.sublocality;
              var ciudad = components.administrative_area_level_1;
              var ciudad2 = components.administrative_area_level_2;

              document.getElementById("infolatitud").value = latitude;
              document.getElementById("infolongitud").value = longitude;
              document.getElementById("infocountry").value = country;
              document.getElementById("infodir").value = direccion;
              document.getElementById("infocalle").value = calle;
              document.getElementById("infociudad").value = ciudad;
              document.getElementById("infociudad2").value = ciudad2;
              document.getElementById("infocodpostal").value = codpostal;
              document.getElementById("infosublocalidad").value = sublocalidad;

              document.getElementById("spaninfoubicacion").innerHTML = " ";
          }

      })

      
  }    
</script>

</body>
</html>



