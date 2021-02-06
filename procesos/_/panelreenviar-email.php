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
    $compania_email = utf8_encode($valor["compania_email"]);
    $compania_whatsapp = utf8_encode($valor["compania_whatsapp"]);
    


    $urlcompaniaimg = $UrlFiles."admin/arch/$compania_img";
    $urlcompaniaimgicono = $UrlFiles."admin/arch/$compania_imgicono";

    $titulopagina = "Reenvio de Email Correctamente - ".$compania_nombre;
    $descripcionpagina = "Reenvio de Email Correctamente - $compania_nombre ";

}


$arrresultado = $conexion->doSelect("usuario.usuario_id, usuario.usuario_nombre, usuario.usuario_apellido, 
usuario.usuario_email, usuario.usuario_telf, compania.compania_nombre, compania_email, usuario.usuario_clave, 
usuario.cuenta_id, usuario.compania_id, requisito.requisito_id as requisito_id, usuario_codverif",
"usuario
    inner join compania on usuario.compania_id = compania.compania_id
    left join requisito on requisito.usuario_id = usuario.usuario_id
              and requisito.l_requisitolista_id = '162' and requisito.l_estatus_id = '165'
",
"usuario.usuario_activo ='1' and usuario.usuario_id = '$iniuser'  and usuario.cuenta_id = '$SistemaCuentaId' and usuario.compania_id = '$SistemaCompaniaId' ");

