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
$xajax->registerFunction('cargarsubcategoriaservicio');
$xajax->registerFunction('agregarserviciousuario');
$xajax->registerFunction('eliminarusuarioserviciocategoria');
$xajax->registerFunction('eliminarusuarioserviciosubcategoria');
$xajax->printJavascript('lib/');

(isset($_GET['i'])) ? $getinfo=$_GET['i'] :$getinfo='';

if ($getinfo=="1"){

    $infonotificacion = "
          <div class='alert alert-success' style='text-align: center; font-weight: bold'>
              <a style='color: #000'>
                  Gracias por registrarse en nuestra plataforma. <br> Complete los datos de los servicios que ofrece y de su Ubicación
              </a>
          </div>     ";
    
}



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

    $titulopagina = "Servicios Ofrecidos - ".$compania_nombre;
    $descripcionpagina = "Servicios Ofrecidos - $compania_nombre ";

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
    $usuario_idorig = utf8_encode($valor["usuario_id"]);
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
    "usuario_activo = '1' and usuario.usuario_id = '$iniuser'");
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


$arrresultado = $conexion->doSelect("cliente.usuario_id, cliente.usuario_codigo, cliente.usuario_email, cliente.usuario_clave, cliente.usuario_nombre, cliente.usuario_apellido, cliente.usuario_telf,  cliente.usuario_activo, cliente.usuario_img, cliente.perfil_id, cliente.l_tipodocumento_id,
    cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
    cuenta.usuario_apellido as cuenta_apellido, compania_nombre,
    DATE_FORMAT(cliente.usuario_fechareg,'%d/%m/%Y %H:%i:%s') as usuario_fechareg,

    usuarioservicio.usuarioservicio_id, usuarioservicio.usuario_id, usuarioservicio.l_categservicio_id,
    usuarioservicio.l_subcategservicio_id, 
    usuarioservicio.cuenta_id, usuarioservicio.compania_id, 
    usuarioservicio.usuarioservicio_activo, usuarioservicio_eliminado, 
    usuarioservicio.usuarioservicio_fechareg, usuarioservicio.usuario_idreg,

    categoria.lista_nombre as categ_nombre, categoria.lista_img as categ_img, 
    subcategoria.lista_nombre as subcateg_nombre, subcategoria.lista_img as subcateg_img

    ",
    "usuario cliente
        inner join usuarioservicio on usuarioservicio.usuario_id = cliente.usuario_id
        inner join usuario cuenta on usuarioservicio.cuenta_id = cuenta.usuario_id
        inner join compania on compania.compania_id = usuarioservicio.compania_id
        inner join lista categoria on categoria.lista_id = usuarioservicio.l_categservicio_id           
        inner join lista subcategoria on subcategoria.lista_id = usuarioservicio.l_subcategservicio_id
    ",
    "cliente.usuario_eliminado = '0' and usuarioservicio_activo = '1' and usuarioservicio.usuario_id = '$iniuser'  and cliente.cuenta_id = '$SistemaCuentaId' and cliente.compania_id = '$SistemaCompaniaId' ", null, "categoria.lista_nombre, categoria.lista_id asc");
