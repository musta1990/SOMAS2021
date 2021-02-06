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

(isset($_GET['cid'])) ? $getcateg=$_GET['cid'] :$getcateg='';
(isset($_GET['q'])) ? $getbuscar=$_GET['q'] :$getbuscar='';
(isset($_GET['art'])) ? $getblog_id=$_GET['art'] :$getblog_id='';

if ($getcateg!=""){
    $wherecateg = " and blog.l_categblog_id = '$getcateg'";
}


if ($getblog_id!=""){
    $whereblog = " and blog.blog_id = '$getblog_id'";
}


if ($getbuscar!=""){
    $wherebuscar = " and (blog_nombre like '%$getbuscar%' or blog_descrip like '%$getbuscar%' or blogcategoria.lista_nombre like '%$getbuscar%' ) ";
    $busquedabuscar = " con la búsqueda: <strong>$getbuscar</strong>";
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

    $titulopagina = "Consejos - ".$compania_nombre;
    $descripcionpagina = "Consejos - $compania_nombre";

}

if ($getblog_id!=""){

    $arrresultado = $conexion->doSelect("
            distinct blog.blog_id, blog_nombre, blog_descrip,
            DATE_FORMAT(blog_fechareg,'%d/%m/%Y %H:%i:%s') as blog_fecha, blog_url,
            blog_activo, blog_eliminado, blog_img, blog_orden
            ","blog

            ","blog_activo = '1' and blog_id = '$getblog_id' $where ", null, "blog_orden desc");

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

        //$urlblog = "art/$blog_id/$blog_url/"; 

        //echo "<script language='JavaScript'>window.location = '$urlblog'; </script>";
        
    }

}

$arrresultado = $conexion->doSelect("
        distinct blog.blog_id, blog_nombre, blog_descrip,
        DATE_FORMAT(blog_fechareg,'%d/%m/%Y %H:%i:%s') as blog_fecha, blog_url,
        blog_activo, blog_eliminado, blog_img, blog_orden,
        blog.l_categblog_id, blogcategoria.lista_nombre as categ_nombre
        ","blog
            left join lista blogcategoria on blogcategoria.lista_id = blog.l_categblog_id            
        ","blog_activo = '1' $wherecateg $wherebuscar $where", null, "blog_orden desc");

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

    $urlblog = "art/$blog_id/$blog_url/"; 

    $urlblogimgotro = $UrlFiles."admin/arch/$blog_img";

    $bloghtml .="
        <div class='col-md-6'>
            <article>
                <!-- Post Image -->
                <div class='image'>
                    <a href='$urlblog'>
                     <img src='$urlblogimgotro' alt='$blog_nombre - $compania_nombre' title='$blog_nombre - $compania_nombre' style='width: 100%; max-height: 200px' class='img-responsive'>
                    </a>
                </div>
                <!-- Post Title -->
                <a href='$urlblog'>
                    <h3>$blog_nombre</h3>
                </a>               
                
                <div style='max-height: 150px; overflow: hidden; text-align: justify; margin-bottom: 10px'>
                    $blog_descrip
                </div>            
                
                <a href='$urlblog' class='btn btn-primary'>Leer Mas</a>
            </article>
        </div>
    ";

}

if ($bloghtml==""){    
     $bloghtml ="
        <div class='col-md-12'>
            <div class='alert alert-success' style='font-size: 14px'>
                <i class='fa fa-check'></i> No existen articulos publicados $busquedabuscar
            </div>          
        </div>
    ";
}


$arrresultado = $conexion->doSelect("
        DISTINCT  blogcategoria.lista_nombre as categ_nombre, blogcategoria.lista_id as categ_id, blogcategoria.lista_url as categ_url
        ","blog
            inner join lista blogcategoria on blogcategoria.lista_id = blog.l_categblog_id

        ","blog_activo = '1' and blogcategoria.lista_activo = '1' $where", null, "lista_orden, lista_nombre asc");

foreach($arrresultado as $i=>$valor){

    $lista_categ_nombre = utf8_encode($valor["categ_nombre"]);
    $lista_categ_id = utf8_encode($valor["categ_id"]);
    $lista_categ_url = utf8_encode($valor["categ_url"]);

    $urlblogcateg = "blog?cid=$lista_categ_id";
   
    $categoriasbloghtml .="
        <li><a href='$urlblogcateg'>$lista_categ_nombre</a></li>
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

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-153888244-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-153888244-1');
    </script>

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

<!--================================
=            Page Title            =
=================================-->
<section class="page-title">
    <!-- Container Start -->
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <!-- Title text -->
                <h3>Consejos</h3>
            </div>
        </div>
    </div>
    <!-- Container End -->
</section>
<!--==================================
=            Blog Section            =
===================================-->
<section class="blog section  sectiontext" style="padding-top: 20px">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="row">
                    <?php echo $bloghtml;?>     
                </div>
               
            </div>
            <div class="col-md-2 ">
                <div class="sidebar">
                    <!-- Search Widget -->
                    <div class="widget search p-0">
                        <form action="blog" method="GET">
                            <div>
                                <input type="text" class="form-control" name="q" placeholder="Buscar..." required="required" value="<?php echo $getbuscar;?>">                         
                                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 3px; margin-top: 8px"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <!-- Category Widget -->
                    <div class="widget category" style="padding-left: 0px">
                        <!-- Widget Header -->
                        <h5 class="widget-header">Servicios</h5>
                        <ul class="category-list">
                            <li><a href='blog'>TODOS</a></li>
                            <?php echo $categoriasbloghtml;?>
                        </ul>
                    </div>                    
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