if (count($arrresultado)>0){    
    foreach($arrresultado as $i=>$valor){
        $ren_requisito_id = utf8_encode($valor["requisito_id"]);           
        $resul_compania_nombre = utf8_encode($valor["compania_nombre"]); 
        $resul_compania_email = utf8_encode($valor["compania_email"]); 
        $resul_usuario_id = utf8_encode($valor["usuario_id"]); 
        $resul_usuario_nombre = utf8_encode($valor["usuario_nombre"]); 
        $resul_usuario_apellido = utf8_encode($valor["usuario_apellido"]); 
        $resul_usuario_email = utf8_encode($valor["usuario_email"]); 
        $resul_compania_id = utf8_encode($valor["compania_id"]); 
        $usuario_codverif = utf8_encode($valor["usuario_codverif"]); 

        $resul_usuario = $resul_usuario_nombre." ".$resul_usuario_apellido;        
    }

    if ($ren_requisito_id==""){ 

        $resul_titulonotificacion = "Reenvio Confirmacion Registro - $resul_compania_nombre";

        $linkconfirmar  = $compania_urlweb."iniciar-sesion?cod=$usuario_codverif";    

        $texto  ="
          <!-- big image section -->
                      <table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='ffffff' class='bg_color'>

                          <tr>
                              <td align='center'>
                                  <table border='0' align='center' width='590' cellpadding='0' cellspacing='0' class='container590'>
                                      
                                      <tr>
                                          <td align='center' style='color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;' class='main-header'>
                                              <div style='line-height: 35px'>

                                                  $resul_usuario, Confirma tu <span style='color: #3E87AB;'>EMAIL</span>

                                              </div>
                                          </td>
                                      </tr>

                                      <tr>
                                          <td height='10' style='font-size: 10px; line-height: 10px;'>&nbsp;</td>
                                      </tr>

                                      <tr>
                                          <td align='center'>
                                              <table border='0' width='40' align='center' cellpadding='0' cellspacing='0' bgcolor='eeeeee'>
                                                  <tr>
                                                      <td height='2' style='font-size: 2px; line-height: 2px;'>&nbsp;</td>
                                                  </tr>
                                              </table>
                                          </td>
                                      </tr>

                                      

                                      <tr>
                                          <td height='25' style='font-size: 25px; line-height: 25px;'>&nbsp;</td>
                                      </tr>

                                      <tr>
                                          <td align='center'>
                                              <table border='0' align='center' width='160' cellpadding='0' cellspacing='0' bgcolor='0EB521' style=''>

                                                  <tr>
                                                      <td height='10' style='font-size: 10px; line-height: 10px;'>&nbsp;</td>
                                                  </tr>

                                                  <tr>
                                                      <td align='center' style='color: #ffffff; font-size: 14px; font-family: Calibri, sans-serif; line-height: 26px;'>


                                                          <div style='line-height: 26px;'>
                                                              <a href='$linkconfirmar' style='color: #ffffff; text-decoration: none;'>Confirmar Email</a>
                                                          </div>
                                                      </td>
                                                  </tr>

                                                  <tr>
                                                      <td height='10' style='font-size: 10px; line-height: 10px;'>&nbsp;</td>
                                                  </tr>

                                              </table>
                                          </td>
                                      </tr>

                                      <tr>
                                          <td height='20' style='font-size: 20px; line-height: 20px;'>&nbsp;</td>
                                      </tr>

                                      <tr>
                                          <td align='center'>
                                              <table border='0' width='500' align='center' cellpadding='0' cellspacing='0' class='container590'>
                                                  <tr>
                                                      <td align='center' style='color: #444444; font-size: 16px; font-family: Calibri, sans-serif; line-height: 24px;'>


                                                          <div style='line-height: 24px'>
                                                              Para continuar siendo una plataforma segura por favor confirma tu email copiando y pegando el siguiente enlace, o darle click en 'Confirmar Email'
                                                              <br><br>
                                                              <a href='$linkconfirmar'>
                                                                  $linkconfirmar
                                                              </a>
                                                          </div>
                                                      </td>
                                                  </tr>
                                              </table>
                                          </td>
                                      </tr>


                                  </table>

                              </td>
                          </tr>
                          <tr class='hide'>
                              <td height='25' style='font-size: 25px; line-height: 25px;'>&nbsp;</td>
                          </tr>
                          <tr>
                              <td height='20' style='font-size: 20px; line-height: 20px;'>&nbsp;</td>
                          </tr>


                      </table>
                      <!-- end section -->                     
                      </td>
                  </tr>

                  <tr>
                      <td height='40' style='font-size: 40px; line-height: 40px;'>&nbsp;</td>
                  </tr>

              </table>
          ";       


/*

                                          <tr>
                                              <td align='left'>
                                                  <table border='0' align='left' cellpadding='0' cellspacing='0' class='container590'>
                                                      <tr>
                                                          <td align='center'>
                                                              <table align='center' width='40' border='0' cellpadding='0' cellspacing='0' bgcolor='eeeeee'>
                                                                  <tr>
                                                                      <td height='2' style='font-size: 2px; line-height: 2px;'></td>
                                                                  </tr>
                                                              </table>
                                                          </td>
                                                      </tr>
                                                  </table>
                                              </td>
                                          </tr>

                                          <tr>
                                              <td height='5' style='font-size: 6px; line-height: 6px;'>&nbsp;</td>
                                          </tr>

                                          <tr>
                                              <td align='left' style='color: #888888; font-size: 16px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 24px;' class='align-center'>


                                                  <div style='line-height: 24px'>
                                                      Busca los mejores profesionales en el servicio que estas necesitando
                                                  </div>
                                              </td>
                                          </tr>
*/
    
        $notif_visible = 0;
        $tiponotificacion = 103; // 103 = Email  104 = Sistema  

       if ($tiponotificacion=="103"){ // Email, enviar de una vez

          $libemail = new LibEmail();
          
          $resultado = $libemail->enviarcorreo($resul_usuario_email, $resul_titulonotificacion, $texto, $resul_compania_id);
          //$resultado = $libemail->enviarcorreo("meneses.rigoberto@gmail.com", $resul_titulonotificacion, $texto, $resul_compania_id);

          //$resultado = $libemail->enviarcorreo($resul_compania_email, $resul_titulonotificacion, $texto, $resul_compania_id);

        }          

        $resul_descripcionnotificacion = utf8_decode($texto);
        $resul_descripcionnotificacion = addslashes($resul_descripcionnotificacion);

        InsertarNotificacion("32", "usuario", $resul_usuario_id, $resul_titulonotificacion, $resul_descripcionnotificacion, $resul_usuario_id, $resul_usuario_id, $resul_cuenta_id, $resul_compania_id, $resul_usuario_email, $resul_usuario_telf, $notif_visible, $tiponotificacion);

        $infonotificacion = "
          <div class='alert alert-success' style='text-align: center; font-weight: bold'>
              <a style='color: #000'>
                  Reenvio de Email Correctamente. <br>
                  Por favor revise su email para observar los datos para iniciar sesion, si no lo observa en bandeja de entrada puede revisar su carpeta de spam.
              </a>
          </div>     ";

      }else{

        $infonotificacion = "
          <div class='alert alert-success' style='text-align: center; font-weight: bold'>
              <a style='color: #000'>
                  Ya su Email se encuentra verificado Correctamente.
              </a>
          </div>     ";

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
            <?php echo $infonotificacion;?>
            <!-- Row Start -->
            <div class="row">
                <div class="col-md-10 offset-md-1 col-lg-3 offset-lg-0 order-sm-1 order-2">
                    <?php include_once "panel-sidebar.php"; ?>
                </div>
                <div class="col-md-10 offset-md-1 col-lg-9 offset-lg-0 order-sm-2 order-1">
                    
                    <!-- Recently Favorited -->
                    <div class="widget welcome-message" style="padding-bottom: 10px">
                        <h2><i class="fa fa-envelope"></i> Reenvío de Email Correctamente</h2>
                        <p>
                            Por favor revise su casilla de email para la confirmacion del registro, recuerde revisar la carpeta de spam en caso de no estar en la bandeja de entrada.
                            <br>
                            De no recibir el email de confirmación puede contactarnos directamente por estos medios:
                            <br><br>
                            <a href="https://api.whatsapp.com/send?phone=<?php echo $compania_whatsapp;?>">
                                <img src="images/whatsapp.png" style="height:30px;" alt="Escribenos al WhatsApp - <?php echo $compania_nombre;?>"  title="Escribenos al WhatsApp - <?php echo $compania_nombre;?>" />
                                <strong>WhatsApp:</strong> <?php echo $compania_whatsapp;?>
                            </a>
                            <br><br>
                            <a href="mailto:<?php echo $compania_email;?>">
                                <img src="images/email2.png" style="height:30px;" alt="Escribenos al Email - <?php echo $compania_nombre;?>"  title="Escribenos al Email - <?php echo $compania_nombre;?>" />
                                <strong>Email:</strong> <?php echo $compania_email;?>
                            </a>
                            <br><br>
                            <a href="contacto">
                                <img src="images/form.png" style="height:30px;" alt="Escribenos por el Formulario de Contacto - <?php echo $compania_nombre;?>"  title="Escribenos por el Formulario de Contacto - <?php echo $compania_nombre;?>" />
                                <strong>Formulario de Contacto</strong>
                            </a>


                        </p>
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