$cont = 0;
foreach($arrresultado as $i=>$valor){

    $usuarioservicio_id = utf8_encode($valor["usuarioservicio_id"]);
    $l_categservicio_id = utf8_encode($valor["l_categservicio_id"]);
    $l_subcategservicio_id = utf8_encode($valor["l_subcategservicio_id"]);
    $usuarioservicio_activo = utf8_encode($valor["usuarioservicio_activo"]);
    $categ_nombre = utf8_encode($valor["categ_nombre"]);
    $subcateg_nombre = utf8_encode($valor["subcateg_nombre"]);

    $categ_img = utf8_encode($valor["categ_img"]);
    $subcateg_img = utf8_encode($valor["subcateg_img"]);

    $cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
    $cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
    $cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
    $cuenta = $cuenta_nombre." ".$cuenta_apellido." ";

    $usuario_id = utf8_encode($valor["usuario_id"]);
    $usuario_codigo = utf8_encode($valor["usuario_codigo"]);
    $usuario_email = utf8_encode($valor["usuario_email"]);
    $usuario_clave = utf8_encode($valor["usuario_clave"]);
    $usuario_nombre = utf8_encode($valor["usuario_nombre"]);
    $usuario_apellido = utf8_encode($valor["usuario_apellido"]);
    $usuario_telf = utf8_encode($valor["usuario_telf"]);
    $usuario_fechareg = utf8_encode($valor["usuario_fechareg"]);
    $usuario_activo = utf8_encode($valor["usuario_activo"]);
    
    $compania_nombre = utf8_encode($valor["compania_nombre"]);

    $urlc = $UrlFiles."admin/arch/$categ_img";
    $urlsc = $UrlFiles."admin/arch/$subcateg_img";

    if ($l_categservicio_idold!=$l_categservicio_id && $cont!=0){
        $agregar = "
            </div>
            <hr>    
        ";
    }    

    if ($l_categservicio_idold!=$l_categservicio_id){

        $subcategoriasusuarios .="
            $agregar
            <div class='row'>
                <div class='col-lg-10 col-10'>
                    <div class='heading pb-2' style='text-align: left; padding-top: 10px'>
                        <h3 style='font-size: 20px; color: #2B2B2B'>
                          <span style='font-weight: bold;'>Servicio: $categ_nombre</span> <img src='$urlc' class='img-responsive' style='height: 40px' />
                            <a onclick='eliminarusuarioserviciocategoria(\"".$l_categservicio_id."\")' style='cursor: pointer' title='Eliminar de mis Servicios'>
                                <i class='fa fa-trash' style='font-size: 12px; color: #B90606'></i>
                            </a>
                          </h3>
                        
                    </div>               
                </div>
            </div>  
            <div class='row' style='margin-top: 0px'>
            
        ";

    }

    $subcategoriasusuarios .="
        <div class='col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6'>
            <div class='category-block'>
                <div class='headerr'>
                    <a title='$subcateg_nombre' >
                      <center>
                          <img src='$urlsc' alt='Servicio $subcateg_nombre' style='height: 50px' class='img-responsive' />
                      </center>
                      <h4 style='text-align: center; margin-top: 5px; overflow-wrap: anywhere;'>$subcateg_nombre
                        <br>
                        <a onclick='eliminarusuarioserviciosubcategoria(\"".$l_subcategservicio_id."\")' style='cursor: pointer' title='Eliminar de mis Servicios'>
                                <i class='fa fa-trash' style='font-size: 12px; color: #B90606'></i>
                            </a>
                      </h4>
                    </a>
                </div>
            </div>
        </div>
    ";

    $l_categservicio_idold = $l_categservicio_id;

    $cont = $cont + 1;

}

if ($subcategoriasusuarios !=""){
    $subcategoriasusuarios  .= "
            </div>
        ";
}

if ($subcategoriasusuarios==""){
     $subcategoriasusuarios .="
        $agregar
        <div class='row'>
            <div class='col-lg-12'>
               <div class='alert alert-success' style='text-align: center; font-weight: normal'>
                    <a style='color: #000' href='panelprestador-agregar'>
                        No posee servicios agregados, puede agregar haciendo click aquí
                    </a>
                </div>               
            </div>
        </div>  
    ";

}



$arrresultado = $conexion->doSelect("usuario.usuario_id, usuario_codigo, usuario_email, usuario_nombre, usuario_apellido,

    usuarioinfoserv_id, usuarioinfoserv_resumen, usuarioinfoserv_img, 
    usuarioinfoserv_latitud, usuarioinfoserv_longitud, usuarioinfoserv_dircompleta,     
    usuarioinfoserv_activo,  
    usuarioinfoserv_eliminado, usuarioinfoserv_fechareg,
    usuarioinfoserv_infodir, usuarioinfoserv_infocalle, usuarioinfoserv_infocodpostal,
    usuarioinfoserv_infociudad, usuarioinfoserv_infociudad2, usuarioinfoserv_infosublocalidad, 
    usuarioinfoserv_inforegion, usuarioinfoserv_infocountry, usuarioinfoservicio.l_rangokm_id,
    rangokm.lista_nombre as rangokm_nombre
    ",
    "usuario
        left join usuarioinfoservicio on usuario.usuario_id = usuarioinfoservicio.usuario_id
        left join lista rangokm on rangokm.lista_id = usuarioinfoservicio.l_rangokm_id
    ",
    "usuario_eliminado = '0' and usuario.usuario_id = '$_COOKIE[iniuser]' ");
