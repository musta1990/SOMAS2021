<?php
include("verificar_usuario.php");
require("conexion.php");

$_SESSION["nombre"];
$_SESSION["idusuario"];

$sql="select * from albumes;";
$result=$conexion->query($sql);

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>

<!-- Meta Tags -->
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="Neomotics" />
<meta name="keywords" content="Neomotics" />
<meta name="author" content="Neomotics" />

<!-- Page Title -->
<title>SOMAS</title>

<!-- Favicon and Touch Icons -->
<link href="LOGO_SOMAS_HQ-01.png" rel="shortcut icon" type="image/png">
<link href="LOGO_SOMAS_HQ-01.png" rel="apple-touch-icon">
<link href="LOGO_SOMAS_HQ-01.png" rel="apple-touch-icon" sizes="72x72">
<link href="LOGO_SOMAS_HQ-01.png" rel="apple-touch-icon" sizes="114x114">
<link href="LOGO_SOMAS_HQ-01.png" rel="apple-touch-icon" sizes="144x144">

<!-- Stylesheet -->
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="css/animate.css" rel="stylesheet" type="text/css">
<link href="css/css-plugin-collections.css" rel="stylesheet"/>
<!-- CSS | menuzord megamenu skins -->
<link id="menuzord-menu-skins" href="css/menuzord-skins/menuzord-rounded-boxed.css" rel="stylesheet"/>
<!-- CSS | Main style file -->
<link href="css/style-main.css" rel="stylesheet" type="text/css">
<!-- CSS | Preloader Styles -->
<link href="css/preloader.css" rel="stylesheet" type="text/css">
<!-- CSS | Custom Margin Padding Collection -->
<link href="css/custom-bootstrap-margin-padding.css" rel="stylesheet" type="text/css">
<!-- CSS | Responsive media queries -->
<link href="css/responsive.css" rel="stylesheet" type="text/css">
<!-- CSS | Style css. This is the file where you can place your own custom css code. Just uncomment it and use it. -->
 <link href="css/style.css" rel="stylesheet" type="text/css">

<!-- Revolution Slider 5.x CSS settings -->
<link  href="js/revolution-slider/css/settings.css" rel="stylesheet" type="text/css"/>
<link  href="js/revolution-slider/css/layers.css" rel="stylesheet" type="text/css"/>
<link  href="js/revolution-slider/css/navigation.css" rel="stylesheet" type="text/css"/>

<!-- CSS | Theme Color -->
<link href="css/colors/theme-skin-green.css" rel="stylesheet" type="text/css">

<!-- external javascripts -->
<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- JS | jquery plugin collection for this theme -->
<script src="js/jquery-plugin-collection.js"></script>

<!-- Revolution Slider 5.x SCRIPTS -->
<script src="js/revolution-slider/js/jquery.themepunch.tools.min.js"></script>
<script src="js/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
     <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>

<script type="text/javascript" src="datatables/datatables.min.js"></script>
    <script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').DataTable({
             
        "columnDefs": [
       { "searchable": false, "targets": 4 }
        
                      ]
                });
                
			} );
		</script>

</head>
    
<body>
 
    <header>
        <div>
   <div class="header-top bg-theme-colored sm-text-center">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="widget no-border m-0">
              <ul class="styled-icons icon-dark icon-circled icon-theme-colored icon-sm flip sm-pull-none sm-text-center mt-sm-15">
                <li><a target="_blank" href="https://www.facebook.com/congresosomas2021/"><i class="fa fa-facebook text-white"></i></a></li>
                <li><a target="_blank" href="https://youtu.be/dl4_0M7ricI"><i class="fa fa-youtube text-white"></i></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-8">
            <div class="widget no-border m-0">
              <ul class="list-inline pull-right sm-pull-none sm-text-center mt-5">
                <li class="m-0 pl-10 pr-10"> <a href="#" class="text-white">Congreso SOMAS 2021</a>
                <li class="m-0 pl-10 pr-10"> <i class="fa fa-envelope text-white"></i> <a href="#" class="text-white">presidencia@somas.org.mx</a>
                </li>
                   <li class="m-0 pl-10 pr-10">   <i class="fa fa-phone text-white"></i> <a href="#" class="text-white">229 400 6123</a>
                </li>
                
              </ul>
            </div><div class="clearfix"></div>
          </div>
            
        </div>
          
          
          
          
      </div>
    </div>
     <div class="header-nav">
      <div class="header-nav-wrapper navbar-scrolltofixed bg-silver-light">
        <div class="container">
          <nav id="menuzord-right" class="menuzord default no-bg">
            <a class="menuzord-brand pull-left flip" href="home_admin.php"><img src="img/logos_somas.png" alt=""></a>
            <ul class="menuzord-menu">
              <li class="active"><a href="#home">Usuarios</a>
                
                <li><a href="#">Concurso de galeria</a></li>
                <li><a href="destruir_sesion.php" >Cerrar Sesión</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
</div>
    </header>
       <div class="container">
<form method="post">          
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
      <tr>
        
        <th>Id Albúm</th>
        <th>Título</th>
        <th>Descripción</th>
        <th>Foto con más votos</th>
          <th>Votos</th>
        <th>Agregar Imágenes</th>
 
       
       

      </tr>
    </thead>
     
<tbody>
      <?php
            if($result->num_rows>0) {
                while($row=$result->fetch_assoc()) {
                ?>
            
            <tr>
            
                <td> <?php echo utf8_encode($row["idalbum"]);?></td>
                <td ><?php echo utf8_encode($row["titulo"]); ?></td>
                <td ><?php echo utf8_encode($row["descrip"]); ?></td>
                 <td></td>
                <td></td>

                   <td><a href="cargar_fotos.php?idalbum=<?php echo utf8_encode($row["idalbum"]);?>"  class="btn btn-success btn-lg active" role="button" aria-pressed="true"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
             
  
            </tr>
                <?php
                }
            }
            ?>
</tbody>
         
  </table>
</form>
    
  
    
    </div>
</body>
    
    <style>
        body{
            font-family: sans-serif;
        }
        
        .form-control{
            height: 30px;
        }
    </style>
    <script type="text/javascript">
        

</script>

     
<!-- end wrapper -->

<!-- Footer Scripts -->
<!-- JS | Custom script for all pages -->
<script src="js/custom.js"></script>

<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  
      (Load Extensions only on Local File Systems ! 
       The following part can be removed on Server for On Demand Loading) -->
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.actions.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.carousel.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.kenburn.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.migration.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.navigation.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.parallax.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.slideanims.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.video.min.js"></script>