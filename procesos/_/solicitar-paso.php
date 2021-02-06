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

(isset($_GET['c'])) ? $getcateg_id=$_GET['c'] :$getcateg_id='';

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

    $titulopagina = "Seleccione SubServicio - ".$compania_nombre;
    $descripcionpagina = "Seleccione SubServicio - $compania_nombr. Seleccione el servicio detallado que necesitas y te pondremos en contacto con nuestros profesionales que se encuentran cerca de ti. ";

}

  $arrresultado = ObtenerListaCategorias($getcateg_id,$SistemaCuentaId, $SistemaCompaniaId);
  
  foreach($arrresultado as $i=>$valor){

    $categ_id = utf8_encode($valor["lista_id"]);  
    $categ_nombre = utf8_encode($valor["lista_nombre"]);            
    $categ_img = utf8_encode($valor["lista_img"]);   

    $urlcategimg = $UrlFiles."admin/arch/$categ_img";    
  }

  $arrresultado = ObtenerListaSubCategorias(null, $getcateg_id, $SistemaCuentaId, $SistemaCompaniaId);
  
  foreach($arrresultado as $i=>$valor){


    $subcateg_id = utf8_encode($valor["lista_id"]);  
    $subcateg_nombre = utf8_encode($valor["lista_nombre"]);            
    $subcateg_img = utf8_encode($valor["lista_img"]);   



    if ($subcateg_img=="" || $subcateg_img=="0.jpg"){
      $subcateg_img  = $categ_img;
    }

    $urlenviar = "solicitar-paso2?c=$categ_id&s=$subcateg_id";

    $urlca = $UrlFiles."admin/arch/$subcateg_img";


    $subcategorias .="
        <div class='col-lg-2 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6'>
            <div class='category-block'>
                <div class='header'>
                    <a href='$urlenviar' title='$subcateg_nombre'>
                      <center>
                          <img src='$urlca' alt='Servicio $subcateg_nombre' style='height: 80px; max-width: 100%' class='img-responsive' />
                      </center>
                      <h4 style='overflow-wrap: anywhere;'>$subcateg_nombre</h4>
                    </a>
                </div>
            </div>
        </div>
    ";
  }

/*
$arrresultado = $conexion->doSelect("distinct blog.blog_id, blog_nombre, blog_resumen, blog_url","blog","blog_activo = '1'", null, "blog_orden desc");

$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
$repl = array('a', 'e', 'i', 'o', 'u', 'n');

foreach($arrresultado as $i=>$valor){

    $blog_id = utf8_encode($valor["blog_id"]);
    $blog_nombre = utf8_encode($valor["blog_nombre"]);
    $blog_nombre = utf8_encode($valor["blog_nombre"]);
    $blog_resumen = utf8_encode($valor["blog_resumen"]);
    $blog_fecha = utf8_encode($valor["blog_fecha"]);
    $blog_activo = utf8_encode($valor["blog_activo"]);
    $blog_img = utf8_encode($valor["blog_img"]);
    $blog_orden = utf8_encode($valor["blog_orden"]);
    $blog_categ_nombre = utf8_encode($valor["categ_nombre"]);
    $blog_url = utf8_encode($valor["blog_url"]);
    
    $blog_resumen1 = str_replace($find, $repl, $blog_resumen);
    $blog_resumen1 = preg_replace("/[\r\n|\n|\r]+/", " ", $blog_resumen1);
   

    $urlblog = "art/$blog_id/$blog_url/"; 

    if ( $opcionesblog!=""){
      $colocarsigno = ",";
    }

     $opcionesblog .= "
          $colocarsigno 
          {
            value: '$blog_id',
            label: '$blog_nombre'            
          }

     ";

}

*/

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

    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

  <script>
    $( function() {
      var projects = [
        <?php echo $opcionescategoria;?>
      ];
   
      $( "#buscador" ).autocomplete({
        minLength: 0,
        source: projects,
        focus: function( event, ui ) {
          $( "#buscador" ).val( ui.item.label);
          return false;
        },
        select: function( event, ui ) {
          //$( "#project" ).val( ui.item.label );
          $( "#art" ).val(ui.item.value );
          //$( "#project-description" ).html( ui.item.desc );
          //$( "#project-icon" ).attr( "src", "images/" + ui.item.icon );
   
          return false;
        }
      })
      .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          .append( "<div>" + item.label + "</div>" )
          .appendTo( ul );
      };
    } );
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
                <h3>Paso 1.- Seleccione SubServicio </h3>
            </div>
        </div>
    </div>
    <!-- Container End -->
  </section>

<section class="hero-area text-center" style="padding-top: 0px">
	<!-- Container Start -->
	<div class="container">
    <div class='row'>
        <div class='col-lg-10 col-10'>
            <div class='heading pb-2' style="text-align: left; padding-top: 10px">
                <h3 style='font-size: 20px; color: #2B2B2B'>
                  Servicio: <img src='<?php echo $urlcategimg;?>' class='img-responsive' style='height: 40px' />             <?php echo $categ_nombre;?> 
                  <a href="solicitar" style="font-size: 16px; color: #A1A1A1">
                    (Modificar)                 
                  </a>                 
                </h3>
            </div>               
        </div>
    </div> 
    <div class='row' style='margin-top:15px;'>      
        <div class='col-lg-12 '>
            <div class='heading pb-2' style="text-align: left; padding-top: 10px">
                <h3 style='font-size: 20px'>
                  Seleccione SubServicio
                </h3>
            </div>               
        </div>
    </div>		
	</div>
	<!-- Container End -->
</section>
<!--==========================================
=            All Category Section            =
===========================================-->

<section class=" section" style="margin-top: 0px">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-12">				
				<div class="row">
					<?php echo $subcategorias;?>					                    
				</div>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>


<?php include_once "include-consultas.php"; ?>

<?php include_once "footer.php"; ?>

<!-- JAVASCRIPTS -->

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



