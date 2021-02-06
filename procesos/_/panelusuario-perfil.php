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

    $titulopagina = "Perfil - ".$compania_nombre;
    $descripcionpagina = "Perfil - $compania_nombre ";

}


$arrresultado = $conexion->doSelect("usuario_id, usuario_codigo, usuario_email, usuario_clave, usuario_nombre, usuario_apellido, 
    usuario_telf, usuario_activo, usuario_eliminado, usuario_documento, usuario_img, perfil_id, 
    usuario_direccion, usuario_localidad, usuario_actividad, nacionalidad_id, sexo_id, e_estadocivil_id, 
    usuario_conyugenombre, usuario_conyugetelf, usuario_pariente, usuario_parientetelf, e_parentesco_id, 
    usuario_telfdos, usuario_notas, usuario_porcentajecolocador, usuario_balance, usuario_comentarios, usuario_tasapref,
    DATE_FORMAT(usuario_fechanac,'%d/%m/%Y') as usuario_fechanac, nivelriesgo_id,
    DATE_FORMAT(usuario_fechareg,'%d/%m/%Y') as usuario_fechareg, usuario_alias, l_tipousuarioserv_id",
	"usuario",
	"usuario_activo = '1' and usuario_id = '$iniuser'  and usuario.cuenta_id = '$SistemaCuentaId' and usuario.compania_id = '$SistemaCompaniaId' ", null, "usuario_id asc");
foreach($arrresultado as $i=>$valor){

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
	$usuario_direccion = utf8_encode($valor["usuario_direccion"]);
	$usuario_localidad = utf8_encode($valor["usuario_localidad"]);
	$usuario_actividad = utf8_encode($valor["usuario_actividad"]);
	$t_nacionalidad_id = utf8_encode($valor["nacionalidad_id"]);
	$t_sexo_id = utf8_encode($valor["sexo_id"]);
	$e_estadocivil_id = utf8_encode($valor["e_estadocivil_id"]);
	$usuario_conyugenombre = utf8_encode($valor["usuario_conyugenombre"]);
	$usuario_conyugetelf = utf8_encode($valor["usuario_conyugetelf"]);
	$usuario_pariente = utf8_encode($valor["usuario_pariente"]);
	$usuario_parientetelf = utf8_encode($valor["usuario_parientetelf"]);
	$e_parentesco_id = utf8_encode($valor["e_parentesco_id"]);
	$usuario_telfdos = utf8_encode($valor["usuario_telfdos"]);
	$usuario_notas = utf8_encode($valor["usuario_notas"]);
	$usuario_porcentajecolocador = utf8_encode($valor["usuario_porcentajecolocador"]);
	$usuario_balance = utf8_encode($valor["usuario_balance"]);
	$usuario_comentarios = utf8_encode($valor["usuario_comentarios"]);
	$usuario_tasapref = utf8_encode($valor["usuario_tasapref"]);
	$usuario_fechanac = utf8_encode($valor["usuario_fechanac"]);
	$t_nivelriesgo_id = utf8_encode($valor["nivelriesgo_id"]);
    $usuario_fechareg = utf8_encode($valor["usuario_fechareg"]);
    $l_tipousuarioserv_id = utf8_encode($valor["l_tipousuarioserv_id"]);
    $usuario_img = utf8_encode($valor["usuario_img"]);
    
    

}

if ($usuario_id==""){
  echo "<script language='JavaScript'>window.location = 'iniciar-sesion'; </script>";
  exit();
}

$optiontipoperfilservicio = ObtenerLista('41', $SistemaCuentaId, $SistemaCompaniaId, $l_tipousuarioserv_id); 




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
            <!-- Row Start -->
            <div class="row">
                <div class="col-md-10 offset-md-1 col-lg-3 offset-lg-0 order-sm-1 order-2">
                    <?php include_once "panel-sidebar.php"; ?>
                </div>
                <div class="col-md-10 offset-md-1 col-lg-9 offset-lg-0 order-sm-2 order-1">
                    <?php include_once "panel-notificaciones.php"; ?>
                    <!-- Edit Profile Welcome Text -->
                    <div class="widget welcome-message" style="padding-bottom: 10px">
                        <h2><i class="fa fa-user"></i> Perfil</h2>
                        <p>Recuerda mantener actualizado tu perfil y asi podremos gestionar en el menor tiempo posible tus solicitudes.</p>
                    </div>
                    <!-- Edit Personal Info -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget personal-info">
                                
                                <form method="post" action="uploadperfil" target="iframeupload" enctype="multipart/form-data">                 
                                    
                                    <div class="row" style="margin-top: 15px">
                                        <div class="col-lg-2" style="text-align: right;">
                                            <img src="arch/<?php echo $usuario_img;?>" style="width: 100%;">
                                            <br />
                                        </div>
                                        <div class="col-lg-9">
                                            <label class="control-label"> Cargue su Imagen</label>
                                            <div class='form-group ' style='overflow: hidden; '>
                                                <input type='file' id='file' name='file1'>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 15px">
										
                                        <div class="col-md-6" style="margin-top: 15px">
                                            <label>Nombre: <span style="color: red">*</span> </label>
                                            <input type="text" name="usuario_nombre" class="form-control" placeholder="Nombre *" required="required" value="<?php echo $usuario_nombre;?>">
                                        </div>
                                        <div class="col-md-6" style="margin-top: 15px">
                                            <label>Apellido: <span style="color: red"></span> </label>
                                            <input type="text" name="usuario_apellido" class="form-control" placeholder="Apellido "  value="<?php echo $usuario_apellido;?>">
                                        </div>
                                        <div class="col-md-6" style="margin-top: 15px">
                                            <label>Email: <span style="color: red">*</span></label>
                                            <input type="text" name="usuario_email" class="form-control" placeholder="Email *" required="required" value="<?php echo $usuario_email;?>">
                                        </div>
                                        <div class="col-md-6" style="margin-top: 15px">
                                            <label>Telefono:</label>
                                            <input type="text" name="usuario_telf" class="form-control" placeholder="Telefono" value="<?php echo $usuario_telf;?>">
                                        </div>
                                        <div class="col-md-6" style="margin-top: 15px">
                                            <label>Contraseña:</label>
                                            <input type="password" name="usuario_clave" class="form-control" placeholder="Contraseña" value="<?php echo $usuario_clave;?>" required="required">
                                        </div>
                                        <div class="col-md-6" style="margin-top: 15px">
                                            <label>Confirmar Contraseña:</label>
                                            <input type="password" name="usuario_clave2" class="form-control" placeholder="Confirmar Contraseña" value="<?php echo $usuario_clave;?>"  required="required">
                                        </div>
                                        <div class="col-md-6" style="margin-top: 15px">
                                            <label>Alias: <span style="color: red"></span> </label>
                                            <input type="text" name="usuario_alias" class="form-control" placeholder="Alias "  value="<?php echo $usuario_alias;?>">
                                        </div>
                                        <div class="col-md-12" style="margin-top: 15px">
                                            <input type="submit" name="submit" value="Guardar Perfil" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                                <iframe id="iframeupload" name="iframeupload" height="0" width="0"></iframe>
                                
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
    <script src="plugins/fancybox/jquery.fancybox.pack.js"></script>
    <script src="plugins/smoothscroll/SmoothScroll.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>

