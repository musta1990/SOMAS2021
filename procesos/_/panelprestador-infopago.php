<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/funciones.php';
include_once 'lib/base.php';
include_once 'lib/mysqlclass.php';
include_once 'lib/config.php';
include_once 'lib/xajax_0.2.4/xajax.inc.php';

$xajax = new xajax('lib/ajx_fnci.php');
$xajax->registerFunction('vercontactosolicitud');
$xajax->printJavascript('lib/');


$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

$base = base();

$fechaactual = formatoFechaHoraBd();

session_start();
$iniuser = $_COOKIE['iniuser'];
$login = $_COOKIE['login'];
$perfil = $_COOKIE['perfil'];

if ($iniuser==""){
  echo "<script language='JavaScript'>window.location = 'iniciar-sesion?i=1'; </script>";
  exit();
}

(isset($_GET['id'])) ? $getpago_id=$_GET['id'] :$getpago_id='';

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

    $titulopagina = "Info Pago - ".$compania_nombre;
    $descripcionpagina = "Info Pago - $compania_nombre ";

}


$arrresultado = $conexion->doSelect("
  pago.pago_id, pago.pago_monto, pago.pago_referencia, pago.pago_banco, 
  pago.pago_comentario, pago.pago_img, pago.l_formapago_id, pago.usuario_id, pago.usuario_idreg, pago.pago_activo, 
  pago.pago_eliminado, pago.cuenta_id, pago.compania_id, pago.l_tipoarchivo_id,

  pagoplan.pagoplan_id, pagoplan.pago_id, pagoplan.l_plan_id, pago.l_estatus_id, pagoplan.pagoplan_fechareg,
  pagoplan.pagoplan_observacion, pagoplan.usuario_idreg,

  plan.lista_nombre as plan_nombre, estatus.lista_nombre as estatus_nombre,

  usuario.usuario_nombre, usuario.usuario_apellido, usuario.usuario_img, 
  cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
  cuenta.usuario_apellido as cuenta_apellido, compania_nombre,

  DATE_FORMAT(pago.pago_fechareg,'%d/%m/%Y %H:%i:%s') as pago_fechareg,
  DATE_FORMAT(pago.pago_fecha,'%d/%m/%Y') as pago_fecha,

  moneda.lista_nombre as moneda_nombre, moneda.lista_nombredos as moneda_siglas

  ",
  "pago
    inner join pagoplan on pagoplan.pago_id = pago.pago_id
    inner join lista moneda on moneda.lista_id = pago.l_moneda_id
    inner join lista plan on plan.lista_id = pagoplan.l_plan_id
    inner join usuario on usuario.usuario_id = pago.usuario_id
    inner join usuario cuenta on cuenta.usuario_id = pago.cuenta_id
    inner join compania on compania.compania_id = pago.compania_id
    inner join lista estatus on estatus.lista_id = pago.l_estatus_id

  ",
  "pago_activo = '1' and pago.pago_id = '$getpago_id' and pago.usuario_id = '$iniuser' and pago.cuenta_id = '$SistemaCuentaId' and pago.compania_id = '$SistemaCompaniaId' ", null, "pago.pago_id desc"); 