foreach($arrresultado as $i=>$valor){

    $usuarioinfoserv_infodir = utf8_encode($valor["usuarioinfoserv_infodir"]);
    $usuarioinfoserv_infocalle = utf8_encode($valor["usuarioinfoserv_infocalle"]);
    $usuarioinfoserv_infocodpostal = utf8_encode($valor["usuarioinfoserv_infocodpostal"]);
    $usuarioinfoserv_infociudad = utf8_encode($valor["usuarioinfoserv_infociudad"]);
    $usuarioinfoserv_infociudad2 = utf8_encode($valor["usuarioinfoserv_infociudad2"]);
    $usuarioinfoserv_infosublocalidad = utf8_encode($valor["usuarioinfoserv_infosublocalidad"]);
    $usuarioinfoserv_inforegion = utf8_encode($valor["usuarioinfoserv_inforegion"]);
    $usuarioinfoserv_infocountry = utf8_encode($valor["usuarioinfoserv_infocountry"]);  

    $rangokm_nombre = utf8_encode($valor["rangokm_nombre"]);
    $usuario_id = utf8_encode($valor["usuario_id"]);
    $usuario_codigo = utf8_encode($valor["usuario_codigo"]);
    $usuario_email = utf8_encode($valor["usuario_email"]);  
    $usuario_nombre = utf8_encode($valor["usuario_nombre"]);
    $usuario_apellido = utf8_encode($valor["usuario_apellido"]);
    
    $usuarioinfoserv_id = utf8_encode($valor["usuarioinfoserv_id"]);
    $usuarioinfoserv_resumen = utf8_encode($valor["usuarioinfoserv_resumen"]);
    $usuarioinfoserv_img = utf8_encode($valor["usuarioinfoserv_img"]);
    $usuarioinfoserv_latitud = utf8_encode($valor["usuarioinfoserv_latitud"]);
    $usuarioinfoserv_longitud = utf8_encode($valor["usuarioinfoserv_longitud"]);
    $usuarioinfoserv_dircompleta = utf8_encode($valor["usuarioinfoserv_dircompleta"]);
    
    $usuarioinfoserv_activo = utf8_encode($valor["usuarioinfoserv_activo"]);
    $usuarioinfoserv_eliminado = utf8_encode($valor["usuarioinfoserv_eliminado"]);
    $usuarioinfoserv_fechareg = utf8_encode($valor["usuarioinfoserv_fechareg"]);

    $l_rangokm_id = utf8_encode($valor["l_rangokm_id"]);

    

}



$displaynonegooglemapssss = " style = 'display: none'";

if($usuarioinfoserv_latitud !=""){
  $displaynonegooglemaps="";
}

if ($usuarioinfoserv_latitud==""){$usuarioinfoserv_latitud= 0;}
if ($usuarioinfoserv_longitud==""){$usuarioinfoserv_longitud= 0;}
if ($rangokm_nombre==""){$rangokm_nombre=1;}



if ($usuario_id==""){
  echo "<script language='JavaScript'>window.location = 'iniciar-sesion'; </script>";
  exit();
}

$optiontipoperfilservicio = ObtenerLista('41', $SistemaCuentaId, $SistemaCompaniaId, $l_tipousuarioserv_id); 

$optionrangokm = ObtenerLista('44', $SistemaCuentaId, $SistemaCompaniaId, $l_rangokm_id); 


$optioncategoria = ObtenerLista('39', $SistemaCuentaId, $SistemaCompaniaId);

