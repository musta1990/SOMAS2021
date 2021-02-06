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
$xajax->registerFunction('guardarcontratarprestador');
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

(isset($_GET['id'])) ? $getusuario_id=$_GET['id'] :$getusuario_id='';
(isset($_GET['sid'])) ? $getsolicitudserv_id=$_GET['sid'] :$getsolicitudserv_id='';

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

    $titulopagina = "Contratar - ".$compania_nombre;
    $descripcionpagina = "Contratar - $compania_nombre ";

}



$arrresultado = $conexion->doSelect("
  solicitudservicio.solicitudserv_id, solicitudservicio.usuario_id, solicitudservicio.solicitudserv_titulo, 
  solicitudservicio.solicitudserv_descrip, solicitudservicio.solicitudserv_latitud, solicitudservicio.solicitudserv_longitud,
  solicitudservicio.solicitudserv_dircompleta, solicitudservicio.solicitudserv_infodir, solicitudservicio.solicitudserv_infocalle,
  solicitudservicio.solicitudserv_infocodpostal, solicitudservicio.solicitudserv_infociudad, 
  solicitudservicio.solicitudserv_infociudad2, solicitudservicio.solicitudserv_infosublocalidad, 
  solicitudservicio.solicitudserv_inforegion, solicitudservicio.solicitudserv_infocountry, 
  solicitudservicio.cuenta_id, solicitudservicio.compania_id, solicitudservicio.solicitudserv_activo,
  solicitudservicio.solicitudserv_eliminado,
  solicitudservicio.usuario_idreg, 
  usuario.usuario_nombre, usuario.usuario_apellido, usuario.usuario_img, 
  cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
  cuenta.usuario_apellido as cuenta_apellido, compania_nombre, 

  solicitudserv_codigo, solicitudserv_codigoint, solicitudservicio.l_estatus_id, 
  estatus.lista_nombre as estatus_nombre,
  solicitudservicio.l_categ_id, solicitudservicio.l_subcateg_id,
  categoria.lista_nombre as categ_nombre, categoria.lista_img as categ_img,
  subcategoria.lista_nombre as subcateg_nombre, subcategoria.lista_img as subcateg_img,
  DATE_FORMAT(solicitudservicio.solicitudserv_fechareg,'%d/%m/%Y %H:%i:%s') as solicitudserv_fechareg, 
  solicitudserv_leidos,

  solicitudservicioprestador.solicitudservpresta_id,  
  solicitudservicioprestador.usuario_id, solicitudservicioprestador.l_estatus_id, 
  DATE_FORMAT(solicitudservicioprestador.solicitudservpresta_fechareg,'%d/%m/%Y %H:%i:%s') as solicitudservpresta_fechareg, 

  solicitudservicioprestador.cuenta_id, 
  solicitudservicioprestador.compania_id, solicitudservicioprestador.solicitudservpresta_activo, 
  solicitudservicioprestador.solicitudservpresta_eliminado, solicitudservicioprestador.usuario_idreg,
  estatusservicioprestador.lista_nombre as estatusservicioprestador_nombre,

  usuarioprestador.usuario_id as usuarioprestador_id,
  usuarioprestador.usuario_nombre as usuarioprestador_nombre, usuarioprestador.usuario_apellido as usuarioprestador_apellido, 
  usuarioprestador.usuario_img as usuarioprestador_img


  ",
  "solicitudservicio
    inner join lista categoria on categoria.lista_id = solicitudservicio.l_categ_id
    inner join lista subcategoria on subcategoria.lista_id = solicitudservicio.l_subcateg_id

    inner join usuario on usuario.usuario_id = solicitudservicio.usuario_id
    inner join usuario cuenta on cuenta.usuario_id = solicitudservicio.cuenta_id
    inner join compania on compania.compania_id = solicitudservicio.compania_id
    inner join lista estatus on estatus.lista_id = solicitudservicio.l_estatus_id

    inner join solicitudservicioprestador on solicitudservicioprestador.solicitudserv_id = solicitudservicio.solicitudserv_id
              and solicitudservpresta_activo = '1'    

    inner join lista estatusservicioprestador on estatusservicioprestador.lista_id = solicitudservicioprestador.l_estatus_id

    inner join usuario usuarioprestador on usuarioprestador.usuario_id = solicitudservicioprestador.usuario_id

  ",
  "solicitudserv_activo = '1' and solicitudservicio.solicitudserv_id = '$getsolicitudserv_id' and solicitudservicioprestador.usuario_id = '$getusuario_id' and solicitudservicio.cuenta_id = '$SistemaCuentaId' and solicitudservicio.compania_id = '$SistemaCompaniaId'  ", null, "solicitudservicio.solicitudserv_id desc"); 


