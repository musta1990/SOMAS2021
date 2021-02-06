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

    $titulopagina = "Panel de Verificación - ".$compania_nombre;
    $descripcionpagina = "Panel de Verificación - $compania_nombre ";

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
    $notif_l_tipousuarioserv_id = utf8_encode($valor["l_tipousuarioserv_id"]);    
}



$arrresultado = $conexion->doSelect("
    requisito.requisito_id, requisito.l_requisitolista_id, requisito_descrip, requisito.l_tipoarchivo_id, requisito_arch, 
    requisito_archnombre, requisito_cantarchivos, requisito.cuenta_id, requisito.compania_id,
    requisito_activo, requisito_eliminado, requisito_fechareg, 
    requisito.usuario_idreg, requisito.l_estatus_id, requisito.usuario_id,
    usuario.usuario_id, usuario.usuario_codigo, usuario.usuario_email, usuario.usuario_nombre, usuario.usuario_apellido, 
    usuario.usuario_telf, usuario.usuario_activo, usuario.usuario_eliminado, 
    usuario.usuario_documento, usuario.usuario_img, usuario.perfil_id, 

    cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
    cuenta.usuario_apellido as cuenta_apellido, compania_nombre, 
    listarequisito.lista_id as requisitolista_id,
    listarequisito.lista_nombre as requisitolista_nombre,
    estatus.lista_nombre as estatus_nombre,
    tipoarchivo.lista_nombre as tipoarchivo_nombre,
    tipoarchivo.lista_img as tipoarchivo_img

    ",
    "lista listarequisito
        inner join listarequisitotipousuarioserv on listarequisitotipousuarioserv.l_requisitolista_id = listarequisito.lista_id
        left join requisito on requisito.l_requisitolista_id = listarequisito.lista_id and requisito.usuario_id = '$iniuser' and requisito.cuenta_id = '$SistemaCuentaId' and requisito.compania_id = '$SistemaCompaniaId' 
        left join lista tipoarchivo on tipoarchivo.lista_id = requisito.l_tipoarchivo_id
        left join lista estatus on estatus.lista_id = requisito.l_estatus_id
        left join usuario on usuario.usuario_id = requisito.usuario_id
        left join usuario cuenta on cuenta.usuario_id = requisito.cuenta_id
        left join compania on compania.compania_id = requisito.compania_id

    ",
    "listarequisito.lista_activo = '1' and listarequisitotipousuarioserv.l_tipousuarioserv_id = '$notif_l_tipousuarioserv_id' and listarequisito.tipolista_id  ='49' ", null, "listarequisito.lista_orden asc");
foreach($arrresultado as $i=>$valor){

    $requisito_id = utf8_encode($valor["requisito_id"]);
    $l_requisitolista_id = utf8_encode($valor["l_requisitolista_id"]);
    $requisito_descrip = utf8_encode($valor["requisito_descrip"]);
    $l_tipoarchivo_id = utf8_encode($valor["l_tipoarchivo_id"]);
    $requisito_arch = utf8_encode($valor["requisito_arch"]);
    $requisito_archnombre = utf8_encode($valor["requisito_archnombre"]);
    $requisito_cantarchivos = utf8_encode($valor["requisito_cantarchivos"]);
    $t_cuenta_id = utf8_encode($valor["cuenta_id"]);
    $t_compania_id = utf8_encode($valor["compania_id"]);
    $requisito_activo = utf8_encode($valor["requisito_activo"]);
    $requisito_fechareg = utf8_encode($valor["requisito_fechareg"]);
    $l_estatus_id = utf8_encode($valor["l_estatus_id"]);
    $usuario_id = utf8_encode($valor["usuario_id"]);
    $usuario_codigo = utf8_encode($valor["usuario_codigo"]);
    $usuario_email = utf8_encode($valor["usuario_email"]);
    
    $requisitolista_id = utf8_encode($valor["requisitolista_id"]);
    $requisitolista_nombre = utf8_encode($valor["requisitolista_nombre"]);
    $estatus_nombre = utf8_encode($valor["estatus_nombre"]);
    $tipoarchivo_nombre = utf8_encode($valor["tipoarchivo_nombre"]);
    $tipoarchivo_img = utf8_encode($valor["tipoarchivo_img"]);

    if ($estatus_nombre==""){
      $estatus_nombre = "Pendiente";
    }

    if ($requisitolista_id=="162"){
        if ($l_estatus_id=="165"){
          $urlrequisito = $estatus_nombre;        
        }else {
          $urlrequisito = "<a href='panelreenviar-email'><i class='fa fa-envelope'></i> Reenviar Confirmación</a>";        
        }
        

    }else{

        if ($l_estatus_id=="165"){
          $urlrequisito = "<a href='panel-cargarrequisito?id=$requisitolista_id'><i class='fa fa-file'></i> Ver</a>";        
        }else{
          $urlrequisito = "<a href='panel-cargarrequisito?id=$requisitolista_id'><i class='fa fa-file'></i> Ver / Cargar</a>";        
        }
        
    }


    $textorequisitos .= "
      <tr style='font-size: 14px; text-align: center'>
          <td>$requisitolista_nombre</td>            
          <td>$estatus_nombre</td>            
          <td>$requisito_fechareg</td>            
          <td>$urlrequisito</td>                             
      </tr>
    ";

}

if ($textorequisitos==""){
    $textorequisitos .= "
    <tr style='font-size: 14px'>
        <td colspan='4' style='text-align: center'>
            <a>
                No existen documentos solicitados
            </a>
        </td>        
    </tr>
      ";
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
            <?php echo $infoalerta;?>
            <!-- Row Start -->
            <div class="row">
                <div class="col-md-10 offset-md-1 col-lg-3 offset-lg-0 order-sm-1 order-2">
                    <?php include_once "panel-sidebar.php"; ?>
                </div>
                <div class="col-md-10 offset-md-1 col-lg-9 offset-lg-0 order-sm-2 order-1">
                    <?php include_once "panel-notificaciones.php"; ?> 
                    
                    <div class="widget welcome-message" style="padding-bottom: 10px">
                        <h2><i class="fa fa-id-card"></i> Panel de Verificación</h2>
                        <p>
                          Se muestra el listado de los documentos solicitados para su verificación y el estatus de la revisión
                        </p>
                    </div>
                
                   
                    <div class="widget dashboard-container my-adslist" style="padding-left: 0px; padding-right: 0px">                        
                        <table class="table table-responsive product-dashboard-table">
                            <thead>
                                <tr style="text-align: center;">                                    
                                    <th>Requisito</th>
                                    <th>Estatus</th>       
                                    <th>Fecha Registro</th>                                                                              
                                    <th>Documentos</th>                                     
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $textorequisitos;?>                                
                            </tbody>
                        </table>
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

