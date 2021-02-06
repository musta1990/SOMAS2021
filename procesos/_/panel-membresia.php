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
$xajax->registerFunction('cambiarperfilusuario');
$xajax->printJavascript('lib/');


$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

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

    $titulopagina = "Mi Membresía - ".$compania_nombre;
    $descripcionpagina = "Mi Membresía - $compania_nombre ";

}


$arrresultado = $conexion->doSelect("usuario.usuario_id, usuario_codigo, usuario_email, 
    usuario_clave, usuario_nombre, usuario_apellido, 
    usuario_telf, usuario_activo, usuario_eliminado, usuario_documento, usuario_img, perfil_id,     
    DATE_FORMAT(usuario_fechanac,'%d/%m/%Y') as usuario_fechanac, nivelriesgo_id,
    DATE_FORMAT(usuario_fechareg,'%d/%m/%Y') as usuario_fechareg, usuario_alias, l_tipousuarioserv_id,
    usuario.l_plan_id, plan.lista_nombre as plan_nombre, plan.lista_img as plan_img,
    DATE_FORMAT(usuarioplan_fechaini,'%d/%m/%Y') as usuarioplan_fechaini,
    DATE_FORMAT(usuarioplan_fechafin,'%d/%m/%Y') as usuarioplan_fechafin

    ",
	"usuario
        left join lista plan on plan.lista_id = usuario.l_plan_id
        left join usuarioplan on usuarioplan.usuario_id = usuario.usuario_id and usuarioplan_activo = '1'
    ",
	"usuario_activo = '1' and usuario.usuario_id = '$iniuser' and usuario.cuenta_id = '$SistemaCuentaId' and usuario.compania_id = '$SistemaCompaniaId' ");
foreach($arrresultado as $i=>$valor){

    $l_plan_id = utf8_encode($valor["l_plan_id"]);
    $plan_nombre = utf8_encode($valor["plan_nombre"]);
    $plan_img = utf8_encode($valor["plan_img"]);
    $usuarioplan_fechaini = utf8_encode($valor["usuarioplan_fechaini"]);
    $usuarioplan_fechafin = utf8_encode($valor["usuarioplan_fechafin"]);

    $usuario_alias = utf8_encode($valor["usuario_alias"]);

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
	$usuario_fechanac = utf8_encode($valor["usuario_fechanac"]);	
    $usuario_fechareg = utf8_encode($valor["usuario_fechareg"]);
    $l_tipousuarioserv_id = utf8_encode($valor["l_tipousuarioserv_id"]);
    

}

if ($usuario_id==""){
  echo "<script language='JavaScript'>window.location = 'iniciar-sesion'; </script>";
  exit();
}


$arrresultado = $conexion->doSelect("usuario.usuario_id, usuario_nombre, 
    usuario_img,DATE_FORMAT(usuario_fechareg,'%d/%m/%Y') as usuario_fechareg, 
     l_tipousuarioserv_id, tipousuarioservicio.lista_nombre as tipousuario

    ",
    "usuario
        left join lista tipousuarioservicio on tipousuarioservicio.lista_id = usuario.l_tipousuarioserv_id 
    ",
    "usuario_activo = '1' and usuario.usuario_id = '$iniuser' and usuario.cuenta_id = '$SistemaCuentaId' and usuario.compania_id = '$SistemaCompaniaId' ");
foreach($arrresultado as $i=>$valor){
    $usuario_id = utf8_encode($valor["usuario_id"]);    
    $usuario_nombre = utf8_encode($valor["usuario_nombre"]);
    $usuario_fechareg = utf8_encode($valor["usuario_fechareg"]);    
    $usuario_img = utf8_encode($valor["usuario_img"]);
    $tipousuario = utf8_encode($valor["tipousuario"]);
    $l_tipousuarioserv_id = utf8_encode($valor["l_tipousuarioserv_id"]);

    if ($l_tipousuarioserv_id=="143"){
        $_COOKIE["tipousuarioserv"] = "2";     
        $tipousuarioserv = $_COOKIE["tipousuarioserv"];
    }else{
        $_COOKIE["tipousuarioserv"] = "1";     
        $tipousuarioserv = $_COOKIE["tipousuarioserv"];
    }
}



$arrresultado = ObtenerListaArray('41', $SistemaCuentaId, $SistemaCompaniaId, $l_tipousuarioserv_id); 

foreach($arrresultado as $i=>$valor){
    $lista_id = utf8_encode($valor["lista_id"]);  
    $lista_nombre = utf8_encode($valor["lista_nombre"]);  
    $lista_img = utf8_encode($valor["lista_img"]);  
    $listacuenta_id = utf8_encode($valor["listacuenta_id"]);  
    $listacuenta_nombre = utf8_encode($valor["listacuenta_nombre"]);  
    $listacuenta_nombredos = utf8_encode($valor["listacuenta_nombredos"]);  
    $listacuenta_activo = utf8_encode($valor["listacuenta_activo"]);  

    $actualperfilbackground = "";
    $actualperfilcolor = "";    
    
    $atributoslink = " title ='Mi Membresía a $lista_nombre' style='text-align: center; cursor: pointer;' onclick='cambiarperfilusuario(\"".$lista_id."\")' ";

    if ($l_tipousuarioserv_id==$lista_id){
        $actualperfilbackground = " style='background: #15809B'";
        $actualperfilcolor = " ; color: #FFF ";        
        $atributoslink = " title ='Perfil Actual' style='text-align: center;' ";
    }

    $urlf = $UrlFiles."admin/arch/$lista_img";

    $perfiles .="
        <div class='col-lg-4 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6'>
            <div class='category-block' $actualperfilbackground>
                <div class='headerr'>
                    <a $atributoslink >
                      
                      <div style='margin-top: 10px'>
                          <center>
                              <img src='$urlf' style='height: 100px'>
                          </center>
                      </div>
                      <h4 style='font-size: 20px; margin-top: 10px $actualperfilcolor'>
                        $lista_nombre
                      </h4>
                      
                    </a>
                </div>
            </div>
        </div>
    ";

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
                        <h2>
                            <i class="fa fa-star"></i> Mi Membresía: 
                            <span style="font-weight: normal; font-size: 22px">
                                <?php echo $plan_nombre;?>
                                <a href="planes" style="color: #5672f9; font-weight: 600; font-size: 18px">(Cambiar plan)</a>

                            </span>

                        </h2>                        
                    </div>                   
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Fecha Inicio:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $usuarioplan_fechaini;?>
                      </div>
                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Fecha Fin:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $usuarioplan_fechafin;?>
                      </div>
                      
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12" style="text-align: right;">
                            <a href="panelprestador-pagos">
                                <button type="button" class="btn btn-success">
                                    <i class="fa fa-money"></i> Pagos
                                </button>
                            </a>
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
    <script src="plugins/fancybox/jquery.fancybox.pack.js"></script>
    <script src="plugins/smoothscroll/SmoothScroll.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>