foreach($arrresultado as $i=>$valor){

  $usuarioprestador_id = utf8_encode($valor["usuarioprestador_id"]);
  $usuarioprestador_nombre = utf8_encode($valor["usuarioprestador_nombre"]);
  $usuarioprestador_apellido = utf8_encode($valor["usuarioprestador_apellido"]);
  $usuarioprestador_img = utf8_encode($valor["usuarioprestador_img"]);  

  $usuarioprestador = $usuarioprestador_nombre." ".$usuarioprestador_apellido." ";

  $solicitudservpresta_id = utf8_encode($valor["solicitudservpresta_id"]);
  $s_l_estatus_id = utf8_encode($valor["l_estatus_id"]);
  $solicitudservpresta_fechareg = utf8_encode($valor["solicitudservpresta_fechareg"]);
  $estatusservicioprestador_nombre = utf8_encode($valor["estatusservicioprestador_nombre"]);


  $categ_nombre = utf8_encode($valor["categ_nombre"]);
  $categ_img = utf8_encode($valor["categ_img"]);
  $subcateg_nombre = utf8_encode($valor["subcateg_nombre"]);
  $subcateg_img = utf8_encode($valor["subcateg_img"]);

  $solicitudserv_codigo = utf8_encode($valor["solicitudserv_codigo"]);
  $solicitudserv_leidos = utf8_encode($valor["solicitudserv_leidos"]);
  $solicitudserv_codigoint = utf8_encode($valor["solicitudserv_codigoint"]);
  $l_estatus_id = utf8_encode($valor["l_estatus_id"]);
  $estatus_nombre = utf8_encode($valor["estatus_nombre"]);

  $solicitudserv_id = utf8_encode($valor["solicitudserv_id"]);
  $t_usuario_id = utf8_encode($valor["usuario_id"]);
  $solicitudserv_titulo = utf8_encode($valor["solicitudserv_titulo"]);
  $solicitudserv_descrip = utf8_encode($valor["solicitudserv_descrip"]);
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

  $usuario = $usuario_nombre." ".$usuario_apellido." ";

  $cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
  $cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
  $cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
  $cuenta = $cuenta_nombre." ".$cuenta_apellido." ";


  $titulo = "#$solicitudserv_codigo";  

  $usuarioprestador = "<a href='prestador?id=$usuarioprestador_id&sid=$solicitudserv_id' style='color: #0B787A' target='_blank'>
      <img src='arch/$usuarioprestador_img' style='height: 30px; radius: 50%' title='Perfil $usuarioprestador' />
      $usuarioprestador
   </a>";

  
}

if ($textosolicitudes==""){
    $textosolicitudes .= "
    <tr style='font-size: 14px'>
        <td colspan='3' style='text-align: center'>
            <a>
                Aún no tienes solicitudes recibidas
            </a>
        </td>        
    </tr>
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
    
    <link href="css/starrr.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">

    
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
                        <h2 style="font-size: 20px">
                          Confirma la contratación de <?php echo $usuarioprestador;?> por la siguiente solicitud:
                        </h2>                        
                    </div>

                    <form action="javascript:guardarcontratarprestador()">                      
                      
                      <div class="row" style="margin-top: 15px">                        
                        <div class="col-md-12 col-12" style="text-align: center;">
                          <input type="submit" name="submit" value="Confirmar" class="btn btn-primary">
                          <input type='hidden' name='usuario_iddestino' value="<?php echo $usuarioprestador_id; ?>" id='usuario_iddestino' />
                          <input type='hidden' name='servicio' value="<?php echo $solicitudserv_id; ?>" id='servicio' />
                        </div>                                              
                      </div>
                    </form>
                    <hr>  

                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Usuario que Contrata:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $usuario;?>                          
                      </div>
                      
                    </div>  
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Id de Solicitud:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        #<?php echo $solicitudserv_id;?> 
                      </div>
                      
                    </div>   
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Servicio:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $categ_nombre;?> / <?php echo $subcateg_nombre;?> 
                      </div>
                      
                    </div>                                   
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Titulo Solicitud:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $solicitudserv_titulo;?>
                      </div>
                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Descripción del Problema:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $solicitudserv_descrip;?>
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

    <script src="dist/starrr.js"></script>
    <script>
 

      var $s1input = $('#star1_input');
      $('#star1').starrr({
        max: 5,
        rating: $s1input.val(),
        change: function(e, value){
          $s1input.val(value).trigger('input');
        }
      });

      var $s2input = $('#star2_input');
      $('#star2').starrr({
        max: 5,
        rating: $s2input.val(),
        change: function(e, value){
          $s2input.val(value).trigger('input');
        }
      });

      var $s3input = $('#star3_input');
      $('#star3').starrr({
        max: 5,
        rating: $s3input.val(),
        change: function(e, value){
          $s3input.val(value).trigger('input');
        }
      });
    </script>

</body>
</html>

