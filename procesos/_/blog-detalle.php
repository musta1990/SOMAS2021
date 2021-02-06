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

$where = " and blog.cuenta_id = '$SistemaCuentaId' and blog.compania_id = '$SistemaCompaniaId' ";

$base = base();

(isset($_GET['id'])) ? $getblog_id=$_GET['id'] :$getblog_id='';

$whereperfil = " and blog.cuenta_id = ''";

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

}


$arrresultado = $conexion->doSelect("
        distinct blog.blog_id, blog_nombre, blog_descrip,
        DATE_FORMAT(blog_fechareg,'%d/%m/%Y %H:%i:%s') as blog_fecha, blog_url,
        blog_activo, blog_eliminado, blog_img, blog_orden, l_categblog_id, blog_videocodigo
        ","blog            
        ","blog_activo = '1' and blog.blog_id = '$getblog_id' $where ");

$cont = 0;
foreach($arrresultado as $i=>$valor){

    $blog_id = utf8_encode($valor["blog_id"]);
    $blog_nombre = utf8_encode($valor["blog_nombre"]);
    $blog_descrip = utf8_encode($valor["blog_descrip"]);
    $blog_fecha = utf8_encode($valor["blog_fecha"]);
    $blog_activo = utf8_encode($valor["blog_activo"]);
    $blog_img = utf8_encode($valor["blog_img"]);
    $blog_orden = utf8_encode($valor["blog_orden"]);
    $blog_categ_nombre = utf8_encode($valor["categ_nombre"]);
    $blog_url = utf8_encode($valor["blog_url"]);
    $categ_idrel = utf8_encode($valor["l_categblog_id"]);
    $blog_videocodigo = utf8_encode($valor["blog_videocodigo"]);

    if ($blog_videocodigo!=""){
        $videoiframe = "
            <iframe allowfullscreen='' frameborder='0' width='100%' height='420px' src='https://www.youtube.com/embed/$blog_videocodigo'></iframe>
        ";
    }


    $urlblogimg = $UrlFiles."admin/arch/$blog_img";        
}



$arrresultado = $conexion->doSelect("
        distinct blog.blog_id, blog_nombre, blog_descrip,
        DATE_FORMAT(blog_fechareg,'%d/%m/%Y %H:%i:%s') as blog_fecha, blog_url,
        blog_activo, blog_eliminado, blog_img, blog_orden,
        blog.l_categblog_id, blogcategoria.lista_nombre as categ_nombre
        ","blog
            left join lista blogcategoria on blogcategoria.lista_id = blog.l_categblog_id            
        ","blog_activo = '1' and blog.l_categblog_id = '$categ_idrel' and blog.blog_id <> '$blog_id'  $where "); //


foreach($arrresultado as $i=>$valor){

    $rel_blog_id = utf8_encode($valor["blog_id"]);
    $rel_blog_nombre = utf8_encode($valor["blog_nombre"]);
    $rel_blog_descrip = utf8_encode($valor["blog_descrip"]);
    $rel_blog_fecha = utf8_encode($valor["blog_fecha"]);
    $rel_blog_activo = utf8_encode($valor["blog_activo"]);
    $rel_blog_img = utf8_encode($valor["blog_img"]);
    $rel_blog_orden = utf8_encode($valor["blog_orden"]);
    $rel_blog_categ_nombre = utf8_encode($valor["categ_nombre"]);
    $rel_blog_url = utf8_encode($valor["blog_url"]);

    $urlblog = "art/$rel_blog_id/$rel_blog_url/";    

    $enlacesrelcategoria .="
            <div style='padding-bottom: 10px'>
                <a href='$urlblog' style='color: #0E156E'> <i class='fa fa-newspaper-o'></i> $rel_blog_nombre</a>
                <br>
            </div>
    ";
}

$displayotrosarticulos = "; display: none";
if ($enlacesrelcategoria!=""){
    $displayotrosarticulos = "";
}


$arrresultado = $conexion->doSelect("
    min(blog_id) as blog_idmin
  ","blog
  ","blog_activo = '1' and blog_id > '$get_id'  $where  ");

$cont = 0;
foreach($arrresultado as $i=>$valor){
  $blog_idsiguiente = utf8_encode($valor["blog_idmin"]);
}



if ($blog_idsiguiente==""){

  $arrresultado = $conexion->doSelect("
      min(blog_id) as blog_idmin
    ","blog
    ","blog_activo = '1'  $where ");

  $cont = 0;
  foreach($arrresultado as $i=>$valor){
    $blog_idsiguiente = utf8_encode($valor["blog_idmin"]);
  }
}


$arrresultado = $conexion->doSelect("
    max(blog_id) as blog_idmax
  ","blog
  ","blog_activo = '1' and blog_id < '$get_id' $where  ");

$cont = 0;
foreach($arrresultado as $i=>$valor){
  $blog_idanterior= utf8_encode($valor["blog_idmax"]);
}

if ($blog_idanterior==""){
  $arrresultado = $conexion->doSelect("
      max(blog_id) as blog_idmax
    ","blog
    ","blog_activo = '1'");

  $cont = 0;
  foreach($arrresultado as $i=>$valor){
    $blog_idanterior = utf8_encode($valor["blog_idmax"]);
  }
}



$urlblog = "art/$blog_id/$blog_url/";

$urlblog = "$compania_urlweb$urlblog";

$urlimg = "$compania_urlweb/arch/$blog_img";

$blog_descripcorto = strip_tags(substr($blog_descrip, 0,120));




$arrresultado = $conexion->doSelect("
    blog_id, blog_nombre, blog_descrip,
    DATE_FORMAT(blog_fechareg,'%d/%m/%Y %H:%i:%s') as blog_fecha,
    blog_activo, blog_eliminado, blog_img, blog_orden, blog_url
      ","blog
      ","blog_activo = '1' and blog_id = '$blog_idsiguiente'  $where ");

foreach($arrresultado as $i=>$valor){

    $siguiente_blog_id = utf8_encode($valor["blog_id"]);
    $siguiente_blog_nombre = utf8_encode($valor["blog_nombre"]);
    $siguiente_blog_descrip = utf8_encode($valor["blog_descrip"]);
    $siguiente_blog_fecha = utf8_encode($valor["blog_fecha"]);
    $siguiente_blog_activo = utf8_encode($valor["blog_activo"]);
    $siguiente_blog_img = utf8_encode($valor["blog_img"]);
    $siguiente_blog_orden = utf8_encode($valor["blog_orden"]);
    $siguiente_blog_url = utf8_encode($valor["blog_url"]);
}



$arrresultado = $conexion->doSelect("
    blog_id, blog_nombre, blog_descrip,
    DATE_FORMAT(blog_fechareg,'%d/%m/%Y %H:%i:%s') as blog_fecha,
    blog_activo, blog_eliminado, blog_img, blog_orden, blog_url
      ","blog
      ","blog_activo = '1' and blog_id = '$blog_idanterior'  $where  ");

foreach($arrresultado as $i=>$valor){

    $anterior_blog_id = utf8_encode($valor["blog_id"]);
    $anterior_blog_nombre = utf8_encode($valor["blog_nombre"]);
    $anterior_blog_descrip = utf8_encode($valor["blog_descrip"]);
    $anterior_blog_fecha = utf8_encode($valor["blog_fecha"]);
    $anterior_blog_activo = utf8_encode($valor["blog_activo"]);
    $anterior_blog_img = utf8_encode($valor["blog_img"]);
    $anterior_blog_orden = utf8_encode($valor["blog_orden"]);
    $anterior_blog_url = utf8_encode($valor["blog_url"]);
}

$urlbloganterior = "blog/$anterior_blog_id/$anterior_blog_url/";

$bloganterior = "
    <div class='row'>
        <div class='col-md-1 col-xs-2' style='padding-top: 20px'>
            <a href='$urlbloganterior'>
                <i class='fa fa-arrow-circle-left' style='font-size: 20px'></i>
            </a>
        </div>
        <div class='col-md-5 col-xs-10' style='padding-right: 0px; margin-bottom: 10px'>
            <a href='$urlbloganterior'>
                <img src='arch/$anterior_blog_img' class='img-responsive' alt='$anterior_blog_nombre - $compania_nombre' style='height: 80px;'>
            </a>
        </div>
        <div class='col-md-6' style='margin-top: 10px'>
            <a href='$urlbloganterior'>
                <h5>Artículo anterior</h5>
                <h5 style='height: 48px; overflow: hidden; text-align: justify;'>
                    $anterior_blog_nombre
                </h5>
            </a>
        </div>
    </div>
";

$urlblogsiguiente = "blog/$siguiente_blog_id/$siguiente_blog_url/";

$blogsiguiente = "
    <div class='row'>
        <div class='col-md-6'>
            <a href='$urlblogsiguiente'>
                <h5 style='text-align: right;'>Artículo siguiente</h5>
                <h5 style='height: 48px; overflow: hidden; text-align: right;'>
                    $siguiente_blog_nombre
                </h5>
            </a>
        </div>
        <div class='col-md-5 col-xs-10' style='padding-right: 0px'>
            <a href='$urlblogsiguiente'>
                <img src='arch/$siguiente_blog_img' class='img-responsive' alt='$siguiente_blog_nombre - $compania_nombre' style='height: 80px; width: 200px'>
            </a>
        </div>
        <div class='col-md-1 col-xs-2' style='padding-top: 20px'>
            <a href='$urlblogsiguiente'>
                <i class='fa fa-arrow-circle-right' style='font-size: 20px'></i>
            </a>
        </div>
    </div>
";



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php echo $base; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">        

    <title><?php echo $blog_nombre; ?> - <?php echo $compania_nombre;?></title>
    <meta name="title" content="<?php echo $blog_nombre; ?> - <?php echo $compania_nombre;?>">
    <meta name="keywords" content="Blog - <?php echo $compania_nombre;?>">
    <meta name="description" content="<?php echo $blog_descripcorto; ?> - <?php echo $compania_nombre;?>">

    <meta property="og:image" content="<?php echo $urlblogimg; ?>">
    <meta property="og:title" content="<?php echo $blog_nombre; ?> - <?php echo $compania_nombre;?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $urlblog; ?>" />
    <meta property="og:description" content="<?php echo $blog_descripcorto; ?> - <?php echo $compania_nombre;?>">
    <meta property="og:site_name" content="<?php echo $compania_nombre;?>" />
    <meta name="robots" content="index, follow">
    

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@<?php echo $compania_nombre;?>" />
    <meta name="twitter:title" content="<?php echo $blog_nombre; ?> - <?php echo $compania_nombre;?>" />
    <meta name="twitter:description" content="<?php echo $blog_descripcorto; ?> - <?php echo $compania_nombre;?>" />
    <meta name="twitter:image" content="<?php echo $urlblogimg; ?>" />

    <!-- FAVICON -->
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

    <link rel="stylesheet" href="lib/rrssb-master/rrssb-master/css/rrssb.css" />

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

    <section class="blog single-blog section sectiontext">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-10 offset-lg-0">
                    <article class="single-post" style="padding: 10px 20px">
                        <h2><?php echo $blog_nombre;?></h2> 
                        <div style="margin-top: 10px">
                        
                            <img src="<?php echo $urlblogimg;?>" alt="<?php echo $blog_nombre;?> - <?php echo $compania_nombre;?>"  title="<?php echo $blog_nombre;?> - <?php echo $compania_nombre;?>" style="max-height: 300px; max-width: 100%; width: auto; border-radius: 10px; box-shadow: 2px 2px #777777" class="img-responsive" >
                        </div>
                        <div style="text-align: justify">
                            <?php echo $blog_descrip?>

                            <div>
                                <?php echo $videoiframe;?>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="https://api.whatsapp.com/send?phone=<?php echo $compania_whatsapp;?>">
                                        <img src="images/whatsapp.png" style="height:30px; width: 30px; margin-bottom: 0px" alt="Escribenos al WhatsApp - <?php echo $compania_nombre;?>"  title="Escribenos al WhatsApp - <?php echo $compania_nombre;?>" />
                                        <strong>WhatsApp:</strong> +<?php echo $compania_whatsapp;?>
                                    </a>
                                </div>   

                                <div class="col-md-12">
                                    <br>
                                    <a href="mailto:<?php echo $compania_email;?>">
                                        <img src="images/email2.png" style="height:30px; width: 30px; margin-bottom: 0px " alt="Escribenos al Email - <?php echo $compania_nombre;?>"  title="Escribenos al Email - <?php echo $compania_nombre;?>" />
                                        <strong>Email:</strong> <?php echo $compania_email;?>
                                    </a>
                                </div>                                
                            </div>
                            
                            <div style="margin-top: 15px; <?php echo $displayotrosarticulos?>">
                                <h4>Otros artículos que pueden interesarte: </h4>

                                <?php echo $enlacesrelcategoria;?>
                            </div>


                            
                        </div>
                        <div style="margin-top: 20px">
                        <ul class="rrssb-buttons" style="margin: 0px 0px; ">
                            <li class="rrssb-facebook">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $urlblog; ?>" class="popup">
                                    <span class="rrssb-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z" /></svg>
                                    </span>
                                    <span class="rrssb-text">facebook</span>
                                </a>
                            </li>
                            <li class="rrssb-twitter">                                
                                <a href="https://twitter.com/intent/tweet?text=Observa este articulo en <?php echo $urlblog; ?>"
                                    class="popup">
                                    <span class="rrssb-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z" /></svg>
                                    </span>
                                    <span class="rrssb-text">twitter</span>
                                </a>
                            </li>
                            <li class="rrssb-email">                                
                                <a href="mailto:?subject=Observa este articulo en <?php echo $urlblog; ?>">
                                    <span class="rrssb-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"><path d="M20.11 26.147c-2.335 1.05-4.36 1.4-7.124 1.4C6.524 27.548.84 22.916.84 15.284.84 7.343 6.602.45 15.4.45c6.854 0 11.8 4.7 11.8 11.252 0 5.684-3.193 9.265-7.398 9.3-1.83 0-3.153-.934-3.347-2.997h-.077c-1.208 1.986-2.96 2.997-5.023 2.997-2.532 0-4.36-1.868-4.36-5.062 0-4.75 3.503-9.07 9.11-9.07 1.713 0 3.7.4 4.6.972l-1.17 7.203c-.387 2.298-.115 3.3 1 3.4 1.674 0 3.774-2.102 3.774-6.58 0-5.06-3.27-8.994-9.304-8.994C9.05 2.87 3.83 7.545 3.83 14.97c0 6.5 4.2 10.2 10 10.202 1.987 0 4.09-.43 5.647-1.245l.634 2.22zM16.647 10.1c-.31-.078-.7-.155-1.207-.155-2.572 0-4.596 2.53-4.596 5.53 0 1.5.7 2.4 1.9 2.4 1.44 0 2.96-1.83 3.31-4.088l.592-3.72z" /></svg>
                                    </span>
                                    <span class="rrssb-text">email</span>
                                </a>
                            </li>
                            <li class="rrssb-whatsapp">
                                <a href="whatsapp://send?text=Observa este articulo en <?php echo $urlblog; ?>" data-action="share/whatsapp/share">
                                    <span class="rrssb-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 90 90"><path d="M90 43.84c0 24.214-19.78 43.842-44.182 43.842a44.256 44.256 0 0 1-21.357-5.455L0 90l7.975-23.522a43.38 43.38 0 0 1-6.34-22.637C1.635 19.63 21.415 0 45.818 0 70.223 0 90 19.628 90 43.84zM45.818 6.983c-20.484 0-37.146 16.535-37.146 36.86 0 8.064 2.63 15.533 7.076 21.61l-4.64 13.688 14.274-4.537A37.122 37.122 0 0 0 45.82 80.7c20.48 0 37.145-16.533 37.145-36.857S66.3 6.983 45.818 6.983zm22.31 46.956c-.272-.447-.993-.717-2.075-1.254-1.084-.537-6.41-3.138-7.4-3.495-.993-.36-1.717-.54-2.438.536-.72 1.076-2.797 3.495-3.43 4.212-.632.72-1.263.81-2.347.27-1.082-.536-4.57-1.672-8.708-5.332-3.22-2.848-5.393-6.364-6.025-7.44-.63-1.076-.066-1.657.475-2.192.488-.482 1.084-1.255 1.625-1.882.543-.628.723-1.075 1.082-1.793.363-.718.182-1.345-.09-1.884-.27-.537-2.438-5.825-3.34-7.977-.902-2.15-1.803-1.793-2.436-1.793-.63 0-1.353-.09-2.075-.09-.722 0-1.896.27-2.89 1.344-.99 1.077-3.788 3.677-3.788 8.964 0 5.288 3.88 10.397 4.422 11.113.54.716 7.49 11.92 18.5 16.223 11.01 4.3 11.01 2.866 12.996 2.686 1.984-.18 6.406-2.6 7.312-5.107.9-2.513.9-4.664.63-5.112z" /></svg>
                                    </span>
                                    <span class="rrssb-text">Whatsapp</span>
                                </a>
                            </li>
                            <li class="rrssb-linkedin">                                
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $urlblog; ?>&amp;title=Observa este articulo en <?php echo $urlblog; ?>" class="popup">
                                    <span class="rrssb-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M25.424 15.887v8.447h-4.896v-7.882c0-1.98-.71-3.33-2.48-3.33-1.354 0-2.158.91-2.514 1.802-.13.315-.162.753-.162 1.194v8.216h-4.9s.067-13.35 0-14.73h4.9v2.087c-.01.017-.023.033-.033.05h.032v-.05c.65-1.002 1.812-2.435 4.414-2.435 3.222 0 5.638 2.106 5.638 6.632zM5.348 2.5c-1.676 0-2.772 1.093-2.772 2.54 0 1.42 1.066 2.538 2.717 2.546h.032c1.71 0 2.77-1.132 2.77-2.546C8.056 3.593 7.02 2.5 5.344 2.5h.005zm-2.48 21.834h4.896V9.604H2.867v14.73z" /></svg>
                                    </span>
                                    <span class="rrssb-text">linkedin</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    </article>
                    <div class="block comment">
                        <!-- <h4>Escribenos tu Comentario</h4>

                        AQUI COLOCAR PLUGIN DE FACEBOOK PARA COMENTAR     -->                  
                    </div>
                </div>
                <div class="col-md-10 offset-md-1 col-lg-3 offset-lg-0">
                    <div class="sidebar">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>


    <hr>
    

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

    <script src="lib/rrssb-master/rrssb-master/js/rrssb.min.js"></script>

</body>
</html>

