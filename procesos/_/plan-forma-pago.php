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

(isset($_GET['id'])) ? $getplan_id=$_GET['id'] :$getplan_id='';

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

    $titulopagina = "Forma de Pago - ".$compania_nombre;
    $descripcionpagina = "Forma de Pago - $compania_nombre. Tenemos múltiples formas de pagos para que puedas adquirir tu plan en nuestra plataforma";

}


$arrresultado = $conexion->doSelect("

  listaplanservicio.listaplanserv_id, listaplanservicio.l_planserv_id, listaplanservicio.listaplanserv_precio,
  listaplanservicio.listaplanserv_porccomision, listaplanservicio.listaplanserv_contactos, 
  listaplanservicio.listaplanserv_diasduracion, listaplanservicio.listaplanserv_habiltarminutos, 
  listaplanservicio.listaplanserv_notifwhatsapp, listaplanservicio.cuenta_id, listaplanservicio.compania_id,    
  listaplanservicio.listaplanserv_fechareg, listaplanservicio.usuario_idreg,

  plan.lista_id as plan_id, plan.lista_nombre as plan_nombre, plan.lista_img as plan_img,
  plan.lista_orden as plan_orden, plan.lista_activo as plan_activo, plan.lista_descrip as plan_descrip,

  cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
  cuenta.usuario_apellido as cuenta_apellido, compania_nombre,

  listaplanservdet_id, listaplanservdet_descrip, listaplanservdet_orden, listaplanservdet_activo,
  moneda.lista_nombredos as moneda_siglas

    ",
  "
  listaplanservicio
    inner join lista plan on plan.lista_id = listaplanservicio.l_planserv_id  
    inner join lista moneda on moneda.lista_id = listaplanservicio.l_moneda_id                  
    inner join usuario cuenta on listaplanservicio.cuenta_id = cuenta.usuario_id
    inner join compania on compania.compania_id = listaplanservicio.compania_id       
    inner join listaplanserviciodetalle on listaplanserviciodetalle.l_plan_id = plan.lista_id
  ",
  "listaplanservdet_activo = '1' and plan.lista_activo = '1' and plan.lista_id = '$getplan_id' and plan.cuenta_id = '$SistemaCuentaId' and plan.compania_id = '$SistemaCompaniaId' ", null, "plan.lista_orden, plan.lista_id  asc");

$cont = 0;

$divprecio  =" style = 'display: none' ";
$divprecioconsultar  =" style = 'display: none' ";

foreach($arrresultado as $i=>$valor){

  $plan_id = utf8_encode($valor["plan_id"]);

  $listaplanservdet_id = utf8_encode($valor["listaplanservdet_id"]);
  $moneda_siglas = utf8_encode($valor["moneda_siglas"]);
  $listaplanservdet_descrip = utf8_encode($valor["listaplanservdet_descrip"]);
  $listaplanservdet_orden = utf8_encode($valor["listaplanservdet_orden"]);
  $listaplanservdet_activo = utf8_encode($valor["listaplanservdet_activo"]);

  $listaplanserv_id = utf8_encode($valor["listaplanserv_id"]);
  $l_planserv_id = utf8_encode($valor["l_planserv_id"]);
  $listaplanserv_precio = utf8_encode($valor["listaplanserv_precio"]);
  $listaplanserv_porccomision = utf8_encode($valor["listaplanserv_porccomision"]);
  $listaplanserv_contactos = utf8_encode($valor["listaplanserv_contactos"]);
  $listaplanserv_diasduracion = utf8_encode($valor["listaplanserv_diasduracion"]);
  $listaplanserv_habiltarminutos = utf8_encode($valor["listaplanserv_habiltarminutos"]);
  $listaplanserv_notifwhatsapp = utf8_encode($valor["listaplanserv_notifwhatsapp"]);
  $t_cuenta_id = utf8_encode($valor["cuenta_id"]);
  $t_compania_id = utf8_encode($valor["compania_id"]);    
  $listaplanserv_fechareg = utf8_encode($valor["listaplanserv_fechareg"]);
  
  $plan_nombre = utf8_encode($valor["plan_nombre"]);
  $plan_img = utf8_encode($valor["plan_img"]);  
  $plan_orden = utf8_encode($valor["plan_orden"]);  
  $plan_activo = utf8_encode($valor["plan_activo"]);  
  $plan_descrip = utf8_encode($valor["plan_descrip"]);  

  $urlimgPlan = $UrlFiles."admin/arch/$plan_img";

  $cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
  $cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
  $cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
  $cuenta = $cuenta_nombre." ".$cuenta_apellido." ";

  $listaplanserv_precioorig = $listaplanserv_precio;

  if ($listaplanserv_precio==""){$listaplanserv_precio=0;}

  if ($listaplanserv_precio=="0"){    

    $divprecioconsultar  ="";

  }else{
   
    $divprecio  ="";
  }

  if ($listaplanserv_precio=="0"){
    $divmostrarprecio = "
      <h4 class='py-0' style='font-size: 20px; line-height: 30px'>         
        <span style='font-size: 20px'>Sin costo&nbsp</span> <br>
      </h4>
    ";
  }else{
    $divmostrarprecio = "
      <h4 class='py-0' style='font-size: 20px; line-height: 30px'> 
        <span style='font-size: 20px'>$listaplanserv_precio ARS /mes</span> <br>
      </h4>
    ";
  }


  $listaplanserv_precio = number_format($listaplanserv_precio,2,",",".");

  $preciomostrar = $listaplanserv_precio."".$moneda_siglas;

  $plandetallehtml .= "
        <li class='my-4'> <i class='fa fa-check'></i> $listaplanservdet_descrip</li>
    ";

  $plan_id_old = $plan_id;

  $cont = $cont +1;

}


