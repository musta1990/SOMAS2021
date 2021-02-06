<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/base.php';
include_once 'lib/funciones.php';
include_once 'lib/mysqlclass.php';
include_once 'lib/phpmailer/libemail.php';
include_once 'lib/config.php';

$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

$base = base();

$conexion = new ConexionBd();
$arrresultado = ObtenerDatosCompania($SistemaCuentaId, $SistemaCompaniaId);
foreach($arrresultado as $i=>$valor){

    $compania_id = utf8_encode($valor["compania_id"]);
    $compania_nombre = utf8_encode($valor["compania_nombre"]);
    $compania_email = utf8_encode($valor["compania_email"]);
    $compania_whatsapp = utf8_encode($valor["compania_whatsapp"]);
    $compania_img = utf8_encode($valor["compania_img"]);
    $compania_imgicono = utf8_encode($valor["compania_imgicono"]);
    $compania_urlweb = utf8_encode($valor["compania_urlweb"]);

    $urlcompaniaimg = $UrlFiles."admin/arch/$compania_img";
    $urlcompaniaimgicono = $UrlFiles."admin/arch/$compania_imgicono";

    $titulopagina = "Contacto - ".$compania_nombre;
    $descripcionpagina = "Contacto - $compania_nombre.";


}


(isset($_POST['name'])) ? $name=$_POST['name'] :$name='';
(isset($_POST['email'])) ? $email=$_POST['email'] :$email='';
(isset($_POST['message'])) ? $message=$_POST['message'] :$message='';
(isset($_POST['phone'])) ? $phone=$_POST['phone'] :$phone='';


if ($name!=""){

  $libemail = new LibEmail();        

  $texto = "
    <!-- big image section -->
    <table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='ffffff' class='bg_color'>

      <tr>
          <td align='center'>
              <table border='0' align='center' width='590' cellpadding='0' cellspacing='0' class='container590'>
                  
                  <tr>
                      <td align='center' style='color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;' class='main-header'>
                          <div style='line-height: 35px'>
                              Hola $name, recibimos tu mensaje de forma correcta, ya en breve te responderemos.
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
                      <td height='20' style='font-size: 20px; line-height: 20px;'>&nbsp;</td>
                  </tr>
                  <tr>
                      <td align='left' style='color: #343434; font-size: 17px; font-family: Quicksand, Calibri, sans-serif; font-weight:normal;letter-spacing: 3px; line-height: 35px;' class='main-header'>
                          <div style='line-height: 26px;'>
                              <strong>Nombre:</strong> $name
                              <br>
                              <strong>Email:</strong> $email
                              <br>
                              <strong>Telefono:</strong> $phone
                              <br>
                              <strong>Mensaje:</strong> $message
                              <br>
                          </div>
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
  ";

  $inforegistro = "
            <div class='alert alert-success' style='text-align: center; font-weight: bold'>
                <a style='color: #000'>
                    Mensaje recibido correctamente, en breve te responderemos directo a tu email.
                </a>
            </div>     ";

  $asunto = "Recibimos tu Mensaje - $compania_nombre ";

  $resultado = $libemail->enviarcorreo($email, $asunto, $texto, $SistemaCompaniaId);  
  
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
    
<!-- page title -->
<!--================================
=            Page Title            =
=================================-->
<section class="page-title">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2 text-center">
				<!-- Title text -->
				<h3>Contáctenos</h3>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>
<!-- page title -->

<!-- contact us start-->
<section class="section">
    <div class="container">
      <?php echo $inforegistro;?>
        <div class="row">
            <div class="col-md-6">
                <div class="contact-us-content p-4">
                    <h1>Contáctanos</h1>
                    <h5 class="pt-3">¿Tienes alguna pregunta?</h5>
                    <p class="pt-3 pb-2">Estamos para ayudarte y buscar la solución mas rapida a sus necesidades.</p>

                    <a href="https://api.whatsapp.com/send?phone=<?php echo $compania_whatsapp;?>">
                        <img src="images/whatsapp.png" style="height:30px;" alt="Escribenos al WhatsApp - <?php echo $compania_nombre;?>"  title="Escribenos al WhatsApp - <?php echo $compania_nombre;?>" />
                        <strong>WhatsApp:</strong> +<?php echo $compania_whatsapp;?>
                    </a>
                    <br>
                    <a href="mailto:<?php echo $compania_email;?>">
                        <img src="images/email2.png" style="height:30px;" alt="Escribenos al Email - <?php echo $compania_nombre;?>"  title="Escribenos al Email - <?php echo $compania_nombre;?>" />
                        <strong>Email:</strong> <?php echo $compania_email;?>
                    </a>
                    <br><br>
                </div>
            </div>
            <div class="col-md-6">
                <form action="contacto" method="POST">
                    <fieldset class="p-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 py-2">
                                    <input type="text" name="name" placeholder="Nombre *" class="form-control" required>
                                </div>
                                <div class="col-lg-6 pt-2">
                                    <input type="text" name="phone" placeholder="Telefono *" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 py-2">
                                <input type="email" name="email" placeholder="Email *" class="form-control" required>
                            </div>                                
                        </div>                            
                        <textarea name="message"  placeholder="Escribenos tu mensaje *" class="border w-100 p-3 mt-3 mt-lg-4"></textarea>
                        <div class="btn-grounp">
                            <button type="submit" class="btn btn-primary mt-2 float-right">Enviar Mensaje</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- contact us end -->

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



