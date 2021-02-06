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
    $compania_whatsapp = utf8_encode($valor["compania_whatsapp"]);

    $urlcompaniaimg = $UrlFiles."admin/arch/$compania_img";
    $urlcompaniaimgicono = $UrlFiles."admin/arch/$compania_imgicono";

    $titulopagina = "Solicitar - ".$compania_nombre;
    $descripcionpagina = "Solicitar - $compania_nombre. Busca el Servicio que necesitas cerca de tu ubicación. Electricistas, Plomeros, Fumigadores y muchos más ";

}

/*

$arrresultado = $conexion->doSelect("plan_id, plan_nombre, plan_img, plan_orden, plan_precio, plan_porcentaje, 
plan_fechareg, plan_activo, plan_eliminado, usuario_idreg,
plan.moneda_id, plan.frecuenciapago_id, plan_personalizado,
plan_gananciamensual, plan_gananciafrecuenciapago, plan_visible,
moneda_nombre, frecuenciapago_nombre, plan.plan_idrel, moneda_siglas, plan_gananciadiaria",
  "plan
    inner join moneda on plan.moneda_id = moneda.moneda_id
    inner join frecuenciapago on frecuenciapago.frecuenciapago_id = plan.frecuenciapago_id
  ",
  "plan_activo = '1'", null, "plan_orden  asc");

foreach($arrresultado as $i=>$valor){

  $plan_id = utf8_encode($valor["plan_id"]);
  $plan_nombre = utf8_encode($valor["plan_nombre"]);
  $plan_img = utf8_encode($valor["plan_img"]);
  $plan_orden = utf8_encode($valor["plan_orden"]);
  $plan_precio = utf8_encode($valor["plan_precio"]);
  $plan_porcentaje = utf8_encode($valor["plan_porcentaje"]);
  $plan_fechareg = utf8_encode($valor["plan_fechareg"]);
  $plan_activo = utf8_encode($valor["plan_activo"]);

  $plandetallehtml= "";

  $arrresultado2 = $conexion->doSelect("plandetalle_id, plandetalle_nombre, plandetalle_orden, plandetalle.plan_id, plandetalle_activo, plandetalle_eliminado, plandetalle_fechareg, plan_nombre",
    "plandetalle
      inner join plan on plandetalle.plan_id = plan.plan_id
    ",
    "plandetalle_activo = '1' and plandetalle.plan_id = '$plan_id'", null, "plandetalle_orden  asc");
  foreach($arrresultado2 as $n=>$valor2){

    $plandetalle_id = utf8_encode($valor2["plandetalle_id"]);
    $plandetalle_nombre = utf8_encode($valor2["plandetalle_nombre"]);
    $plandetalle_orden = utf8_encode($valor2["plandetalle_orden"]);
    $t_plan_id = utf8_encode($valor2["plan_id"]);
    $plandetalle_activo = utf8_encode($valor2["plandetalle_activo"]);
    $plan_nombre = utf8_encode($valor2["plan_nombre"]);

    $plandetallehtml .= "

        <li><p><span class='fa fa-check-circle available'></span>$plandetalle_nombre</li>

    ";

  }


  if ($plan_precio==""){$plan_precio=0;}

  $plan_precio = number_format($plan_precio,2,",",".");

  $planeshtml = "
    <div class='col-lg-4 col-md-6'>
        <!-- Pricing Item -->
        <div class='pricing-item featured'>
            <div class='pricing-heading'>
                <!-- Title -->
                <div class='title'>
                    <h6>$plan_nombre</h6>
                </div>
                <!-- Price -->
                <div class='price'>
                    <h2>$plan_precio<span> USD</span></h2>
                </div>
            </div>
            <div class='pricing-body'>
                <!-- Feature List -->
                <ul class='feature-list m-0 p-0'>
                    $plandetallehtml
                </ul>
            </div>
            <div class='pricing-footer text-center'>
                <a href='iniciar' class='btn btn-main-md'>Comprar</a>
            </div>
        </div>
    </div>
  ";


}

*/



