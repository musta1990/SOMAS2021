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

session_start();
$iniuser = $_COOKIE['iniuser'];
$login = $_COOKIE['login'];
$perfil = $_COOKIE['perfil'];

$base = base();

(isset($_GET['id'])) ? $getsolicitudserv_id=$_GET['id'] :$getsolicitudserv_id='';

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

    $titulopagina = "Solicitud - ".$compania_nombre;
    $descripcionpagina = "Solicitud - $compania_nombre. Ya tienes tu solicitud abierta, ya puedes comenzar a recibir propuestas de los profesionales ";

}



$arrresultado = $conexion->doSelect("
  solicitudservicio.solicitudserv_id, solicitudservicio.usuario_id, solicitudservicio.solicitudserv_titulo, 
  solicitudservicio.solicitudserv_descrip, solicitudservicio.solicitudserv_latitud, solicitudservicio.solicitudserv_longitud,
  solicitudservicio.solicitudserv_dircompleta, solicitudservicio.solicitudserv_infodir, solicitudservicio.solicitudserv_infocalle,
  solicitudservicio.solicitudserv_infocodpostal, solicitudservicio.solicitudserv_infociudad, 
  solicitudservicio.solicitudserv_infociudad2, solicitudservicio.solicitudserv_infosublocalidad, 
  solicitudservicio.solicitudserv_inforegion, solicitudservicio.solicitudserv_infocountry, 
  solicitudservicio.cuenta_id, solicitudservicio.compania_id, solicitudservicio.solicitudserv_activo, solicitudservicio.solicitudserv_eliminado,
  solicitudservicio.solicitudserv_fechareg, solicitudservicio.usuario_idreg, 
  usuario.usuario_nombre, usuario.usuario_apellido, usuario.usuario_img, 
  cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
  cuenta.usuario_apellido as cuenta_apellido, compania_nombre, 

  solicitudserv_codigo, solicitudserv_codigoint, solicitudservicio.l_estatus_id, 
  estatus.lista_nombre as estatus_nombre,
  solicitudservicio.l_categ_id, solicitudservicio.l_subcateg_id,
  categoria.lista_nombre as categ_nombre, categoria.lista_img as categ_img,
  subcategoria.lista_nombre as subcateg_nombre, subcategoria.lista_img as subcateg_img

  ",
  "solicitudservicio
    inner join lista categoria on categoria.lista_id = solicitudservicio.l_categ_id
    inner join lista subcategoria on subcategoria.lista_id = solicitudservicio.l_subcateg_id

    inner join usuario on usuario.usuario_id = solicitudservicio.usuario_id
    inner join usuario cuenta on cuenta.usuario_id = solicitudservicio.cuenta_id
    inner join compania on compania.compania_id = solicitudservicio.compania_id
    inner join lista estatus on estatus.lista_id = solicitudservicio.l_estatus_id

  ",
  "solicitudserv_activo = '1' and solicitudserv_id = '$getsolicitudserv_id' and solicitudservicio.usuario_id = '$iniuser' and solicitudservicio.cuenta_id = '$SistemaCuentaId' and solicitudservicio.compania_id = '$SistemaCompaniaId'");

foreach($arrresultado as $i=>$valor){

  $categ_nombre = utf8_encode($valor["categ_nombre"]);
  $categ_img = utf8_encode($valor["categ_img"]);
  $subcateg_nombre = utf8_encode($valor["subcateg_nombre"]);
  $subcateg_img = utf8_encode($valor["subcateg_img"]);

  $solicitudserv_codigo = utf8_encode($valor["solicitudserv_codigo"]);
  $solicitudserv_codigoint = utf8_encode($valor["solicitudserv_codigoint"]);
  $l_estatus_id = utf8_encode($valor["l_estatus_id"]);
  $estatus_nombre = utf8_encode($valor["estatus_nombre"]);

  $solicitudserv_id = utf8_encode($valor["solicitudserv_id"]);
  $t_usuario_id = utf8_encode($valor["usuario_id"]);
  $solicitudserv_titulo = utf8_encode($valor["solicitudserv_titulo"]);
  $solicitudserv_descrip =nl2br(utf8_encode($valor["solicitudserv_descrip"]));
  $solicitudserv_latitud = utf8_encode($valor["solicitudserv_latitud"]);
  $solicitudserv_longitud = utf8_encode($valor["solicitudserv_longitud"]);
  $solicitudserv_dircompleta = utf8_encode($valor["solicitudserv_dircompleta"]);
  $solicitudserv_infodir = utf8_encode($valor["solicitudserv_infodir"]);
  $solicitudserv_infocalle = utf8_encode($valor["solicitudserv_infocalle"]);
  $solicitudserv_infocodpostal = utf8_encode($valor["solicitudserv_infocodpostal"]);
  $solicitudserv_infociudad = utf8_encode($valor["solicitudserv_infociudad"]);
  $solicitudserv_infociudad2 = utf8_encode($valor["solicitudserv_infociudad2"]);
  $solicitudserv_infosublocalidad = utf8_encode($valor["solicitudserv_infosublocalidad"]);
  $solicitudserv_inforegion = utf8_encode($valor["solicitudserv_inforegion"]);
  $solicitudserv_infocountry = utf8_encode($valor["solicitudserv_infocountry"]);
  $t_cuenta_id = utf8_encode($valor["cuenta_id"]);
  $t_compania_id = utf8_encode($valor["compania_id"]);
  $solicitudserv_activo = utf8_encode($valor["solicitudserv_activo"]);
  $solicitudserv_fechareg = utf8_encode($valor["solicitudserv_fechareg"]);
  $usuario_nombre = utf8_encode($valor["usuario_nombre"]);
  $usuario_apellido = utf8_encode($valor["usuario_apellido"]);
  $usuario_img = utf8_encode($valor["usuario_img"]);
  $compania_nombre = utf8_encode($valor["compania_nombre"]);

  $compania_nombre = utf8_encode($valor["compania_nombre"]);
  $l_categ_id = utf8_encode($valor["l_categ_id"]);
  $l_subcateg_id = utf8_encode($valor["l_subcateg_id"]);

  $usuario = $usuario_nombre." ".$usuario_apellido." ";

  $cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
  $cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
  $cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
  $cuenta = $cuenta_nombre." ".$cuenta_apellido." ";


  $titulo = "Solicitud #$solicitudserv_codigo";

  $urlcateg = $UrlFiles."admin/arch/$categ_img";

  $urlsubcateg = $UrlFiles."admin/arch/$subcateg_img";

}


