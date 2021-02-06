<?php
include("verificar_usuario.php");
require("conexion.php");

$_SESSION["nombre"];
$_SESSION["idusuario"];
$idalbum=$_GET["idalbum"];

$sql="select * from albumes,fotos where albumes.idalbum = $idalbum and fotos.idalbum = albumes.idalbum";
$result=$conexion->query($sql);
//echo $idalbum;
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
    
<body >
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
                
                <li><a href="galeria_admin.php">Concurso de galeria</a></li>
                <li><a href="destruir_sesion.php" >Cerrar Sesión</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
</div>
    </header>

<div id="wrapper" class="clearfix">
  <!-- preloader -->
  <div id="preloader">
    <div id="spinner">
      <div class="preloader-dot-loading">
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
      </div>
    </div>
    <div id="disable-preloader" class="btn btn-default btn-sm">Disable Preloader</div>
  </div>

    </div>
<div class="container">
        
     <form method="post" enctype="multipart/form-data">
    <div>
      <nav class="fixed-top" >
        
        <div class="col-md-3">
        <input class="form"type="file" multiple="multiple"  name="foto[]" required> 
            </div>
           <div class="col-md-2">
       <td ><button class="btn btn-primary btn-lg"type="submit" value="agregar"  formaction="procesos/proceso_cargar_fotos.php?idalbum=<?php echo $idalbum?>">Cargar Fotos</button></td>
          </div>
		  <div class="col-md-7">
                <?php
          
              $row=$result->fetch_assoc() 
                ?>
			<h3><label>Título del del Álbum:</label><?php echo utf8_encode($row["titulo"])?></h3>
<h4><label>Descripción:</label><?php echo utf8_encode($row["descrip"])?></h4>
              
                <?php
                
            
            ?>
		  </div>
		  
        </nav>
    
       </div>     
        </form>
    
    <form method="post">          
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
      <tr>
        
        
        <th>Titulo</th>
        <th>Descripción</th>
        <th>Imagen</th>
        <th>No de Votos</th>
        <th>Borrar</th>  
       

      </tr>
    </thead>
     
<tbody>
      <?php
            if($result->num_rows>0) {
                while($row=$result->fetch_assoc()) {
                ?>
            
            <tr>
           
                <td ><?php echo utf8_encode($row["titulo"]); ?></td>
                <td ><?php echo utf8_encode($row["descrip"]); ?></td>
                 <td><img src="<?php echo utf8_encode($row["url"]); ?>" style="width: 40%;"></td>
             
                   <td ><?php echo utf8_encode($row["votos"]); ?></td>
                
                   <td ><button class="btn btn-danger"type="button" onclick="AbrirModalEliminar(<?php echo utf8_encode($row["idfoto"])?>);"><i class="fa fa-trash" aria-hidden="true"></i></button>
                  <div style="display:none">
                  <label type="hidden" id="L<?php echo utf8_encode($row["idFoto"])?>">  </label>
                    </div>
                </td>
              
                
            </tr>
                <?php
                }
            }
            ?>
</tbody>
         
  </table>
</form>
    </div>
       <!--Modal confirmación eliminar  -->
    
        <div class="modal fade" id="ModalConfirmaciónEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="color:#1a6b10">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"  style="color:#1a6b10;text-align:center;font-family: sans-serif;">Congreso SOMAS</h4>
      </div>
      <div class="modal-body">
          <div>
              <center>
       <h3 style="font-family: sans-serif;">¿Está seguro de eliminar la foto ? <br><label id="IdFoto"></label></h3>
                  <div style="display:none;">
                  <label id="IdFotoL"></label>
                  </div>
                  
              </center>
     
        <div  style="text-align: right;">
                <button type="button" class="btn btn-danger btn-lg btn-flat btn-theme-colored pl-20 pr-20 " onclick="EliminarFoto();">SÍ</button>
        </div>



          </div>

</div>
      </div>
      
    </div>
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
          function AbrirModalEliminar(idFoto){                      
        $('#idFoto').html( $('#L'+idFoto).text());
            
         $('#IdFotoL').html(idFoto).text();
         $("#ModalConfirmaciónEliminar").modal("show");
        }
        
        
                function EliminarFoto(){
            
            var idFoto= $('#IdFotoL').text();
            
            if(idFoto != ''){
            
             data={
                    "idfoto":idFoto
                }
            
                   $.ajax({
                                type: 'POST',
                                url: 'procesos/proceso_eliminar_foto.php',
                               dataType: "json",
                                data: data,
                                success: function (data) {
                                
                                    if (data != undefined) {
                                        if (data.respuesta == "1") {
                                            window.location.href = 'cargar_fotos.php?idalbum=<?php echo $idalbum?>';
                                          
                                         
                                        }
                                        else if(data.respuesta == "0"){
                                        alert("Intente nuevamente ocurrió un error");
                                        }
                                    }
                                }
                            });
        }
            
        }
        

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