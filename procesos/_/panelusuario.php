<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/base.php';
include_once 'lib/mysqlclass.php';
include_once 'lib/config.php';
include_once 'lib/funciones.php';

$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

(isset($_GET['r'])) ? $getreenviaremail_id=$_GET['r'] :$getreenviaremail_id='';
(isset($_GET['i'])) ? $getinfo=$_GET['i'] :$getinfo='';

$base = base();

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

    $titulopagina = "Panel - ".$compania_nombre;
    $descripcionpagina = "Panel - $compania_nombre ";

}


VerificarUsuarioEstatus($iniuser);



if ($getreenviaremail_id=="1"){

    $arrresultado = $conexion->doSelect("usuario.usuario_id, usuario.usuario_nombre, usuario.usuario_apellido, 
    usuario.usuario_email, usuario.usuario_telf, compania.compania_nombre, usuario.usuario_clave, 
    usuario.cuenta_id, usuario.compania_id",
    "usuario
    inner join compania on usuario.compania_id = compania.compania_id
    ",
    "usuario.usuario_activo ='1' and usuario.usuario_id = '$iniuser'  and usuario.cuenta_id = '$SistemaCuentaId' and usuario.compania_id = '$SistemaCompaniaId' ");

    if (count($arrresultado)>0){
        foreach($arrresultado as $i=>$valor){
            $resul_usuario_id = utf8_encode($valor["usuario_id"]);      
            $resul_cuenta_id = utf8_encode($valor["cuenta_id"]);      
            $resul_compania_id = utf8_encode($valor["compania_id"]);      
            $resul_usuario_nombre = utf8_encode($valor["usuario_nombre"]);
            $resul_usuario_apellido = utf8_encode($valor["usuario_apellido"]);
            $resul_usuario_email = utf8_encode($valor["usuario_email"]);
            $resul_usuario_telf = utf8_encode($valor["usuario_telf"]);
            $resul_usuario_clave = utf8_encode($valor["usuario_clave"]);

            $resul_compania_nombre = utf8_encode($valor["compania_nombre"]);

            $resul_usuario = $resul_usuario_nombre." ".$resul_usuario_apellido;
          }



        $resul_titulonotificacion = "Reenvvío Confirmacion Registro - $resul_compania_nombre";   

        $urla = $compania_urlweb."/iniciar-sesion?cod=$codverif";

        $resul_descripcionnotificacion = "
        Gracias por registrarse en ".$resul_compania_nombre.", necesitamos verificar su email para poder certificar que el mismo sea valido

        <br><br>
        <br>Compañía: ".$resul_compania_nombre."
        <br>Nombre: ".$resul_usuario."
        <br>Email: ".$resul_usuario_email."        
        <br><br>
        <a href='$urla' target='_blank'>
            Confirmar Email o copie y pegue el siguiente enlace en su navegador: $urla
        </a>        
        <br><br>
        ";

        $resul_descripcionnotificacion = utf8_decode($resul_descripcionnotificacion);

        $resul_descripcionnotificacion = addslashes($resul_descripcionnotificacion);

        $notif_visible = 0;
        $tiponotificacion = 103; // 103 = Email  104 = Sistema          

        InsertarNotificacion("32", "usuario", $resul_usuario_id, $resul_titulonotificacion, $resul_descripcionnotificacion, $resul_usuario_id, $resul_usuario_id, $resul_cuenta_id, $resul_compania_id, $resul_usuario_email, $resul_usuario_telf, $notif_visible, $tiponotificacion);

        $infonotificacion = "
          <div class='alert alert-success' style='text-align: center; font-weight: bold'>
              <a style='color: #000'>
                  Reenvio de Email Correctamente. <br>
                  Por favor revise su email para observar los datos para iniciar sesion, si no lo observa en bandeja de entrada puede revisar su carpeta de spam.
              </a>
          </div>     ";

    }

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
                                <a href="panelusuario-perfil">
                                    <center>
                                        <img src="images/panel_perfil.png" style="height: 80px;" class="img-responsive" />
                                        <h3 style="font-size: 18px; padding-top: 5px; color: #525252">Mi Perfil</h3>
                                    </center>
                                </a>
                            </div>
                            <div class="col-md-4" style="margin-top: 15px">
                                <a href="panelusuario-solicitudes">
                                    <center>
                                        <img src="images/panel_membresia.png" style="height: 80px;" class="img-responsive" />
                                        <h3 style="font-size: 18px; padding-top: 5px; color: #525252">Mis Solicitudes</h3>
                                    </center>
                                </a>
                            </div>   
                            <div class="col-md-4" style="margin-top: 15px">
                                <a href="solicitar">
                                    <center>
                                        <img src="images/form.png" style="height: 80px;" class="img-responsive" />
                                        <h3 style="font-size: 18px; padding-top: 5px; color: #525252">Buscar Servicio</h3>
                                    </center>
                                </a>
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