$displaynonegooglemaps=" style ='display: none'";
if ($solicitudserv_latitud!=""){
  $displaynonegooglemaps = "";
}



$arrresultado = $conexion->doSelect("cliente.usuario_id, cliente.usuario_codigo, cliente.usuario_email, cliente.usuario_clave, cliente.usuario_nombre, cliente.usuario_apellido, cliente.usuario_telf,  cliente.usuario_activo, cliente.usuario_img, cliente.perfil_id, cliente.l_tipodocumento_id,
    cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
    cuenta.usuario_apellido as cuenta_apellido, compania_nombre,
    DATE_FORMAT(cliente.usuario_fechareg,'%d/%m/%Y %H:%i:%s') as usuario_fechareg,

    usuarioservicio.usuarioservicio_id, usuarioservicio.usuario_id, usuarioservicio.l_categservicio_id,
    usuarioservicio.l_subcategservicio_id, 
    usuarioservicio.cuenta_id, usuarioservicio.compania_id, 
    usuarioservicio.usuarioservicio_activo, usuarioservicio_eliminado, 
    usuarioservicio.usuarioservicio_fechareg, usuarioservicio.usuario_idreg,

    categoria.lista_nombre as categ_nombre, categoria.lista_img as categ_img, 
    subcategoria.lista_nombre as subcateg_nombre, subcategoria.lista_img as subcateg_img

    ",
    "usuario cliente
        inner join usuarioservicio on usuarioservicio.usuario_id = cliente.usuario_id
        inner join usuario cuenta on usuarioservicio.cuenta_id = cuenta.usuario_id
        inner join compania on compania.compania_id = usuarioservicio.compania_id
        inner join lista categoria on categoria.lista_id = usuarioservicio.l_categservicio_id           
        inner join lista subcategoria on subcategoria.lista_id = usuarioservicio.l_subcategservicio_id
    ",
    "cliente.usuario_activo = '1' and usuarioservicio_activo = '1' and usuarioservicio.l_categservicio_id = '$l_categ_id' and usuarioservicio.l_subcategservicio_id = '$l_subcateg_id' and cliente.cuenta_id = '$SistemaCuentaId' and cliente.compania_id = '$SistemaCompaniaId' ");
$totalprofesionales = 0;
foreach($arrresultado as $i=>$valor){
    $totalprofesionales = utf8_encode($valor["usuarioservicio_id"]);   
}

if ($totalprofesionales=="0"){
  $totalprofesionales = "1";
  $colocarnoprofesionales = ".";
}

