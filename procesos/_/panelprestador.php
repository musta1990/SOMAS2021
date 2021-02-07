﻿<?php
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

(isset($_GET['i'])) ? $getinfo=$_GET['i'] :$getinfo='';

$base = base();

session_start();
$iniuser = $_COOKIE['iniuser'];
$login = $_COOKIE['login'];
$perfil = $_COOKIE['perfil'];

if ($iniuser==""){
  echo "<script language='JavaScript'>window.location = 'iniciar-sesion?i=1'; </script>";
  exit();
}

VerificarUsuarioEstatus($iniuser);

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

    $titulopagina = "Panel - ".$compania_nombre;
    $descripcionpagina = "Panel - $compania_nombre ";

}


$arrresultado = $conexion->doSelect("usuario_id, usuario_codigo, usuario_email, usuario_clave, usuario_nombre, usuario_apellido, 
    usuario_telf, usuario_activo, usuario_eliminado, usuario_documento, usuario_img, perfil_id, 
    usuario_direccion, usuario_localidad, usuario_actividad, nacionalidad_id, sexo_id, e_estadocivil_id, 
    usuario_conyugenombre, usuario_conyugetelf, usuario_pariente, usuario_parientetelf, e_parentesco_id, 
    usuario_telfdos, usuario_notas, usuario_porcentajecolocador, usuario_balance, usuario_comentarios, usuario_tasapref,
    DATE_FORMAT(usuario_fechanac,'%d/%m/%Y') as usuario_fechanac, nivelriesgo_id,
    DATE_FORMAT(usuario_fechareg,'%d/%m/%Y') as usuario_fechareg, usuario_alias",
	"usuario",
	"usuario_activo = '1' and usuario_id = '$iniuser'  and usuario.cuenta_id = '$SistemaCuentaId' and usuario.compania_id = '$SistemaCompaniaId'  ", null, "usuario_id asc");
foreach($arrresultado as $i=>$valor){

	$usuario_id = utf8_encode($valor["usuario_id"]);
	$usuario_codigo = utf8_encode($valor["usuario_codigo"]);
	$usuario_email = utf8_encode($valor["usuario_email"]);
	$usuario_clave = utf8_encode($valor["usuario_clave"]);
	$usuario_nombre = utf8_encode($valor["usuario_nombre"]);
	$usuario_apellido = utf8_encode($valor["usuario_apellido"]);
	$usuario_telf = utf8_encode($valor["usuario_telf"]);
	$usuario_fechareg = utf8_encode($valor["usuario_fechareg"]);
	$usuario_activo = utf8_encode($valor["usuario_activo"]);
	$usuario_documento = utf8_encode($valor["usuario_documento"]);
	$t_perfil_id = utf8_encode($valor["perfil_id"]);
	$usuario_direccion = utf8_encode($valor["usuario_direccion"]);
	$usuario_localidad = utf8_encode($valor["usuario_localidad"]);
	$usuario_actividad = utf8_encode($valor["usuario_actividad"]);
	$t_nacionalidad_id = utf8_encode($valor["nacionalidad_id"]);
	$t_sexo_id = utf8_encode($valor["sexo_id"]);
	$e_estadocivil_id = utf8_encode($valor["e_estadocivil_id"]);
	$usuario_conyugenombre = utf8_encode($valor["usuario_conyugenombre"]);
	$usuario_conyugetelf = utf8_encode($valor["usuario_conyugetelf"]);
	$usuario_pariente = utf8_encode($valor["usuario_pariente"]);
	$usuario_parientetelf = utf8_encode($valor["usuario_parientetelf"]);
	$e_parentesco_id = utf8_encode($valor["e_parentesco_id"]);
	$usuario_telfdos = utf8_encode($valor["usuario_telfdos"]);
	$usuario_notas = utf8_encode($valor["usuario_notas"]);
	$usuario_porcentajecolocador = utf8_encode($valor["usuario_porcentajecolocador"]);
	$usuario_balance = utf8_encode($valor["usuario_balance"]);
	$usuario_comentarios = utf8_encode($valor["usuario_comentarios"]);
	$usuario_tasapref = utf8_encode($valor["usuario_tasapref"]);
	$usuario_fechanac = utf8_encode($valor["usuario_fechanac"]);
	$t_nivelriesgo_id = utf8_encode($valor["nivelriesgo_id"]);
    $usuario_fechareg = utf8_encode($valor["usuario_fechareg"]);
    $usuario_img = utf8_encode($valor["usuario_img"]);
	$usuario_alias = utf8_encode($valor["usuario_alias"]);	

}

if ($usuario_id==""){
  echo "<script language='JavaScript'>window.location = 'iniciar-sesion'; </script>";
  exit();
}


if ($getinfo=="1"){

    $infonotificacion = "
          <div class='alert alert-success' style='text-align: center; font-weight: bold'>
              <a style='color: #000'>
                  Gracias por registrarse en nuestra plataforma. Por favor revise su email para confirmar el mismo.
              </a>
          </div>     ";
    
}

VerificarUsuarioEstatus($iniuser);



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

    <!--==================================
    =            User Profile            =
    ===================================-->
    <section class="dashboard section">
        <!-- Container Start -->
        <div class="container">
            <?php echo $infonotificacion;?>
            <!-- Row Start -->
            <div class="row">
                <div class="col-md-10 offset-md-1 col-lg-3 offset-lg-0 order-sm-1 order-2">
                    <?php include_once "panel-sidebar.php"; ?>
                </div>
                <div class="col-md-10 offset-md-1 col-lg-9 offset-lg-0 order-sm-2 order-1">
                    <?php include_once "panel-notificaciones.php"; ?>
                    <!-- Recently Favorited -->
                    <div class="widget welcome-message" style="padding-bottom: 10px">
                        <h2><i class="fa fa-list"></i> Panel</h2>
                        <p>Observa los menus que tenemos para tu cuenta</p>
                    </div>
                    <div class="widget dashboard-container my-adslist">                        
                        <div class="row">
                            <div class="col-md-4" style="margin-top: 15px" >
                                <a href="panelprestador-perfil">
                                    <center>
                                        <img src="images/panel_perfil.png" style="height: 80px;" class="img-responsive" />
                                        <h3 style="font-size: 18px; padding-top: 5px; color: #525252">Mi Perfil</h3>
                                    </center>
                                </a>
                            </div>   
                            <div class="col-md-4" style="margin-top: 15px" >
                                <a href="panelprestador-solicitudes">
                                    <center>
                                        <img src="images/panelsolicitud.png" style="height: 80px;" class="img-responsive" />
                                        <h3 style="font-size: 18px; padding-top: 5px; color: #525252">Solicitudes Portal</h3>
                                    </center>
                                </a>
                            </div>                          
                            <div class="col-md-4" style="margin-top: 15px" >
                                <?php echo $sidebardivcentroverificacion;?>
                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row End -->
        </div>
        <!-- Container End -->
    </section>

    <?php include_once "footer.php"; ?>

    <!-- JAVASCRIPTS -->
    <script src="plugins/jQuery/jquery.min.js"></script>
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
