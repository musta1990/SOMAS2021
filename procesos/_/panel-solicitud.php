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

(isset($_GET['id'])) ? $getsolicitudid=$_GET['id'] :$getsolicitudid='';
(isset($_GET['c'])) ? $getconfirmacion=$_GET['c'] :$getconfirmacion='';

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
    $descripcionpagina = "Solicitud - $compania_nombre ";

}


$arrresultado = $conexion->doSelect("solicitudservicio.usuario_id",
  "solicitudservicio
    inner join lista categoria on categoria.lista_id = solicitudservicio.l_categ_id
    inner join lista subcategoria on subcategoria.lista_id = solicitudservicio.l_subcateg_id

    inner join usuario on usuario.usuario_id = solicitudservicio.usuario_id
    inner join usuario cuenta on cuenta.usuario_id = solicitudservicio.cuenta_id
    inner join compania on compania.compania_id = solicitudservicio.compania_id
    inner join lista estatus on estatus.lista_id = solicitudservicio.l_estatus_id

  ",
  "solicitudserv_activo = '1' and solicitudservicio.solicitudserv_id = '$getsolicitudid'  and solicitudservicio.cuenta_id = '$SistemaCuentaId' and solicitudservicio.compania_id = '$SistemaCompaniaId' ");
foreach($arrresultado as $i=>$valor){
  $t_usuario_id = utf8_encode($valor["usuario_id"]);
}

if ($t_usuario_id!=$iniuser){
  $agregarinner = "
    inner join usuarioservicio on usuarioservicio.l_categservicio_id = categoria.lista_id
               and usuarioservicio.l_subcategservicio_id = subcategoria.lista_id

  ";
}else{
  $wheresolicitud = " and solicitudservicio.usuario_id = '$iniuser' ";
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
  usuario.usuario_telf, usuario.usuario_email,

  cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
  cuenta.usuario_apellido as cuenta_apellido, compania_nombre, 

  solicitudserv_codigo, solicitudserv_codigoint, solicitudservicio.l_estatus_id, 
  estatus.lista_nombre as estatus_nombre,
  solicitudservicio.l_categ_id, solicitudservicio.l_subcateg_id,
  categoria.lista_nombre as categ_nombre, categoria.lista_img as categ_img,
  subcategoria.lista_nombre as subcateg_nombre, subcategoria.lista_img as subcateg_img,
  DATE_FORMAT(solicitudservicio.solicitudserv_fechareg,'%d/%m/%Y %H:%i:%s') as solicitudserv_fechareg,


  solicitudservicioprestador.solicitudservpresta_id,  
  solicitudservicioprestador.l_estatus_id as estatus_idservicioprestador, 
  solicitudservicioprestador.solicitudservpresta_fechareg, solicitudservicioprestador.cuenta_id, 
  solicitudservicioprestador.compania_id, solicitudservicioprestador.solicitudservpresta_activo, 
  solicitudservicioprestador.solicitudservpresta_eliminado, solicitudservicioprestador.usuario_idreg,
  estatusservicioprestador.lista_cod as estatusservicioprestador_cod,
  estatusservicioprestador.lista_nombre as estatusservicioprestador_nombre


  ",
  "solicitudservicio
    inner join lista categoria on categoria.lista_id = solicitudservicio.l_categ_id
    inner join lista subcategoria on subcategoria.lista_id = solicitudservicio.l_subcateg_id

    inner join usuario on usuario.usuario_id = solicitudservicio.usuario_id
    inner join usuario cuenta on cuenta.usuario_id = solicitudservicio.cuenta_id
    inner join compania on compania.compania_id = solicitudservicio.compania_id
    inner join lista estatus on estatus.lista_id = solicitudservicio.l_estatus_id

    $agregarinner

    left join solicitudservicioprestador on solicitudservicioprestador.solicitudserv_id = solicitudservicio.solicitudserv_id
              and solicitudservpresta_activo = '1' and solicitudservicioprestador.usuario_id = '$iniuser'

    left join lista estatusservicioprestador on estatusservicioprestador.lista_id = solicitudservicioprestador.l_estatus_id

  ",
  "solicitudserv_activo = '1' and solicitudservicio.solicitudserv_id = '$getsolicitudid' $wheresolicitud   and solicitudservicio.cuenta_id = '$SistemaCuentaId' and solicitudservicio.compania_id = '$SistemaCompaniaId' "); 

