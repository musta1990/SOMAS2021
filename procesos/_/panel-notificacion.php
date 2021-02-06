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

(isset($_GET['id'])) ? $getnotificacion_id=$_GET['id'] :$getnotificacion_id='';


$base = base();

session_start();
$iniuser = $_COOKIE['iniuser'];
$login = $_COOKIE['login'];
$perfil = $_COOKIE['perfil'];

if ($iniuser==""){
  echo "<script language='JavaScript'>window.location = 'iniciar-sesion?i=1'; </script>";
  exit();
}

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

    $titulopagina = "Notificacion - ".$compania_nombre;
    $descripcionpagina = "Notificacion - $compania_nombre ";

}


$arrresultado = $conexion->doSelect("notificacion.notif_id, notif_tabla, notificacion.modulo_id, notificacion.elemento_id, 
    notificacion.notif_titulo, notificacion.notif_descrip, notificacion.notif_email, notificacion.notif_telf, notificacion.l_estatus_id, 
    notificacion.usuario_idorigen, notificacion.usuario_iddestino, notificacion.cuenta_id, notificacion.compania_id, notificacion.notif_activo, 
    notificacion.notif_notificadoemail, notificacion.notif_leido,
    DATE_FORMAT(notificacion.notif_fechareg,'%d/%m/%Y %H:%i:%s') as notif_fechareg, 
    estatus.lista_nombre,
    usuariodestino.usuario_nombre as usuariodestino_nombre, 
    usuariodestino.usuario_apellido as usuariodestno_apellido, 
    usuariodestino.usuario_img as usuariodestino_img, 
    cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
    cuenta.usuario_apellido as cuenta_apellido, compania_nombre, 
    modulo_url, modulo_nombre, modulo_nombreunico
    ",
    "notificacion
      left join lista estatus on notificacion.l_estatus_id = estatus.lista_id
      inner join usuario usuariodestino on usuariodestino.usuario_id = notificacion.usuario_iddestino
      inner join usuario cuenta on cuenta.usuario_id = notificacion.cuenta_id
      inner join compania on compania.compania_id = notificacion.compania_id
      inner join modulo on modulo.modulo_id = notificacion.modulo_id
      ",
    "notif_activo = '1' and notificacion.usuario_iddestino  ='$iniuser' and notificacion.cuenta_id = '$SistemaCuentaId' and notificacion.compania_id = '$SistemaCompaniaId' and notificacion.notif_id = '$getnotificacion_id' ", null, "notificacion.notif_id desc");
  
  foreach($arrresultado as $i=>$valor){

    $notif_id = utf8_encode($valor["notif_id"]);
    $notif_tabla = utf8_encode($valor["notif_tabla"]);
    $modulo_id = utf8_encode($valor["modulo_id"]);
    $elemento_id = utf8_encode($valor["elemento_id"]);
    $notif_titulo = utf8_encode($valor["notif_titulo"]);
    $notif_descrip = utf8_encode($valor["notif_descrip"]);
    $notif_email = utf8_encode($valor["notif_email"]);
    $notif_telf = utf8_encode($valor["notif_telf"]);
    $notif_fechareg = utf8_encode($valor["notif_fechareg"]);
    $l_estatus_id = utf8_encode($valor["l_estatus_id"]);
    $usuario_idorigen = utf8_encode($valor["usuario_idorigen"]);
    $usuario_iddestino = utf8_encode($valor["usuario_iddestino"]);
    $cuenta_id = utf8_encode($valor["cuenta_id"]);
    $compania_id = utf8_encode($valor["compania_id"]);
    $notif_activo = utf8_encode($valor["notif_activo"]);
    $notif_notificadoemail = utf8_encode($valor["notif_notificadoemail"]);
    $notif_leido = utf8_encode($valor["notif_leido"]);
    $lista_nombre = utf8_encode($valor["lista_nombre"]);

    $usuariodestino_nombre = utf8_encode($valor["usuariodestino_nombre"]);
    $usuariodestno_apellido = utf8_encode($valor["usuariodestno_apellido"]);
    $usuariodestino_img = utf8_encode($valor["usuariodestino_img"]);
    $compania_nombre = utf8_encode($valor["compania_nombre"]);

    $modulo_nombreunico = utf8_encode($valor["modulo_nombreunico"]);    
    $modulo_nombre = utf8_encode($valor["modulo_nombre"]);    
    $modulo_url = utf8_encode($valor["modulo_url"]);          
    $modulo_url = str_replace(".php","",$modulo_url);

    $usuariodestino = $usuariodestino_nombre." ".$usuariodestno_apellido." ";

    $cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
    $cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
    $cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
    $cuenta = $cuenta_nombre." ".$cuenta_apellido." ";

    $vernotificacion = "<a href='panel-notificacion?id=$notif_id'>Ver Notificación</a>";

    if ($modulo_id=="175"){
      $verinfo = "<a href='panel-solicitud?id=$elemento_id'>$notif_titulo Ver Solicitud</a>";  
    } else{
      $verinfo = "<a>$notif_titulo</a>";
    }



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
            <?php echo $infoalerta;?>
            <!-- Row Start -->
            <div class="row">
                <div class="col-md-10 offset-md-1 col-lg-3 offset-lg-0 order-sm-1 order-2">
                    <?php include_once "panel-sidebar.php"; ?>
                </div>
                <div class="col-md-10 offset-md-1 col-lg-9 offset-lg-0 order-sm-2 order-1">
                  <?php include_once "panel-notificaciones.php"; ?>
                    <!-- Edit Profile Welcome Text -->
                    <div class="widget welcome-message" style="padding-bottom: 10px">
                        <h2><i class="fa fa-envelope"></i> Notificacion #<?php echo $notif_id;?></h2>                        
                    </div>
                
                   
                   <?php echo $notif_descrip;?>                                
                   
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