foreach($arrresultado as $i=>$valor){

  $moneda_nombre = utf8_encode($valor["moneda_nombre"]);
  $moneda_siglas = utf8_encode($valor["moneda_siglas"]);

  $pago_id = utf8_encode($valor["pago_id"]);
  $pago_monto = utf8_encode($valor["pago_monto"]);
  $pago_fechareg = utf8_encode($valor["pago_fechareg"]);
  $pago_fecha = utf8_encode($valor["pago_fecha"]);
  $pago_referencia = utf8_encode($valor["pago_referencia"]);
  $pago_banco = utf8_encode($valor["pago_banco"]);
  $pago_comentario = utf8_encode($valor["pago_comentario"]);
  $pago_img = utf8_encode($valor["pago_img"]);
  $l_formapago_id = utf8_encode($valor["l_formapago_id"]);
  $panelpago_usuario_id = utf8_encode($valor["usuario_id"]);
  $usuario_idreg = utf8_encode($valor["usuario_idreg"]);
  $pago_activo = utf8_encode($valor["pago_activo"]);
  $cuenta_id = utf8_encode($valor["cuenta_id"]);
  $compania_id = utf8_encode($valor["compania_id"]);
  $l_tipoarchivo_id = utf8_encode($valor["l_tipoarchivo_id"]);
  $pagoplan_id = utf8_encode($valor["pagoplan_id"]);  
  $l_plan_id = utf8_encode($valor["l_plan_id"]);
  $l_estatus_id = utf8_encode($valor["l_estatus_id"]);
  $pagoplan_fechareg = utf8_encode($valor["pagoplan_fechareg"]);
  $pagoplan_observacion = utf8_encode($valor["pagoplan_observacion"]);

  $plan_nombre = utf8_encode($valor["plan_nombre"]);
  $estatus_nombre = utf8_encode($valor["estatus_nombre"]);

  
  $pago_monto = number_format($pago_monto, 2, ',', '.'); 

  $usuario_nombre = utf8_encode($valor["usuario_nombre"]);
  $usuario_apellido = utf8_encode($valor["usuario_apellido"]);
  $usuario_img = utf8_encode($valor["usuario_img"]);
  $compania_nombre = utf8_encode($valor["compania_nombre"]);

  $usuario = $usuario_nombre." ".$usuario_apellido." ";

  $cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
  $cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
  $cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
  $cuenta = $cuenta_nombre." ".$cuenta_apellido." ";

  $urlimgpago = "arch/$pago_img";

  $labeladjunto = "Archivo Adjunto:";

  if ($l_tipoarchivo_id=="58"){

      $labeladjunto = "$tipoarchivo_nombre Adjunto:";
      $agregarchivoadjunto = "
          <a href='arch/$pago_img' target='_blank'>
              <img src='images/tipoarchivo/".$l_tipoarchivo_id.".jpg' style='height: 100px' />
              <br>
              $requisitoarch_nombre
          </a>
      ";
  }else if ($l_tipoarchivo_id=="59"){

      $labeladjunto = "$tipoarchivo_nombre Adjunto:";
      $agregarchivoadjunto = "
          <a href='arch/$pago_img' target='_blank'>
              <img src='images/tipoarchivo/".$l_tipoarchivo_id.".jpg' style='height: 100px' />
              <br>
              $requisitoarch_nombre
          </a>
      ";
  }else if ($l_tipoarchivo_id=="60"){

      $labeladjunto = "$tipoarchivo_nombre Adjunto:";
      $agregarchivoadjunto = "
          <a href='arch/$pago_img' target='_blank'>
              <img src='images/tipoarchivo/".$l_tipoarchivo_id.".jpg' style='height: 100px' />
              <br>
              $requisitoarch_nombre 
          </a>
      ";
  }else if ($l_tipoarchivo_id=="61"){
      $labeladjunto = "$tipoarchivo_nombre Adjunto:";
      $agregarchivoadjunto = "
          <a class='fancybox' href='arch/$pago_img' data-fancybox-group='gallery'>
              <img class='img-responsive' src='arch/$pago_img' style='height: 100px; border-radius: 10px' />
              <br>
              $requisitoarch_nombre
          </a>
      ";
  }else if ($l_tipoarchivo_id=="62"){

      $labeladjunto = "$tipoarchivo_nombre Adjunto:";
      $agregarchivoadjunto = "
          <a href='arch/$pago_img' target='_blank'>
              <img src='images/tipoarchivo/".$l_tipoarchivo_id.".jpg' style='height: 100px' />
              <br>
              $requisitoarch_nombre
          </a>
      ";
  }
  else{
      $agregarchivoadjunto = "
          <a href='arch/$pago_img' target='_blank'>
              $requisitoarch_nombre
          </a>
      ";
  }

  if ($pago_img==""){
    $agregarchivoadjunto = "(Sin Comprobante)";
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

    <link rel="stylesheet" type="text/css" href="lib/fancy/source/jquery.fancybox.css?v=2.1.5" media="screen" />

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
                        <h2><i class="fa fa-money"></i> Id Pago: #<?php echo $pago_id;?></h2>                        
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Nombre del Plan:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $plan_nombre;?>                        
                      </div>
                    </div> 
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Estatus del Pago:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $estatus_nombre;?>                        
                      </div>
                    </div>  
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Usuario:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $usuario;?>                        
                      </div>
                    </div>                   
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Fecha de Pago:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $pago_fecha;?>
                      </div>
                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Fecha Registrado:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $pago_fechareg;?>
                      </div>                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Monto del Pago:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $pago_monto;?> <?php echo $moneda_siglas;?>
                      </div>
                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Nro Referencia:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $pago_referencia;?>
                      </div>
                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Comentarios:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $pago_comentario;?>
                      </div>
                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Comprobante:   
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $agregarchivoadjunto;?>                        
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
    <script type="text/javascript" src="lib/fancy/source/jquery.fancybox.js?v=2.1.5"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.fancybox').fancybox();
        });
    </script>
</body>
</html>