$where = " and listacuenta.cuenta_id = '$SistemaCuentaId' and listacuenta.compania_id = '$SistemaCompaniaId' ";
$wherecuenta = " and listacuenta.cuenta_id = '$SistemaCuentaId' ";
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
    lista.tipolista_id
      ",
    "
    lista 

      inner join usuario cuentasistema on cuentasistema.usuario_id = lista.cuenta_id
        inner join compania companiasistema on companiasistema.compania_id = lista.compania_id              

      inner join listacuenta on listacuenta.lista_id = lista.lista_id
      $wherelistacuenta
            
      inner join usuario cuenta on cuenta.usuario_id = listacuenta.cuenta_id
        inner join compania on compania.compania_id = listacuenta.compania_id              

        $wherecuenta
        $wherecompania

    ",
    " lista.lista_eliminado = '0' and lista.cuenta_id = '$SistemaCuentaId' and lista.compania_id = '$SistemaCompaniaId' and lista.tipolista_id = '39'  and ((lista.lista_ppal = '1' $wherelistaactivo) or (lista.lista_ppal = '0' ))  ", null, "lista.lista_nombre asc");

$cont = 0;

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

    if ($listacuenta_eliminado=="1"){
      continue;
    }

    if ($listacuenta_id!=""){
      $lista_nombre = $listacuenta_nombre;
      $lista_orden = $listacuenta_orden;
      $lista_img = $listacuenta_img;
      $lista_activo = $listacuenta_activo;
    }

    if ($lista_ppal=="1" && $t_cuenta_id==""){ // Es porque no esta personalizado por la empresa
      $cuenta = $cuentasistema;
      $compania_nombre = $companiasistema_nombre;
    }

    if ($lista_activo=="0"){
      $activo = "<i onclick='cambiarestatuslista(\"".$lista_id."\",\"".$t_cuenta_id."\",\"".$t_compania_id."\",1)' title='Deshabilitar' class='fa fa-minus btn-deshabilitar'></i>";
    }else{
      $activo = "<i onclick='cambiarestatuslista(\"".$lista_id."\",\"".$t_cuenta_id."\",\"".$t_compania_id."\",0)' title='Habilitar' class='fa fa-check btn-habilitar'></i>";
    }
    
    $accioneliminar = "<i onclick='eliminarlista(\"".$lista_id."\",\"".$t_cuenta_id."\",\"".$t_compania_id."\",0)' title='Eliminar?' class='fa fa-trash btn-eliminar'></i>";  

    $modificar = "<a href='modificarcategoriaservicio?id=$lista_id&lid=$listacuenta_id'><i title='Ver' class='fa fa-edit btn-modificar'></i></a>";

    $imagen = "<img src='arch/$lista_img' style='height: 80px'";
    

    if (P_Mod!="1"){$modificar = ""; $activo = "";}
    if (P_Eli!="1"){$accioneliminar = ""; $activo = "";}

    $mostrarcolumnacuenta = "<td>$cuenta </td>";
    $mostrarcolumnacompania = "<td>$compania_nombre</td>";

    if ($_COOKIE[perfil]=="1"){      
      
    }
    else if ($_COOKIE[perfil]=="2"){       
      $mostrarcolumnacuenta = "";
    }
    else {      
      $mostrarcolumnacuenta = "";
      $mostrarcolumnacompania = ""; 
    }    
    

    $categ_url = "iniciar-sesion?i=1&c=$lista_id";

    if ($cont < 10 ){
        $categoriasbanner .="
            <li class='list-inline-item' style='margin-top: 13px'>
                <a href='$categ_url' style='color: #FFF'>$lista_nombre</a>
            </li>
        ";
    }    

    $urlca = $UrlFiles."admin/arch/$lista_img";


    $categoriapagprincipal .="
        <div class='col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6'>
            <div class='category-block'>
                <div class='header'>
                    <a href='$categ_url' title='$lista_nombre'>
                      <center>
                          <img src='$urlca' alt='Servicio $lista_nombre' style='height: 120px; max-width: 100%' class='img-responsive' />
                      </center>
                      <h4  style='text-align: center; margin-top: 5px; overflow-wrap: break-word; word-wrap: break-word;'>$lista_nombre</h4>
                    </a>
                </div>
            </div>
        </div>
    ";

    $infolabel = quitar_tildes("$lista_nombre");

    if ( $opcionescategoria!=""){
      $colocarsigno = ",";
    }

    $opcionescategoria .= "
          $colocarsigno 
          {
            value: '$lista_id',
            label: '$infolabel'          
          }

     ";

    

    $cont = $cont + 1;

}

  

  $optioncategoria = "<option value=''>Que buscas?</option>";

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

    listarel.lista_idrel, listarel.lista_nombre as listarel_nombre
      ",
    "
    lista 

      inner join usuario cuentasistema on cuentasistema.usuario_id = lista.cuenta_id
        inner join compania companiasistema on companiasistema.compania_id = lista.compania_id              

      inner join listacuenta on listacuenta.lista_id = lista.lista_id
      $wherelistacuenta
            
      inner join usuario cuenta on cuenta.usuario_id = listacuenta.cuenta_id
        inner join compania on compania.compania_id = listacuenta.compania_id 

        inner join lista listarel on listarel.lista_id = lista.lista_idrel            
        and listarel.lista_eliminado = '0'


        $wherecuenta
        $wherecompania

    ",
    "lista.lista_eliminado = '0' and lista.cuenta_id = '$SistemaCuentaId' and lista.compania_id = '$SistemaCompaniaId'  $wherecuenta and lista.tipolista_id = '40'  and ((lista.lista_ppal = '1' $wherelistaactivo) or (lista.lista_ppal = '0' ))  ", null, "lista.lista_orden asc");


  foreach($arrresultado as $i=>$valor){

    $lista_idrel = utf8_encode($valor["lista_idrel"]);  
    $listarel_nombre = utf8_encode($valor["listarel_nombre"]);  

    $cuenta_idsistema = utf8_encode($valor["cuenta_idsistema"]);  
    $compania_idsistema = utf8_encode($valor["compania_idsistema"]);      

    $listacuenta_id = utf8_encode($valor["listacuenta_id"]);  
    $listacuenta_nombre = utf8_encode($valor["listacuenta_nombre"]);  
    $listacuenta_activo = utf8_encode($valor["listacuenta_activo"]);  
    $listacuenta_eliminado = utf8_encode($valor["listacuenta_eliminado"]);  
    $listacuenta_orden = utf8_encode($valor["listacuenta_orden"]); 
    $listacuenta_img = utf8_encode($valor["listacuenta_img"]); 

    if ($listacuenta_eliminado=="1"){
      continue;
    }

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


    if ($listacuenta_id!=""){
      $lista_nombre = $listacuenta_nombre;
      $lista_orden = $listacuenta_orden;
      $lista_img = $listacuenta_img;
      $lista_activo = $listacuenta_activo;
    }

    $subservicio =$lista_nombre;
    $servicio =$listarel_nombre;

    //$infolabel = "$servicio / $subservicio";
    $infolabel = quitar_tildes("$servicio / $subservicio");


    if ( $opcionescategoria!=""){
      $colocarsigno = ",";
    }

     $opcionescategoria .= "
          $colocarsigno 
          {
            value: '$lista_id',
            label: '$infolabel'          
          }

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
          $( "#buscador" ).val( ui.item.label );
          return false;
        },
        select: function( event, ui ) {
          //$( "#project" ).val( ui.item.label );
          $( "#subc" ).val( ui.item.value );
          window.location ="iniciar-sesion?i=1&c="+ui.item.value;
          //$( "#project-description" ).html( ui.item.desc );
          //$( "#project-icon" ).attr( "src", "images/" + ui.item.icon );
   
          return false;
        }
      })
      .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          .append( "<div><strong>" + item.label + "</strong></div>" )
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

<!--================================
  =            Page Title            =
  =================================-->
  <section class="page-title">
      <!-- Container Start -->
      <div class="container">
          <div class="row">
              <div class="col-md-8 offset-md-2 text-center">
                  <!-- Title text -->
                  <h3>Que deseas Pagar?</h3>
              </div>
          </div>
      </div>
      <!-- Container End -->
  </section>

<section class="hero-area text-center" style="padding-top: 0px">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Header Contetnt -->
			
				<div class="row">
              <div class="col-md-2">

              </div>
              <div class="col-md-8">
                  <div class="advance-search">
                        <form action="iniciar-sesion" method="GET">
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <input id="buscador" class="form-control" placeholder="¿Qué deseas pagar?" />
                                    <input name="s" id="subc" type="hidden">
                                </div>
                                <div class="form-group col-md-3 align-self-center">
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </div>
                        </form>
                      
                  </div>
              </div>


          </div>

			</div>
		</div>
	</div>
	<!-- Container End -->
</section>
<!--==========================================
=            All Category Section            =
===========================================-->

<section class=" section" style="margin-top: 50px">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-12">				
				<div class="row">
					<?php echo $categoriapagprincipal;?>					                    
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