if ($getcategoria!=""){
    $optionsubcategoria = ObtenerListaUsuarioServicio('40', $cuentaseleccionada, $companiaseleccionada, null, null, null, $getcategoria);   
}


$zoomcolocar = 12;


if ($rangokm_nombre=="1"){$zoomcolocar = 14;}
if ($rangokm_nombre=="2"){$zoomcolocar = 13;}
if ($rangokm_nombre=="3"){$zoomcolocar = 13;}
if ($rangokm_nombre=="4"){$zoomcolocar = 12;}
if ($rangokm_nombre=="5"){$zoomcolocar = 12;}
if ($rangokm_nombre=="6"){$zoomcolocar = 12;}
if ($rangokm_nombre=="7"){$zoomcolocar = 12;}
if ($rangokm_nombre=="8"){$zoomcolocar = 12;}
if ($rangokm_nombre=="9"){$zoomcolocar = 11;}
if ($rangokm_nombre=="10"){$zoomcolocar = 11;}
if ($rangokm_nombre>"10" && $rangokm_nombre<="15"){$zoomcolocar = 11;}
if ($rangokm_nombre>"15" && $rangokm_nombre<="20"){$zoomcolocar = 10;}
if ($rangokm_nombre>"20" && $rangokm_nombre<="30"){$zoomcolocar = 10;}
if ($rangokm_nombre>"30" && $rangokm_nombre<="40"){$zoomcolocar = 9;}
if ($rangokm_nombre>="50"){$zoomcolocar = 9;}



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
<body class="body-wrapper"  onload="initialize()">

        <style>    
      #map {
        height: 400px;
      }
    </style>


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
                    <!-- Edit Profile Welcome Text -->
                    <div class="widget welcome-message" style="padding-bottom: 10px">
                        <h2><i class="fa fa-briefcase"></i> Servicios Ofrecidos</h2>
                        <p>Se muestra el listado de los servicios que está ofreciendo en el portal</p>
                    </div>
                    <!-- Edit Personal Info -->
                    <div class="row">
                        <div class="col-md-12" style="text-align: right;">
                            <a onclick="mostrardiv('divagregar')">
                                <input type="button" name="button" value="+ Agregar Servicio" class="btn btn-primary">
                            </a> 
                            <a href="panelprestador-servicios#div_info">
                                <button class="btn btn-success">
                                    <i class="fa fa-map-marker"></i> Ubicación del Servicio
                                </button>
                            </a>
                        </div>
                    </div>
                    <div id="divagregar" style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="javascript:agregarserviciousuario()">                 
                                    <div class="row">                                        
                                        <div class="col-md-3 col-3" style="margin-top: 15px; padding-top: 10px; text-align: right;">
                                            <label>Servicio: <span style="color: red">*</span> </label>
                                        </div>
                                        <div class="col-md-6 col-9" style="margin-top: 15px">                                           
                                            <select class="form-control" id="categoria" name="categoria" required="required" style="width: 100%" onchange="cargarsubcategoriaservicio()">
                                              <?php echo $optioncategoria;?>
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="row">                                        
                                        <div class="col-md-3 col-3" style="margin-top: 15px; padding-top: 10px; text-align: right;">
                                            <label>Sub-Servicio: <span style="color: red">*</span> </label>
                                        </div>
                                        <div class="col-md-6 col-9" style="margin-top: 15px">                                           
                                            <select class="form-control" id="subcategoria" name="subcategoria" required="required" style="width: 100%">
                                            <option value="">-- Seleccione Primero el Servicio --</option>                                              
                                            </select>
                                        </div>
                                    </div>                                      
                                    <div class="col-md-12" style="margin-top: 15px">
                                        <center>
                                            <input type="submit" name="submit" value="Guardar" class="btn btn-primary">
                                        </center>
                                    </div>                                    
                                </form>      
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="widget personal-info">
                                <?php echo $subcategoriasusuarios;?>
                            </div>
                        </div>                                          
                    </div>
                    <div class="row" id="div_info">
                        <div class="col-lg-12">
                            <div class="widget personal-info">
                                
                                <form method="post" action="uploadperfilprestadorservicio" target="iframeupload" enctype="multipart/form-data">                                                
                                    <div class="row" style="margin-top: 15px">
                                        <div class="col-md-12" style="margin-top: 15px">
                                            <h4>Info del Servicio:</h4>                                            
                                        </div>
                                                       
                                      <div class="form-group col-md-8">
                                        <label for="usuario_documento">Donde se encuentra: <span style="color: red">*</span> <span style="font-weight: normal;" id="spaninfoubicacion"></span> </label>
                                        <input type="text" id="txtPlaces" name="usuarioinfoserv_infodir" class="form-control" required="required" placeholder="Ubique su direccion" required="required" value="<?php echo $usuarioinfoserv_infodir;?>">     

                                          <input type="hidden" id="infolatitud" name="infolatitud" value="<?php echo $usuarioinfoserv_latitud;?>">
                                          <input type="hidden" id="infolongitud" name="infolongitud" value="<?php echo $usuarioinfoserv_longitud;?>">    
                                          <input type="hidden" id="infocountry" name="infocountry" value="<?php echo $usuarioinfoserv_infocountry;?>">
                                          <input type="hidden" id="infodir" name="infodir" value="<?php echo $usuarioinfoserv_infodir;?>"> 
                                          <input type="hidden" id="infocalle" name="infocalle" value="<?php echo $usuarioinfoserv_infocalle;?>">
                                          <input type="hidden" id="infocodpostal" name="infocodpostal" value="<?php echo $usuarioinfoserv_infocodpostal;?>"> 
                                          <input type="hidden" id="infosublocalidad" name="infosublocalidad" value="<?php echo $usuarioinfoserv_infosublocalidad;?>"> 
                                          <input type="hidden" id="inforegion" name="inforegion" value="<?php echo $usuarioinfoserv_inforegion;?>">  
                                          <input type="hidden" id="infociudad" name="infociudad" value="<?php echo $usuarioinfoserv_infociudad;?>">  
                                          <input type="hidden" id="infociudad2" name="infociudad2" value="<?php echo $usuarioinfoserv_infociudad2;?>">                          
                                      </div>      
                                      <div class="form-group col-md-4">
                                          <label for="usuarioinfoserv_resumen">Rango Km del Servicio: <span style="color: red">*</span></label>
                                          <select class="form-control" id="rangokm" name="rangokm" required="required" style="width: 100%" >
                                              <?php echo $optionrangokm;?>
                                            </select>
                                      </div> 
                                       <div class="form-group col-md-12">
                                          <label for="usuarioinfoserv_resumen">Resumen del Servicio: <span style="color: red">*</span></label>
                                          <textarea class="form-control" id="usuarioinfoserv_resumen" name="usuarioinfoserv_resumen" required="required" placeholder="Resumen del Servicio" style="width:100%;"><?php echo $usuarioinfoserv_resumen;?></textarea>
                                      </div>                
                                    
                                      <div class="form-group col-md-12" <?php echo $displaynonegooglemaps;?> >
                                          <label class="control-label">Ver Dirección en Google Maps: <span style="color: red"></span></label>
                                          <div id="map"></div>
                                      </div>  
                                        
                                    </div>
                                    <div class="row" style="margin-top: 15px">
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

     <script async defer  type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPhrxAS4PTETtyWsUE3blCecc7hGacoms&libraries=places&callback=initMap"></script>


     <script type="text/javascript">

      var geocoder;

      function initialize() {
        geocoder = new google.maps.Geocoder();
      }
      

      function codeLatLng(lat, lng) {          

          //console.log(lat);

          //console.log(lng);

          var latlng = new google.maps.LatLng(lat, lng);

          geocoder.geocode({latLng: latlng}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              if (results[1]) {
                var arrAddress = results;



                //var address_component = arrAddress[0];

                console.log(arrAddress[0]);

                var address_components = arrAddress[0].address_components;

                var direccion = arrAddress[0].formatted_address;
                var place_id = arrAddress[0].place_id;

                //console.log(place_id);

                document.getElementById("txtPlaces").value = direccion;
                document.getElementById("infolatitud").value = lat;
                document.getElementById("infolongitud").value = lng;
                document.getElementById("spaninfoubicacion").innerHTML = " (Asignada por Ubicación Actual)";


                var components={}; 
                jQuery.each(address_components, function(k,v1) {jQuery.each(v1.types, function(k2, v2){components[v2]=v1.long_name});})

                //console.log(components);
                    
                var country = components.country;
                var calle = components.route;
                var codpostal = components.postal_code;
                var sublocalidad = components.sublocality;
                var ciudad = components.administrative_area_level_1;
                var ciudad2 = components.administrative_area_level_2;

                document.getElementById("infocountry").value = country;
                document.getElementById("infodir").value = direccion;
                document.getElementById("infocalle").value = calle;
                document.getElementById("infociudad").value = ciudad;
                document.getElementById("infociudad2").value = ciudad2;
                document.getElementById("infocodpostal").value = codpostal;
                document.getElementById("infosublocalidad").value = sublocalidad;



              } else {
                alert("No results found");
              }
            } else {
              alert("Geocoder failed due to: " + status);
            }
          });
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
      infoWindow.setPosition(pos);
      infoWindow.setContent(browserHasGeolocation ?
                            'Error: The Geolocation service failed.' :
                            'Error: Your browser doesn\'t support geolocation.');
      infoWindow.open(map);
    }

      function initMap() {

        var latitudactual = <?php echo $usuarioinfoserv_latitud;?>;
    

          var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: <?php echo $usuarioinfoserv_latitud;?>, lng: <?php echo $usuarioinfoserv_longitud;?>},
              zoom: <?php echo $zoomcolocar;?>
          });
          var infoWindow = new google.maps.InfoWindow;
          var input = document.getElementById('txtPlaces');
          //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

          var autocomplete = new google.maps.places.Autocomplete(input);
          autocomplete.bindTo('bounds', map);

          var infowindow = new google.maps.InfoWindow();
          var marker = new google.maps.Marker({
              map: map,
              anchorPoint: new google.maps.Point(0, -29)
          });

          if (<?php echo $usuarioinfoserv_latitud;?>!="0"){
                var citymap = {
                    punto: {
                      center: {lat: <?php echo $usuarioinfoserv_latitud;?>, lng: <?php echo $usuarioinfoserv_longitud;?>},
                      population: 2714856
                    }
                  };                

                var rangokm = <?php echo $rangokm_nombre;?>;

                for (var city in citymap) {
                  // Add the circle for this city to the map.
                  var cityCircle = new google.maps.Circle({
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    map: map,
                    center: citymap[city].center,
                    radius: rangokm * 1000
                  });
                }
            }


        if (latitudactual=="0" || latitudactual==""){            
            //alert(latitudactual);
              // Try HTML5 geolocation.
              if (navigator.geolocation) {        
                navigator.geolocation.getCurrentPosition(function(position) {
                  var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                  };

                  codeLatLng(position.coords.latitude, position.coords.longitude);


                  //console.log(position);

                  infoWindow.setPosition(pos);
                  infoWindow.setContent('Ubicación Actual.');
                  infoWindow.open(map);
                  map.setCenter(pos);
                }, function() {
                  handleLocationError(true, infoWindow, map.getCenter());
                });
              } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
              }
          }




          autocomplete.addListener('place_changed', function() {
              infowindow.close();
              marker.setVisible(false);
              var place = autocomplete.getPlace();
              if (!place.geometry) {
                  window.alert("Autocomplete's returned place contains no geometry");
                  return;
              }
        
              // If the place has a geometry, then present it on a map.
              if (place.geometry.viewport) {
                  map.fitBounds(place.geometry.viewport);                    
                  map.setZoom(12);
              } else {
                  map.setCenter(place.geometry.location);
                  map.setZoom(12);
              }
            
              marker.setPosition(place.geometry.location);
              marker.setVisible(true);
          
              var address = '';
              if (place.address_components) {                   
                  var address_components = place.address_components;   

                  var components={}; 
                  jQuery.each(address_components, function(k,v1) {jQuery.each(v1.types, function(k2, v2){components[v2]=v1.long_name});})

                  var latitude = place.geometry.location.lat();
                  var longitude = place.geometry.location.lng();
                  var direccion = place.formatted_address;
                  var country = components.country;
                  var calle = components.route;
                  var codpostal = components.postal_code;
                  var sublocalidad = components.sublocality;
                  var ciudad = components.administrative_area_level_1;
                  var ciudad2 = components.administrative_area_level_2;

                  document.getElementById("infolatitud").value = latitude;
                  document.getElementById("infolongitud").value = longitude;
                  document.getElementById("infocountry").value = country;
                  document.getElementById("infodir").value = direccion;
                  document.getElementById("infocalle").value = calle;
                  document.getElementById("infociudad").value = ciudad;
                  document.getElementById("infociudad2").value = ciudad2;
                  document.getElementById("infocodpostal").value = codpostal;
                  document.getElementById("infosublocalidad").value = sublocalidad;

                  document.getElementById("spaninfoubicacion").innerHTML = " ";
              }

          })

          
      }    
    </script>

    
    <script>    

        /*
     

      function initMap() {
          

            var map = new google.maps.Map(document.getElementById('map'), {
              center: {lat: <?php echo $usuarioinfoserv_latitud;?>, lng: <?php echo $usuarioinfoserv_longitud;?>},
              zoom: 12
            });
            var input = document.getElementById('txtPlaces');
            //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            if (<?php echo $usuarioinfoserv_latitud;?>!="0"){
                var citymap = {
                    punto: {
                      center: {lat: <?php echo $usuarioinfoserv_latitud;?>, lng: <?php echo $usuarioinfoserv_longitud;?>},
                      population: 2714856
                    }
                  };                

                var rangokm = <?php echo $rangokm_nombre;?>;

                for (var city in citymap) {
                  // Add the circle for this city to the map.
                  var cityCircle = new google.maps.Circle({
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    map: map,
                    center: citymap[city].center,
                    radius: rangokm * 1000
                  });
                }
            }

            autocomplete.addListener('place_changed', function() {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
          
                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);                    
                    map.setZoom(12);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(12);
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
            
                var address = '';
                if (place.address_components) {                   
                    var address_components = place.address_components;   

                    var components={}; 
                    jQuery.each(address_components, function(k,v1) {jQuery.each(v1.types, function(k2, v2){components[v2]=v1.long_name});})

                    var latitude = place.geometry.location.lat();
                    var longitude = place.geometry.location.lng();
                    var direccion = place.formatted_address;
                    var country = components.country;
                    var calle = components.route;
                    var codpostal = components.postal_code;
                    var sublocalidad = components.sublocality;
                    var ciudad = components.administrative_area_level_1;
                    var ciudad2 = components.administrative_area_level_2;

                    document.getElementById("infolatitud").value = latitude;
                    document.getElementById("infolongitud").value = longitude;
                    document.getElementById("infocountry").value = country;
                    document.getElementById("infodir").value = direccion;
                    document.getElementById("infocalle").value = calle;
                    document.getElementById("infociudad").value = ciudad;
                    document.getElementById("infociudad2").value = ciudad2;
                    document.getElementById("infocodpostal").value = codpostal;
                    document.getElementById("infosublocalidad").value = sublocalidad;
                }

                var citymap = {
                    punto: {
                      center: {lat: latitude, lng: longitude },
                      population: 2714856
                    }
                  };                

                var rangokm = document.getElementById("rangokm");
                var text= rangokm.options[rangokm.selectedIndex].text;

                if (text==""){text=10;}

                for (var city in citymap) {
                  // Add the circle for this city to the map.
                  var cityCircle = new google.maps.Circle({
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    map: map,
                    center: citymap[city].center,
                    radius: text * 1000
                  });
                }

            });
        }
        */
    </script>
    
</body>
</html>

