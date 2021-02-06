<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/xajax_0.2.4/xajax.inc.php';
include_once 'lib/base.php';
include_once 'lib/funciones.php';
include_once 'lib/mysqlclass.php';
include_once 'lib/phpmailer/libemail.php';
include_once 'lib/config.php';
include_once 'lib/funciones.php';

$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;


$xajax = new xajax('lib/ajx_fnci.php');
$xajax->registerFunction('ingresarusuario');

$base = base();

$fechaactual = formatoFechaHoraBd();

(isset($_GET['s'])) ? $getsalir_id=$_GET['s'] :$getsalir_id='';
(isset($_GET['sid'])) ? $getservicio_id=$_GET['sid'] :$getservicio_id='';
(isset($_GET['cod'])) ? $getcodigoverificar=$_GET['cod'] :$getcodigoverificar='';
(isset($_POST['email'])) ? $getemail=$_POST['email'] :$getemail='';

if ($getsalir_id==1){
  session_start();
  session_destroy();  
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

    $titulopagina = "Iniciar Sesión - ".$compania_nombre;
    $descripcionpagina = "Iniciar Sesión - $compania_nombre. Ingresa a nuestra plataforma y comienza a buscar y ofrecer tus servicios cerca de tu ubicación";

}


if ($getemail!=""){

  $conexion = new ConexionBd();
  $arrresultado = $conexion->doSelect("usuario.usuario_id, usuario.usuario_nombre, usuario.usuario_apellido, 
    usuario.usuario_email, usuario.usuario_telf, compania.compania_nombre, usuario.usuario_clave, 
    usuario.cuenta_id, usuario.compania_id",
    "usuario
      inner join compania on usuario.compania_id = compania.compania_id
    ",
    "usuario.usuario_activo ='1' and usuario.usuario_email = '$getemail'");

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

    $resul_titulonotificacion = "Recuperar Clave - $resul_compania_nombre";

    $mensaje = "
      Ha solicitado recuperar su clave para ingresar a $resul_compania_nombre

      <br>
      <br><strong>Compañía:</strong> ".$resul_compania_nombre."
      <br><strong>Nombre:</strong> ".$resul_usuario."
      <br><strong>Email:</strong> ".$resul_usuario_email."
      <br><strong>Clave:</strong> ".$resul_usuario_clave."
      <br><br>
      Al ingresar recomendamos cambiar su clave para mayor seguridad
      
    ";

      $link  = $compania_urlweb."iniciar-sesion";     

      $texto = "
        
          <table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='ffffff' class='bg_color'>

              <tr>
                  <td align='center'>
                      <table border='0' align='center' width='590' cellpadding='0' cellspacing='0' class='container590'>
                          
                          <tr>
                              <td align='left' style='color: #343434; font-size: 16px; font-family: Calibri, sans-serif; font-weight:normal;letter-spacing: 2px; line-height: 35px;' class='main-header'>
                                  <div style='line-height: 35px'>

                                      $mensaje

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
                                                  <a href='$link' style='color: #ffffff; text-decoration: none;'>Ingresar</a>
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
                                                  <br><br> Puede copiar y pegar el siguiente enlace<br>
                                                  <a href='$link'>
                                                      $link
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
          </table>
          
              </td>
          </tr>

      </table>
      <!-- end section -->

      
      ";

        $notif_visible = 0;
        $tiponotificacion = 103; // 103 = Email  104 = Sistema  

       if ($tiponotificacion=="103"){ // Email, enviar de una vez

          $libemail = new LibEmail();
          
          $resultado = $libemail->enviarcorreo($resul_usuario_email, $resul_titulonotificacion, $texto, $resul_compania_id);
          //$resultado = $libemail->enviarcorreo("meneses.rigoberto@gmail.com", $asunto, $texto, $compania);

        }

        $resul_descripcionnotificacion = utf8_decode($texto);

        $resul_descripcionnotificacion = addslashes($resul_descripcionnotificacion);
                

        InsertarNotificacion("32", "usuario", $resul_usuario_id, $resul_titulonotificacion, $resul_descripcionnotificacion, $resul_usuario_id, $resul_usuario_id, $resul_cuenta_id, $resul_compania_id, $resul_usuario_email, $resul_usuario_telf, $notif_visible, $tiponotificacion);

        $inforegistro = "
          <div class='alert alert-success' style='text-align: center; font-weight: bold'>
              <a style='color: #000'>
                  Por favor revise su email para observar los datos para iniciar sesion<br>si no lo observa en bandeja de entrada puede revisar su carpeta de spam.
              </a>
          </div>     ";


  }else{
     $inforegistro = "
      <div class='alert alert-danger' style='text-align: center; font-weight: bold'>
          <a style='color: #000'>
              Error: El email ingresado no existe, por favor verifique
          </a>
      </div>     ";
  }  

} else if ($getcodigoverificar!=""){

  $conexion = new ConexionBd();
      $arrresultado = $conexion->doSelect("
        usuario_id,  usuario_clave, cuenta_id, compania_id,
          usuario_activo, usuario_eliminado, perfil_id,
          usuario_nombre, usuario_email, usuario_emailverif, l_tipousuarioserv_id
        ",
          "usuario
          ",
          "usuario_activo ='1' and usuario_codverif = '$getcodigoverificar'");

      if (count($arrresultado)>0){
        foreach($arrresultado as $i=>$valor){

          $usuario_id = utf8_encode($valor["usuario_id"]);
          $perfil_id = utf8_encode($valor["perfil_id"]);
          $usuario_nombre = utf8_encode($valor["usuario_nombre"]);
          $usuario_email = utf8_encode($valor["usuario_email"]);
          $usuario_activo = utf8_encode($valor["usuario_activo"]);
          $usuario_empresa = utf8_encode($valor["usuario_empresa"]);
          $usuario_clave = utf8_encode($valor["usuario_clave"]);
          $usuario_emailverif = utf8_encode($valor["usuario_emailverif"]);
          $t_cuenta_id = utf8_encode($valor["cuenta_id"]);
          $t_compania_id = utf8_encode($valor["compania_id"]);
          $l_tipousuarioserv_id = utf8_encode($valor["l_tipousuarioserv_id"]);

        }

        if ($usuario_emailverif=="1"){
          $inforegistro = "
            <div class='alert alert-success' style='text-align: center; font-weight: bold'>
                <a style='color: #000'>
                    Ya el email fue verificado con anterioridad, puede ingresar a su cuenta
                </a>
            </div>     ";
        }else{
          $inforegistro = "
            <div class='alert alert-success' style='text-align: center; font-weight: bold'>
                <a style='color: #000'>
                    Email Verificado Correctamente, puede ingresar a su cuenta
                </a>
            </div>     ";

        }

        VerificarUsuarioEstatus($usuario_id);

        $resultado = $conexion->doUpdate("usuario", "
        usuario_emailverif ='1'
        ",
        "usuario_id='$usuario_id'");     

        $idrequisito = "162";

        $resultado = $conexion->doInsert("
        requisito
          (l_requisitolista_id, requisito_descrip, l_tipoarchivo_id, requisito_arch, requisito_archnombre, requisito_cantarchivos, cuenta_id, compania_id, requisito_activo, requisito_eliminado, requisito_fechareg, usuario_idreg, l_estatus_id, usuario_id)
        ",
        "'$idrequisito', '', '0', '', '', 
        '1', '$t_cuenta_id', '$t_compania_id', '1', '0', '$fechaactual',
        '$usuario_id', '165', '$usuario_id'");



      }else{

        $inforegistro = "
          <div class='alert alert-danger' style='text-align: center; font-weight: bold'>
              <a style='color: #000'>
                  El codigo de verificación es incorrecto, intente nuevamente con el link que recibió vía email o<br> contactese con nosotros a traves del formulario de contacto
              </a>
          </div>     ";

      }


}


(isset($_GET['i'])) ? $getinfo=$_GET['i'] :$getinfo='';

if ($getinfo=="1"){

     $inforegistro = "
        <div class='alert alert-success' style='text-align: center; font-weight: bold'>
            <a style='color: #000'>
                Inicia sesión para ingresar a esta sección
            </a>
        </div>
     ";
}




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php echo $base; ?>
    <?php $xajax->printJavascript('lib/'); ?>
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

<section class="page-title">
  <!-- Container Start -->
  <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2 text-center">
        <!-- Title text -->
        <h3>Iniciar Sesión</h3>
      </div>
    </div>
  </div>
  <!-- Container End -->
</section>

<section class="login py-5 border-top-1">
    <div class="container">
        <?php echo $inforegistro;?>
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 align-item-center">
                <div class="border">
                    <h3 class="bg-gray p-4" style="text-align: center">Iniciar Sesión</h3>
                    <form action="javascript:ingresarusuario()" >
                        <fieldset class="p-4">
                            <input type="text" placeholder="Email *" id="email" name="email" required="required" class="border p-3 w-100 my-2" />
                            <input type="password" placeholder="Clave *" id="password" name="password" class="border p-3 w-100 my-2" />
                            <div style="padding-top: 10px">                              
                              <input type="checkbox" id="mantenerconectado"  style="cursor: pointer;">
                              <label for="mantenerconectado" style="cursor: pointer;">Mantenerme conectado </label>
                            </div>                            
                            <center>
                                <button type="submit" class="d-block py-3 px-5 bg-primary text-white border-0 rounded font-weight-bold mt-3">Iniciar Sesión</button>
                            </center>
                            <a class="mt-3 d-block  text-primary" href="olvido-clave">¿Olvidaste tu contraseña?</a>
                            <a class="mt-3 d-inline-block text-primary" href="registro"> 
                              ¿Aún no tienes cuenta? Registrate aquí
                            </a>

                            <input type="hidden" id="sid" name="sid" value="<?php echo $getservicio_id;?>">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
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