if ($totalprofesionales=="1"){
  $tituloprofesionalnotificado =" $totalprofesionales Profesional Notificado ";
}else{
  $tituloprofesionalnotificado =" $totalprofesionales Profesionales Notificado ";
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
          <div class='row'>            
            <div class='col-lg-10 col-10'>
                <div class='heading pb-2' style="text-align: left; padding-top: 10px">
                    <h3 style='font-size: 25px;'>
                      Solicitud Finalizada #<?php echo $solicitudserv_codigo;?>
                    </h3>
                </div>               
            </div>
        </div>  
      </div>
      <!-- Container End -->
  </section>

<section class="hero-area text-center" style="padding-top: 0px">
	<!-- Container Start -->
	<div class="container">
    <div class='row' style='margin-top:15px;'>      
        <div class='col-lg-12 '>
            <div class='heading pb-2' style="text-align: left; padding-top: 10px">
                <h3 style='font-size: 18px; line-height: 30px; font-weight: normal;'>
                  Tu solicitud fue enviada a todos los proveedores que cumplen con tu búsqueda.
                  <br>
                  En breve recibirás el contacto de cada Prestador de Servicio<?php echo $colocarnoprofesionales;?>
                </h3>
            </div>               
        </div>
    </div>	
     <div class='row' style="display: none;">
        <div class='col-lg-12 col-12'>
            <div class='heading pb-2' style="text-align: left; padding-top: 15px">
                <h3 style='font-size: 20px; color: #2B2B2B'>
                  <span style="font-size: 20px; background: #0D82B9; border-radius: 20px; color: #FFF; padding: 10px 17px">
                    <i class="fa fa-bell"></i>&nbsp <?php echo $tituloprofesionalnotificado;?>
                  </span> 
                </h3>
            </div>               
        </div>       
    </div> 

    <div class='row'>
        <div class='col-lg-10 col-10'>
            <div class='heading pb-2' style="text-align: left; padding-top: 10px">
                <h3 style='font-size: 20px; color: #2B2B2B'>
                  Solicitud Enviada                                      
                </h3>
            </div>               
        </div>
    </div> 

    <div class='row'>
        <div class='col-lg-3 col-4'>
            <div class='heading pb-2' style="text-align: right; padding-top: 15px">
                <h3 style='font-size: 20px; color: #2B2B2B'>
                  Servicio:                                           
                </h3>
            </div>               
        </div>
        <div class='col-lg-8 col-8'>
            <div class='heading pb-2' style="text-align: left; padding-top: 10px">                
                <span style="font-weight: normal; font-size: 20px">
                  <?php echo $categ_nombre;?> <img src='<?php echo $urlcateg;?>' class='img-responsive' style='height: 40px' />
                </span>                                                      
            </div>               
        </div>
    </div> 
    <div class='row'>
        <div class='col-lg-3 col-4'>
            <div class='heading pb-2' style="text-align: right; padding-top: 15px">
                <h3 style='font-size: 20px; color: #2B2B2B'>
                  Sub Servicio:                                           
                </h3>
            </div>               
        </div>
        <div class='col-lg-8 col-8'>
            <div class='heading pb-2' style="text-align: left; padding-top: 10px">                
                <span style="font-weight: normal; font-size: 20px">
                  <?php echo $subcateg_nombre;?> <img src='<?php echo $urlsubcateg;?>' class='img-responsive' style='height: 40px' />
                </span>                                                      
            </div>               
        </div>
    </div> 
    <div class='row'>
        <div class='col-lg-3 col-4'>
            <div class='heading pb-2' style="text-align: right; padding-top: 15px">
                <h3 style='font-size: 20px; color: #2B2B2B'>
                  Titulo de Solicitud:                                           
                </h3>
            </div>               
        </div>
        <div class='col-lg-8 col-8'>
            <div class='heading pb-2' style="text-align: left; padding-top: 10px">
                <span style="font-weight: normal; font-size: 20px">
                  <?php echo $solicitudserv_titulo;?>
                </span> 
            </div>               
        </div>
    </div> 
    <div class='row'>
        <div class='col-lg-3 col-4'>
            <div class='heading pb-2' style="text-align: right; padding-top: 15px">
                <h3 style='font-size: 20px; color: #2B2B2B'>
                  Descripción del Problema:                                           
                </h3>
            </div>               
        </div>
        <div class='col-lg-8 col-8'>
            <div class='heading pb-2' style="text-align: left; padding-top: 10px">
                <span style="font-weight: normal; font-size: 20px">
                  <?php echo $solicitudserv_descrip;?>
                </span> 
            </div>               
        </div>
    </div> 
    <div class='row'>
        <div class='col-lg-3 col-4'>
            <div class='heading pb-2' style="text-align: right; padding-top: 15px">
                <h3 style='font-size: 20px; color: #2B2B2B'>
                  Ubicación de la Solicitud:                                           
                </h3>
            </div>               
        </div>
        <div class='col-lg-8 col-8'>
            <div class='heading pb-2' style="text-align: left; padding-top: 10px">
                <span style="font-weight: normal; font-size: 20px">
                  <?php echo $solicitudserv_infodir;?>
                </span> 
            </div>  
            <div class="form-group " <?php echo $displaynonegooglemaps;?> >                
                <iframe src="https://maps.google.com/maps?q=<?php echo $solicitudserv_latitud;?>,<?php echo $solicitudserv_longitud;?>&hl=es;z=14&amp;output=embed" id="iframemaps" name="iframemaps" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>  

        </div>
    </div> 

	</div>
	<!-- Container End -->
</section>
<!--==========================================
=            All Category Section            =
===========================================-->

<section class=" section" style="margin-top: 0px">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-12">				
				<div class="row">
					<?php echo $subcategorias;?>					                    
				</div>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>


<?php include_once "include-consultas.php"; ?>

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
<script src="js/script.js"></script>

</body>
</html>



