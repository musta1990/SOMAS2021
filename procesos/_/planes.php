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

    $titulopagina = "Planes - ".$compania_nombre;
    $descripcionpagina = "Planes - $compania_nombre. ";

}


$arrresultado = $conexion->doSelect("

  listaplancondominio.listaplancond_id, listaplancondominio.l_plancond_id, listaplancondominio.listaplancond_precio,
  listaplancondominio.listaplancond_porccomision, listaplancondominio.listaplancond_contactos, 
  listaplancondominio.listaplancond_diasduracion, listaplancondominio.listaplancond_habiltarminutos, 
  listaplancondominio.listaplancond_notifwhatsapp, listaplancondominio.cuenta_id, listaplancondominio.compania_id,    
  listaplancondominio.listaplancond_fechareg, listaplancondominio.usuario_idreg,

  plan.lista_id as plan_id, plan.lista_nombre as plan_nombre, plan.lista_img as plan_img,
  plan.lista_orden as plan_orden, plan.lista_activo as plan_activo,

  cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
  cuenta.usuario_apellido as cuenta_apellido, compania_nombre,

  listaplanconddet_id, listaplanconddet_descrip, listaplanconddet_orden, listaplanconddet_activo,

  moneda.lista_nombredos as moneda_siglas

    ",
  "
  listaplancondominio
    inner join lista plan on plan.lista_id = listaplancondominio.l_plancond_id          
    inner join lista moneda on moneda.lista_id = listaplancondominio.l_moneda_id          
    inner join usuario cuenta on listaplancondominio.cuenta_id = cuenta.usuario_id
    inner join compania on compania.compania_id = listaplancondominio.compania_id       
    left join listaplancondominiodetalle on listaplancondominiodetalle.l_plan_id = plan.lista_id and listaplanconddet_activo = '1'
  ",
  " plan.lista_activo = '1' and plan.cuenta_id = '$SistemaCuentaId' and plan.compania_id = '$SistemaCompaniaId' ", null, "plan.lista_orden, plan.lista_id, listaplancondominiodetalle.listaplanconddet_orden  asc");

