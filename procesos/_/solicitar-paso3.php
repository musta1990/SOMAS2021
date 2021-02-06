<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/base.php';
include_once 'lib/funciones.php';
include_once 'lib/mysqlclass.php';
include_once 'lib/config.php';
include_once 'lib/xajax_0.2.4/xajax.inc.php';

$xajax = new xajax('lib/ajx_fnci.php');
$xajax->registerFunction('registrarusuario');
$xajax->registerFunction('ingresarusuario');
$xajax->printJavascript('lib/');


$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

$base = base();

(isset($_GET['id'])) ? $getsolicitud_id=$_GET['id'] :$getsolicitud_id='';

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

    $titulopagina = "Completa el Registro - ".$compania_nombre;
    $descripcionpagina = "Completa el Registro - $compania_nombre. Para que los prestadores puedan comunicarse contigo y ofrecer una solución rápida a tu solicitud. ";

}

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
<body class="body-wrapper">

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
              <h3>Paso 3.- Completa tus datos de contacto</h3>
          </div>
      </div>
  </div>
  <!-- Container End -->
</section>

<section class="hero-area text-center" style="padding-top: 40px; margin-bottom: 40px">
	<!-- Container Start -->
	<div class="container">
	    <div class='row'>
	    	<div class="col-lg-1">

	    	</div>
	    	<div class="col-lg-5 col-md-8 align-item-center">
	            <div class="border">
	                <h3 class="bg-gray p-4" style="text-align: center">Registre sus Datos o <a href="solicitar-paso3?id=<?php echo $getsolicitud_id;?>#iniciar-sesion">Inicia Sesión</a></h3>
	                <form action="javascript:registrarusuariosolicitud()" >
                        <fieldset class="p-4">                            
                                                       
                            <input type="text" placeholder="Nombre *" id="name" name="name" required="required" class="border p-3 w-100 my-2">

                            <input type="text" placeholder="Apellido *" id="lastname" name="lastname" required="required" class="border p-3 w-100 my-2">
                            
                            <input type="text" placeholder="Telefono *" id="phone" name="phone" required="required" class="border p-3 w-100 my-2">

                            <input type="text" placeholder="WhatsApp " id="whatsapp" name="whatsapp"class="border p-3 w-100 my-2">
                           
                            <input type="email" placeholder="Email *" id="email" name="email" required="required" class="border p-3 w-100 my-2">
                            
                            <input type="password" placeholder="Crea tu Clave *" id="password" name="password" required="required" class="border p-3 w-100 my-2">
                            
                            <br />

                            <input type="checkbox" required="required" id="requeridoterminos"  style="cursor: pointer;">
                            <label for="requeridoterminos" style="cursor: pointer;">Acepto los </label>
                            
                            <a href="terminos-y-condiciones" target="_blank" style="font-size: 14px; font-weight: 600">
                              Términos y Condiciones
                            </a>
                            
                            <center>
                                <button type="submit" class="d-block py-3 px-5 bg-primary text-white border-0 rounded font-weight-bold mt-3">Registrarse</button>
                            </center>
                                                       
                        </fieldset>

                        <input type="hidden" id="solid" name="solid" value="<?php echo $getsolicitud_id;?>">                        
                    </form>
	            </div>
	        </div>

	        <div class="col-lg-5 col-md-8 align-item-center" id="iniciar-sesion">
	            <div class="border">
	                <h3 class="bg-gray p-4" style="text-align: center">Iniciar Sesión</h3>
	                <form action="javascript:ingresarusuariosolicitud()" >
	                    <fieldset class="p-4">
	                        <input type="text" placeholder="Email *" id="email2" name="email" required="required" class="border p-3 w-100 my-2" />
	                        <input type="password" placeholder="Clave *" id="password2" name="password" class="border p-3 w-100 my-2" />
	                        <br />
	                        <center>
	                            <button type="submit" class="d-block py-3 px-5 bg-primary text-white border-0 rounded font-weight-bold mt-3">Iniciar Sesión</button>
	                        </center>
	                        <a class="mt-3 d-block  text-primary" href="olvido-clave">Se te olvidó tu clave?  &nbsp Click aquí para recuperarla</a>	                        
	                    </fieldset>
	                </form>
	            </div>
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

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPhrxAS4PTETtyWsUE3blCecc7hGacoms&libraries=places"></script>
<script src="js/script.js"></script>
<script src="js/buscgmaps.js"></script>

</body>
</html>