foreach($arrresultado as $i=>$valor){



  $solicitudservpresta_id = utf8_encode($valor["solicitudservpresta_id"]);
  $s_l_estatus_id = utf8_encode($valor["l_estatus_id"]);
  $estatus_idservicioprestador = utf8_encode($valor["estatus_idservicioprestador"]);
  $solicitudservpresta_fechareg = utf8_encode($valor["solicitudservpresta_fechareg"]);

  $estatusservicioprestador_cod = utf8_encode($valor["estatusservicioprestador_cod"]);
  $estatusservicioprestador_nombre = utf8_encode($valor["estatusservicioprestador_nombre"]);

  $infosolicitud_categ_nombre = utf8_encode($valor["categ_nombre"]);
  $infosolicitud_categ_img = utf8_encode($valor["categ_img"]);
  $infosolicitud_subcateg_nombre = utf8_encode($valor["subcateg_nombre"]);
  $infosolicitud_subcateg_img = utf8_encode($valor["subcateg_img"]);

  $infosolicitud_solicitudserv_codigo = utf8_encode($valor["solicitudserv_codigo"]);
  $infosolicitud_solicitudserv_codigoint = utf8_encode($valor["solicitudserv_codigoint"]);
  $infosolicitud_l_estatus_id = utf8_encode($valor["l_estatus_id"]);
  $infosolicitud_estatus_nombre = utf8_encode($valor["estatus_nombre"]);

  $infosolicitud_solicitudserv_id = utf8_encode($valor["solicitudserv_id"]);
  $infosolicitud_t_usuario_id = utf8_encode($valor["usuario_id"]);
  $infosolicitud_solicitudserv_titulo = utf8_encode($valor["solicitudserv_titulo"]);
  $infosolicitud_solicitudserv_descrip = nl2br(utf8_encode($valor["solicitudserv_descrip"]));
  $infosolicitud_solicitudserv_latitud = utf8_encode($valor["solicitudserv_latitud"]);
  $infosolicitud_solicitudserv_longitud = utf8_encode($valor["solicitudserv_longitud"]);
  $infosolicitud_solicitudserv_dircompleta = utf8_encode($valor["solicitudserv_dircompleta"]);
  $infosolicitud_solicitudserv_infodir = utf8_encode($valor["solicitudserv_infodir"]);
  $infosolicitud_solicitudserv_infocalle = utf8_encode($valor["solicitudserv_infocalle"]);
  $infosolicitud_solicitudserv_infocodpostal = utf8_encode($valor["solicitudserv_infocodpostal"]);
  $infosolicitud_solicitudserv_infociudad = utf8_encode($valor["solicitudserv_infociudad"]);
  $infosolicitud_solicitudserv_infociudad2 = utf8_encode($valor["solicitudserv_infociudad2"]);
  $infosolicitud_solicitudserv_infosublocalidad = utf8_encode($valor["solicitudserv_infosublocalidad"]);
  $infosolicitud_solicitudserv_inforegion = utf8_encode($valor["solicitudserv_inforegion"]);
  $infosolicitud_solicitudserv_infocountry = utf8_encode($valor["solicitudserv_infocountry"]);
  $infosolicitud_t_cuenta_id = utf8_encode($valor["cuenta_id"]);
  $infosolicitud_t_compania_id = utf8_encode($valor["compania_id"]);
  $infosolicitud_solicitudserv_activo = utf8_encode($valor["solicitudserv_activo"]);
  $infosolicitud_solicitudserv_fechareg = utf8_encode($valor["solicitudserv_fechareg"]);
  $infosolicitud_usuario_nombre = utf8_encode($valor["usuario_nombre"]);
  $infosolicitud_usuario_apellido = utf8_encode($valor["usuario_apellido"]);
  $infosolicitud_usuario_telf = utf8_encode($valor["usuario_telf"]);
  $infosolicitud_usuario_email = utf8_encode($valor["usuario_email"]);
  $infosolicitud_usuario_img = utf8_encode($valor["usuario_img"]);
  $infosolicitud_compania_nombre = utf8_encode($valor["compania_nombre"]);

  $infosolicitud_usuario = $infosolicitud_usuario_nombre." ".$infosolicitud_usuario_apellido." ";

  $infosolicitud_cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
  $infosolicitud_cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
  $infosolicitud_cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
  $infosolicitud_cuenta = $infosolicitud_cuenta_nombre." ".$infosolicitud_cuenta_apellido." ";


  $infosolicitud_titulo = "#$infosolicitud_solicitudserv_codigo";  

  $infosolicitud_idsolicitud = "<a href='versolicitud.php?id=$infosolicitud_solicitudserv_id'>$infosolicitud_titulo (Ver)</a>";

  $infosolicitud_verenmapa = "<a href='https://www.google.com/maps?ll=$infosolicitud_solicitudserv_latitud,$infosolicitud_solicitudserv_longitud&z=16&t=m&hl=es-AR&gl=US&mapclient=embed&q=34%C2%B036%2713.5%22S+58%C2%B022%2753.7%22W+$infosolicitud_solicitudserv_latitud,+$solicitudserv_longitud@$infosolicitud_solicitudserv_latitud,$infosolicitud_solicitudserv_longitud' target='_blank'  style='color: #0B787A'> (Ver)</a>";


}