$where = " and listacuenta.cuenta_id = '$SistemaCuentaId and listacuenta.compania_id = '$SistemaCompaniaId' ";
$wherecuenta = " and listacuenta.cuenta_id = '$SistemaCuentaId' and listacuenta_activo = '1' ";
$wherecompania = " and listacuenta.compania_id = '$SistemaCompaniaId' ";   
$wherelistacuenta = " and listacuenta.cuenta_id = '$SistemaCuentaId' and listacuenta.compania_id = '$SistemaCompaniaId'  ";
$wherelistaactivo = " and lista.lista_activo = '1' "; 


$arrresultado = $conexion->doSelect("

    lista.lista_id, lista.lista_nombre, lista.lista_img, lista.lista_orden, lista.lista_activo, lista.lista_ppal,     
    lista.cuenta_id as cuenta_idsistema, lista.compania_id as compania_idsistema,
        
    cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
      cuenta.usuario_apellido as cuenta_apellido, compania.compania_nombre as compania_nombre,
      cuenta.usuario_codigo as cuentasistema_codigo, cuenta.usuario_nombre as cuentasistema_nombre,
      cuenta.usuario_apellido as cuentasistema_apellido, companiasistema.compania_nombre as companiasistema_nombre,

      listacuenta.cuenta_id, listacuenta.compania_id,
      listacuenta.listacuenta_id, listacuenta.listacuenta_activo, listacuenta.listacuenta_eliminado, 
      listacuenta.listacuenta_img, listacuenta.listacuenta_orden,
    listacuenta.listacuenta_nombre,
    lista.tipolista_id,

    listaformapago.listaformapago_id, listaformapago.l_formapago_id, listaformapago.listaformapago_titular,
    listaformapago.listaformapago_documento, listaformapago.listaformapago_email, 
    listaformapago.listaformapago_banco, listaformapago.listaformapago_tipocuenta, 
    listaformapago.listaformapago_nrocuenta, listaformapago.listaformapago_otros, 
    listaformapago.usuario_idreg,
    DATE_FORMAT(listaformapago_fechareg,'%d/%m/%Y %H:%i:%s') as listaformapago_fechareg

      ",
    "
    lista 

      inner join usuario cuentasistema on cuentasistema.usuario_id = lista.cuenta_id
        inner join compania companiasistema on companiasistema.compania_id = lista.compania_id              

      inner join listacuenta on listacuenta.lista_id = lista.lista_id
      $wherelistacuenta

      inner join listaformapago on listaformapago.l_formapago_id = lista.lista_id
            and listaformapago.listacuenta_id = listacuenta.listacuenta_id
            
      inner join usuario cuenta on cuenta.usuario_id = listacuenta.cuenta_id
        inner join compania on compania.compania_id = listacuenta.compania_id              

        $wherecuenta
        $wherecompania

    ",
    "lista.lista_activo = '1' and lista.tipolista_id = '21'  and ((lista.lista_ppal = '1' $wherelistaactivo) or (lista.lista_ppal = '0' ))  and listaformapago.cuenta_id = '$SistemaCuentaId' and listaformapago.compania_id = '$SistemaCompaniaId'  ", null, "lista.lista_orden asc");


  foreach($arrresultado as $i=>$valor){

    $cuenta_idsistema = utf8_encode($valor["cuenta_idsistema"]);  
    $compania_idsistema = utf8_encode($valor["compania_idsistema"]);      

    $listacuenta_id = utf8_encode($valor["listacuenta_id"]);  
    $listacuenta_nombre = utf8_encode($valor["listacuenta_nombre"]);  
    $listacuenta_activo = utf8_encode($valor["listacuenta_activo"]);  
    $listacuenta_eliminado = utf8_encode($valor["listacuenta_eliminado"]);  
    $listacuenta_orden = utf8_encode($valor["listacuenta_orden"]); 
    $listacuenta_img = utf8_encode($valor["listacuenta_img"]); 

    $t_cuenta_id = utf8_encode($valor["cuenta_id"]);
    $t_compania_id = utf8_encode($valor["compania_id"]);    
    
    $lista_id = utf8_encode($valor["lista_id"]);
    $lista_nombre = utf8_encode($valor["lista_nombre"]);
    $lista_img = utf8_encode($valor["lista_img"]);  
    $lista_orden = utf8_encode($valor["lista_orden"]);  
    $lista_activo = utf8_encode($valor["lista_activo"]);      
    $lista_ppal = utf8_encode($valor["lista_ppal"]);      

    $cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
    $cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
    $cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
    $cuenta = $cuenta_nombre." ".$cuenta_apellido." ";
    $compania_nombre = utf8_encode($valor["compania_nombre"]);


    $cuentasistema_nombre = utf8_encode($valor["cuentasistema_nombre"]);
    $cuentasistema_apellido = utf8_encode($valor["cuentasistema_apellido"]);
    $cuentasistema_codigo = utf8_encode($valor["cuentasistema_codigo"]);
    $cuentasistema = $cuentasistema_nombre." ".$cuentasistema_apellido." ";
    $companiasistema_nombre = utf8_encode($valor["companiasistema_nombre"]);

    $lista_activooriginal = $lista_activo;

    $listaformapago_id = utf8_encode($valor["listaformapago_id"]);
    $l_formapago_id = utf8_encode($valor["l_formapago_id"]);
    $listaformapago_titular = utf8_encode($valor["listaformapago_titular"]);
    $listaformapago_documento = utf8_encode($valor["listaformapago_documento"]);
    $listaformapago_email = utf8_encode($valor["listaformapago_email"]);
    $listaformapago_banco = utf8_encode($valor["listaformapago_banco"]);
    $listaformapago_tipocuenta = utf8_encode($valor["listaformapago_tipocuenta"]);
    $listaformapago_nrocuenta = utf8_encode($valor["listaformapago_nrocuenta"]);
    $listaformapago_otros = utf8_encode($valor["listaformapago_otros"]);
    $listaformapago_fechareg = utf8_encode($valor["listaformapago_fechareg"]);


    if ($listacuenta_id!=""){
      $lista_nombre = $listacuenta_nombre;
      $lista_orden = $listacuenta_orden;
      $lista_img = $listacuenta_img;
      $lista_activo = $listacuenta_activo;
    }

    $urlimgFormaPago = $UrlFiles."admin/arch/$lista_img";

    $formapagoelegir .="
        <div class='col-md-4' style='margin-top: 30px'>
            <div class='category-block'>
              <center>
                  <img src='$urlimgFormaPago' style='height: 80px' alt='Forma de Pago: $lista_nombre - $compania_nombre' title='Forma de Pago: $lista_nombre - $compania_nombre' />
                  <h3>$lista_nombre</h3>
                  <br />
                  <a href='plan-pagar?id=$plan_id&lid=$lista_id&fid=$listacuenta_id' class='btn btn-primary'>Elegir</a>
              </center>
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

<section class="section">
    <!-- Container Start -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Plan para Adquirir:  <span style="font-weight: normal;"><?php echo $plan_nombre;?> </h3>
                <h4>Precio para Pagar:  <span style="font-weight: normal;"><?php echo $listaplanserv_precio;?> <?php echo $moneda_siglas;?> </span></h4>
                <hr />
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3>Seleccione su Forma de Pago</h3>              
            </div>
        </div>
        <div class="row" style="margin-top: 15px">
            <?php echo $formapagoelegir; ?>
        </div>
    </div>
    <!-- Container End -->
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