$cont = 0;
foreach($arrresultado as $i=>$valor){
  $plan_id = utf8_encode($valor["plan_id"]);

  if ($plan_id_old!=$plan_id && $cont!="0"){   

    

    $planeshtml .= "
      <div class='col-lg-4 col-md-6' style='margin-bottom: 15px'>
          <div class='package-content bg-light border text-center p-2 my-2 my-lg-0'>
              <div class='package-content-heading border-bottom'>
                  <a href='plan-detalle?id=$plan_id_old'>
                    <center>
                        <img src='$urlimgPlan' class='img-responsive' style='height:140px' />
                    </center>
                    <h2 style='padding-top: 10px; padding-bottom: 4px'>$plan_nombre</h2>
                    $divprecio
                  </a>
              </div>
              <ul>
                  $plandetallehtml
              </ul>
              <a href='plan-detalle?id=$plan_id_old' class='btn btn-primary' style='margin-top: 5px'>Conocer Más</a>
              $divcontratar
          </div>
      </div>
    ";

     $plandetallehtml ="";

  }

  $listaplanconddet_id = utf8_encode($valor["listaplanconddet_id"]);
  $moneda_siglas = utf8_encode($valor["moneda_siglas"]);
  $listaplanconddet_descrip = utf8_encode($valor["listaplanconddet_descrip"]);
  $listaplanconddet_orden = utf8_encode($valor["listaplanconddet_orden"]);
  $listaplanconddet_activo = utf8_encode($valor["listaplanconddet_activo"]);

  $listaplancond_id = utf8_encode($valor["listaplancond_id"]);
  $l_plancond_id = utf8_encode($valor["l_plancond_id"]);
  $listaplancond_precio = utf8_encode($valor["listaplancond_precio"]);
  $listaplancond_porccomision = utf8_encode($valor["listaplancond_porccomision"]);
  $listaplancond_contactos = utf8_encode($valor["listaplancond_contactos"]);
  $listaplancond_diasduracion = utf8_encode($valor["listaplancond_diasduracion"]);
  $listaplancond_habiltarminutos = utf8_encode($valor["listaplancond_habiltarminutos"]);
  $listaplancond_notifwhatsapp = utf8_encode($valor["listaplancond_notifwhatsapp"]);
  $t_cuenta_id = utf8_encode($valor["cuenta_id"]);
  $t_compania_id = utf8_encode($valor["compania_id"]);    
  $listaplancond_fechareg = utf8_encode($valor["listaplancond_fechareg"]);
  
  $plan_nombre = utf8_encode($valor["plan_nombre"]);
  $plan_img = utf8_encode($valor["plan_img"]);  
  $plan_orden = utf8_encode($valor["plan_orden"]);  
  $plan_activo = utf8_encode($valor["plan_activo"]);  

  $urlimgPlan = $UrlFiles."admin/arch/$plan_img";

  $cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
  $cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
  $cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
  $cuenta = $cuenta_nombre." ".$cuenta_apellido." ";

  $listaplancond_precioorig = $listaplancond_precio;

  if ($listaplancond_precio==""){$listaplancond_precio=0;}

  $listaplancond_precio = number_format($listaplancond_precio,2,",",".");

  if ($listaplancond_precioorig=="0" || $listaplancond_precioorig==""){
    $divprecio = "
      <h4 class='py-0' style='font-size: 20px; line-height: 30px'>         
        
      </h4>
    ";
    $divcontratar = "
      
    ";
  }else{
    $divprecio = "
      <h4 class='py-0' style='font-size: 20px; line-height: 30px'> 
        <span style='font-size: 20px'>$listaplancond_precio $moneda_siglas </span> <br>
      </h4>
    ";

    $divcontratar = "
      <a href='plan-forma-pago?id=$plan_id' class='btn btn-success' style='margin-top: 5px'>Contratar</a>
    ";
  }

  $plandetallehtml .= "
        <li class='my-4'> <i class='fa fa-check'></i> $listaplanconddet_descrip</li>
    ";

  $plan_id_old = $plan_id;

  $cont = $cont +1;

}


if ($plandetallehtml!=""){
  $planeshtml .= "
      <div class='col-lg-4 col-md-6' style='margin-bottom: 15px'>
          <div class='package-content bg-light border text-center p-2 my-2 my-lg-0'>
              <div class='package-content-heading border-bottom'>
                  <a href='plan-detalle?id=$plan_id'>
                    <center>
                        <img src='$urlimgPlan' class='img-responsive' style='height:140px' />
                    </center>
                    <h2 style='padding-top: 10px; padding-bottom: 4px'>$plan_nombre</h2>
                    $divprecio
                  </a>
              </div>
              <ul>
                  $plandetallehtml
              </ul>
              <a href='plan-detalle?id=$plan_id' class='btn btn-primary' style='margin-top: 5px'>Conocer Más</a>
              $divcontratar
          </div>
      </div>
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
          $( "#buscador" ).val( ui.item.label + " - "+ ui.item.desc );
          return false;
        },
        select: function( event, ui ) {
          //$( "#project" ).val( ui.item.label );
          $( "#subc" ).val( ui.item.value );
          //$( "#project-description" ).html( ui.item.desc );
          //$( "#project-icon" ).attr( "src", "images/" + ui.item.icon );
   
          return false;
        }
      })
      .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          .append( "<div><strong>" + item.label + "</strong><br>" + item.desc + "</div>" )
          .appendTo( ul );
      };
    } 
  );
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

  <section class="page-title">
      <!-- Container Start -->
      <div class="container">
          <div class="row">
              <div class="col-md-8 offset-md-2 text-center">
                  <!-- Title text -->
                  <h3>Planes</h3>
              </div>
          </div>
      </div>
      <!-- Container End -->
  </section>

  <section class="section">
      <div class="container">
          <div class="row">
             
              <?php echo $planeshtml; ?>
          </div>
      </div>
  </section>


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