$infosolicitud_displaynonegooglemaps=" style ='display: none'";
if ($infosolicitud_solicitudserv_latitud!=""){
  $infosolicitud_displaynonegooglemaps = " style= 'margin-top: 15px'";
}

if ($infosolicitud_textosolicitudes==""){
    $infosolicitud_textosolicitudes .= "
    <tr style='font-size: 14px'>
        <td colspan='5' style='text-align: center'>
            <a href='solicitar'>
                Aún no tienes solicitudes abiertas, click aquí para ver nuestros servicios
            </a>
        </td>        
    </tr>
	    ";
}



if ($infosolicitud_solicitudserv_id!=""){
  if ($iniuser!=$infosolicitud_t_usuario_id){ // Si el usuario que hizo la solicitud es distinto al que esta conectado
    
    $arrresultado = $conexion->doSelect("solicitudservpresta_id, l_estatus_id, estatus.lista_cod",
      "solicitudservicioprestador
        inner join lista estatus on estatus.lista_id = solicitudservicioprestador.l_estatus_id
      ",
      "solicitudservpresta_activo = '1' and solicitudservicioprestador.solicitudserv_id = '$infosolicitud_solicitudserv_id'
        and solicitudservicioprestador.cuenta_id = '$SistemaCuentaId' and solicitudservicioprestador.compania_id = '$SistemaCompaniaId' and solicitudservicioprestador.usuario_id = '$iniuser' "); 

    foreach($arrresultado as $i=>$valor){
      $infosolicitud_solicitudservpresta_id = utf8_encode($valor["solicitudservpresta_id"]);
      $infosolicitud_estatus_id = utf8_encode($valor["l_estatus_id"]);
      $lista_cod = utf8_encode($valor["lista_cod"]);
    }

    if ($lista_cod=="1"){// Si esta como No Leida

      $obtenerCodigoLista = 2; // Solicitud Leida
      $obtenerTipoLista = 45;
      $estatusidleido = ObtenerIdLista($obtenerCodigoLista, $obtenerTipoLista);

      $resultado = $conexion->doUpdate("solicitudservicioprestador", "
          l_estatus_id ='$estatusidleido', 
          solicitudservpresta_utlfecha = '$fechaactual'
        ",
        "solicitudservpresta_id='$infosolicitud_solicitudservpresta_id'");
      }

    
      $arrresultado = $conexion->doSelect("count(*) as total","solicitudservicioprestador",
      "solicitudservpresta_activo = '1' and solicitudservicioprestador.solicitudserv_id = '$infosolicitud_solicitudserv_id'
        and cuenta_id = '$SistemaCuentaId' and compania_id = '$SistemaCompaniaId'"); 

      foreach($arrresultado as $i=>$valor){
        $infosolicitud_total = utf8_encode($valor["total"]);
      }

      if ($infosolicitud_total>"0"){
        $resultado = $conexion->doUpdate("solicitudservicio", "
        solicitudserv_leidos ='$infosolicitud_total'
        ",
        "solicitudserv_id='$infosolicitud_solicitudserv_id'");
      }

 

  }
}

if ($iniuser!=$infosolicitud_t_usuario_id){

  if ($estatusservicioprestador_cod=="2" || $estatusservicioprestador_cod=="1" ){ // Leido y No Leido
    $divmostrarlabel = "
      <a style='color: #0B787A; cursor: pointer;' onclick='vercontactosolicitud()'>
        (Contactar al Cliente) <img src='images/chat.png' alt='Contactar al Cliente' style='height: 50px' title='Contactar al Cliente' />
      </a>
    ";
  }    

  if ($estatusservicioprestador_cod=="3" ){ // Contactado
    $divmostrarlabel = "
      <a href='panel-chat?id=$solicitudservpresta_id' style='color: #0B787A; cursor: pointer;'>
        (Contactar al Cliente) <img src='images/chat.png' alt='Contactar al Cliente' style='height: 50px' title='Contactar al Cliente' />
      </a>
    ";
  }


  if ($estatusservicioprestador_cod=="4"  || $estatusservicioprestador_cod=="5" ){ // Contratado y Calificado

    $divmostrarlabel = "";

    $chatcliente = "
        <a href='panel-chat?id=$solicitudservpresta_id' style='color: #0B787A; cursor: pointer;'>
        (Contactar al Cliente) <img src='images/chat.png' alt='Contactar al Cliente' style='height: 50px' title='Contactar al Cliente' />
      </a>
    ";

    $divinfo  = "
      <div class='row' style='margin-top: 15px'>
          <div class='col-md-4' style='text-align: right; font-weight: 700'>
            
          </div>
          <div class='col-md-8' style='text-align: left'>
            <div style='background: #157A64; padding: 10px 10px; border-radius: 10px'>
              <div class='row'>
                <div class='col-md-12' style='text-align: left; font-weight: 700; color: #FFF'>
                  <i class='fa fa-user'></i> Datos de Contacto 
                </div>                               
              </div>

              <div class='row' style='margin-top: 10px'>
                <div class='col-md-3 col-4' style='text-align: right; font-weight: 700; color: #FFF'>
                  Email:
                </div>
                 <div class='col-md-4 col-8' style='text-align: left; font-weight: normal; color: #FFF'>
                  $infosolicitud_usuario_email
                </div>
              </div>

              <div class='row' style='margin-top: 10px'>
                <div class='col-md-3 col-4' style='text-align: right; font-weight: 700; color: #FFF'>
                  Telefono:
                </div>
                 <div class='col-md-4 col-8' style='text-align: left; font-weight: normal; color: #FFF'>
                  $infosolicitud_usuario_telf
                </div>
              </div>

            </div>
            
          </div>
          
        </div>

    ";

  }
}

if ($estatusservicioprestador_cod=="6" ){ // Otro Prestador Contratado
  $chatcliente = "";
  $divmostrarlabel  ="";
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
                        <h2><i class="fa fa-paper-plane"></i> Solicitud: #<?php echo $infosolicitud_solicitudserv_codigo;?></h2>                        
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Usuario:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $infosolicitud_usuario;?>
                        <?php echo $chatcliente;?>
                        <?php echo $divmostrarlabel;?>
                      </div>
                      
                    </div>
                    <div id="div_datoscontacto">
                      <?php echo $divinfo;?>                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Servicio:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $infosolicitud_categ_nombre;?> / <?php echo $infosolicitud_subcateg_nombre;?>
                      </div>
                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Fecha:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $infosolicitud_solicitudserv_fechareg;?>
                      </div>
                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Titulo Solicitud:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $infosolicitud_solicitudserv_titulo;?>
                      </div>
                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Descripción del Problema:
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $infosolicitud_solicitudserv_descrip;?>
                      </div>
                      
                    </div>
                    <div class="row" style="margin-top: 15px">
                      <div class="col-md-4 col-4" style="text-align: right; font-weight: 700">
                        Ubicación de la Solicitud:   
                      </div>
                      <div class="col-md-8 col-8" style="text-align: left">
                        <?php echo $infosolicitud_solicitudserv_infodir." ".$infosolicitud_verenmapa;?> 



                        <div class="form-group " <?php echo $infosolicitud_displaynonegooglemaps;?> >                
                            <iframe src="https://maps.google.com/maps?q=<?php echo $infosolicitud_solicitudserv_latitud;?>,<?php echo $infosolicitud_solicitudserv_longitud;?>&hl=es;z=14&amp;output=embed" id="iframemaps" name="iframemaps" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                      </div>
                      
                    </div>

                    <input type="hidden" id="id" value="<?php echo $infosolicitud_solicitudserv_id;?>">
                  
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

