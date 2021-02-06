<?php
include("verificar_usuario.php");
require("conexion.php");

$_SESSION["nombre"];
$_SESSION["idusuario"];

$sql="select * from usuarios;";
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
    <br><br>
       <button class="btn btn-success"  onclick="AbrirModalUpdateUsuario(0)">Nuevo</button><br><br>
<form method="post">          
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
      <tr>
        
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Correo</th>
        <th>Tipo</th>
        <th>Socio</th>
        <th>Membresia</th>  
        <th>Teléfono</th>
        <th>Comprobante de pago</th>
        <th>Editar</th>
        <th>Borrar</th>
       

      </tr>
    </thead>
     
<tbody>
      <?php
            if($result->num_rows>0) {
                while($row=$result->fetch_assoc()) {
                ?>
            
            <tr>
                <?php $idusuario=utf8_encode($row["idusuario"]);?>
                <td ><?php echo utf8_encode($row["nombre"]); ?></td>
                <td ><?php echo utf8_encode($row["apellidos"]); ?></td>
                 <td ><?php echo utf8_encode($row["correo"]); ?></td>
                <td ><?php  
					if(utf8_encode($row["tipo"])=='A'){
						
						echo "Administrador";
					} 
					
					if(utf8_encode($row["tipo"])=='U'){
						
						echo "Usuario";
					} 
					
					?></td>
                <td>
                <?php  
					if(utf8_encode($row["socio"])=='0'){
						
						echo "NO";
					} 
					
					if(utf8_encode($row["socio"])=='1'){
						
						echo "SI";
					} 
					
					?>
                </td>
                         <td ><?php echo utf8_encode($row["membresia"]); ?></td>
                      <td ><?php echo utf8_encode($row["telefono"]); ?></td>
                     <td ><?php  
					if(utf8_encode($row["comprobante_deposito"])=='0'){
						
						echo "NO";
					} 
					
					if(utf8_encode($row["comprobante_deposito"])=='1'){
						
						echo "SI";
					} 
					
					?></td>
                   <td ><button class="btn btn-primary"type="button" value="Editar" onclick="AbrirModalUpdateUsuario(<?php echo utf8_encode($row["idusuario"])?>)"><i class="fa fa-pencil" aria-hidden="true"></i></button></td>
                
                   <td ><button class="btn btn-danger"type="button" onclick="AbrirModalEliminar(<?php echo utf8_encode($row["idusuario"])?>);"><i class="fa fa-trash" aria-hidden="true"></i></button>
                  <div style="display:none">
                  <label type="hidden" id="L<?php echo utf8_encode($row["idusuario"])?>"><?php echo utf8_encode($row["nombre"]) ?> <?php echo utf8_encode($row["apellidos"]) ?>  </label>
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
       <h3 style="font-family: sans-serif;">¿Está seguro de eliminar a ? <br><label id="NombreUsuario"></label></h3>
                  <div style="display:none;">
                  <label id="IdUsuarioL"></label>
                  </div>
                  
              </center>
     
        <div  style="text-align: right;">
                <button type="button" class="btn btn-danger btn-lg btn-flat btn-theme-colored pl-20 pr-20 " onclick="EliminarUsuario();">SÍ</button>
        </div>



          </div>

</div>
      </div>
      
    </div>
  </div>
    
        <!--Modal Datos de usuarios -->
    
        <div class="modal fade" id="ModalDatos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="color:#1a6b10">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"  style="color:#1a6b10;text-align:center;font-family:sans-serif";>Congreso SOMAS 2021</h4>
      </div>
      <div class="modal-body" style="padding-bottom: 120px;">
          <div style="display:none;">
          <label id="IdUsuarioUpdate"></label>
          </div>
          <div>
          <div class="col-md-6">
              <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Nombre</label>
            <input type="text" class="form-control" id="Nombre">
            <span id="NombreOK" style="color:red;"></span>
          </div>
                <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Apellidos</label>
            <input type="text" class="form-control" id="Apellidos">
            <span id="ApellidosOK" style="color:red;"></span>
          </div>
              
        <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Correo</label>
            <input type="text" class="form-control" id="Correo">
            <span id="CorreoOK" style="color:red;"></span>
          </div>
              
              <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Contraseña</label>
            <input type="password" class="form-control" id="contra1">
            <span id="contra1OK" style="color:red;"></span>
          </div>
              
              <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Confirmar contraseña</label>
            <input type="password" class="form-control" id="contra2">
            <span id="contra2OK" style="color:red;"></span>
          </div>
              </div>
                   <div class="col-md-6">
               <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Tipo</label>
          <select class="form-control" id="tipo">
              <option value="U">Usuario</option>
              <option value="A">Administrador</option>
          </select>
           
          </div>
              
                    <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Socio</label>
          <select class="form-control" id="socio">
              <option value="0">NO</option>
              <option value="1">SI</option>
          </select>
           
          </div>
                       
        <div class="form-group" style="display:none;" id="Divmembresia">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Número de Membresía </label>
            <input type="text" class="form-control" id="membresia">
          <!--  <span id="TelefonoOK" style="color:red;"></span>-->
          </div>
                       
        <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Teléfono</label>
            <input type="text" class="form-control" id="Telefono">
            <span id="TelefonoOK" style="color:red;"></span>
        </div>
                       
                       
      
              
                  
        <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Comprobante de pago</label>
          <select class="form-control" id="comprobante_pago">
              <option value="0">NO</option>
              <option value="1">SI</option>
          </select>
           
          </div>
           </div>
        <div  style="text-align: right;">
                <button type="button" class="btn btn-danger btn-lg btn-flat btn-theme-colored pl-20 pr-20 " onclick="UpdateUsuario();" id="btn_update1"><label id="lbl-updateusuario"></label></button>
        </div>



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
        
            //Para quitar los tags de error cuando escriban en los inputs 
      $(function () {
   
        document.getElementById('Nombre').addEventListener('input', function (evt) {
       if($("#Nombre").val() != ''){
             $("#NombreOK").html("");
          }
 
        });
          
            document.getElementById('Apellidos').addEventListener('input', function (evt) {
          if($("#Apellidos").val() != ''){
             $("#ApellidosOK").html("");
          }
 
        });
          
            document.getElementById('Correo').addEventListener('input', function (evt) {
          if($("#Correo").val() != ''){
             $("#CorreoOK").html("");
          }
 
        });
          
          document.getElementById('contra1').addEventListener('input', function (evt) {
          if($("#contra1").val() != ''){
             $("#contra1OK").html("");
          }
 
        });
          
             document.getElementById('contra2').addEventListener('input', function (evt) {
          if($("#contra2").val() != ''){
             $("#contra2OK").html("");
          }
 
        });
          
                document.getElementById('Telefono').addEventListener('input', function (evt) {
          if($("#Telefono").val() != ''){
             $("#TelefonoOK").html("");
          }
 
        });
      });
        
        
        
        
        
	// For demo to fit into DataTables site builder...
	$('#example')
		.removeClass( 'display' )
		.addClass('table table-striped table-bordered');
        
        function AbrirModalEliminar(idUsuario){                      
        $('#NombreUsuario').html( $('#L'+idUsuario).text());
            
         $('#IdUsuarioL').html(idUsuario).text();
         $("#ModalConfirmaciónEliminar").modal("show");
        }
        
        function limpiarDatos(){
               $('#Nombre').val('');
               $('#Apellidos').val('');
               $('#Correo').val('');
               $('#contra1').val('');
               $('#contra2').val('');
               $('#tipo').val('U');
               $('#socio').val(0);
               $('#Telefono').val('');
               $('#comprobante_pago').val(0);  
               
        }
        
         function AbrirModalUpdateUsuario(idUsuario){                      
       // $('#NombreUsuario').html( $('#L'+idUsuario).text());
            
        $('#IdUsuarioUpdate').html(idUsuario).text();
         $("#ModalDatos").modal("show");
             
             limpiarDatos();
               
         if(idUsuario == '0'){
                $('#lbl-updateusuario').html('Agregar');
         }else if(idUsuario > 0 ){
                $('#lbl-updateusuario').html('Actualizar');
             
             data = {
                 
                 "idusuario":idUsuario
             }
             
               $.ajax({
                                type: 'POST',
                                url: 'procesos/proceso_consultar_usuario.php',
                                dataType: "json",
                                data: data,
                                success: function (data) {
                          
                                    if (data != undefined) {
                                        
                                        var nombre =data.nombre;
                                        var apellidos = data.apellidos;
                                        var correo = data.correo;
                                        var tipo = data.tipo;
                                        var socio = data.socio;
                                        var contrasena = data.contrasena;
                                        var telefono=data.telefono;
                                        var comprobante= data.comprobante_deposito;
                                        var membresia= data.membresia;
                                        
                                        $('#Nombre').val(nombre);
                                        $('#Apellidos').val(apellidos);
                                        $('#Correo').val(correo);
                                        $('#contra1').val(contrasena);
                                        $('#contra2').val(contrasena);
                                        $('#tipo').val(tipo);
                                        $('#socio').val(socio);
                                        $('#Telefono').val(telefono);
                                        $('#comprobante_pago').val(comprobante);
                                         $('#membresia').val(membresia);
                                        if(membresia != ""){
                                             $('#Divmembresia').css('display', 'block');
                                           }
                                       
                                       
                                    }
                                }
                            });  
             }
             
        }
        
        function EliminarUsuario(){
            
            var idUsuario= $('#IdUsuarioL').text();
            
            if(idUsuario != ''){
            
             data={
                    "idusuario":idUsuario
                }
            
                   $.ajax({
                                type: 'POST',
                                url: 'procesos/proceso_eliminar_usuario.php',
                               dataType: "json",
                                data: data,
                                success: function (data) {
                                
                                    if (data != undefined) {
                                        if (data.respuesta == "1") {
                                            window.location.href = 'home_admin.php';
                                          
                                         
                                        }
                                        else if(data.respuesta == "0"){
                                        alert("Intente nuevamente ocurrió un error");
                                        }
                                    }
                                }
                            });
        }
            
        }
        
        function UpdateUsuario(){
      
           var idUsuariohidden =$('#IdUsuarioUpdate').text();
            
        var nombre = false;
        var apellidos= false;
        var correo = false;
        var correo_valido = false;
        var contrasena1=false;
        var contrasena2=false;
        
        var telefono = false;
        var url ="";
            
            if(idUsuariohidden =='0' ){
               url="procesos/proceso_agregar_usuario.php";
               }else{
                  url = "procesos/proceso_editar_usuario.php" 
               
                 
                   
               }
       
            
            
          if($("#Nombre").val() != ''){
             nombre=true;
          }else{
           $("#NombreOK").html("Campo requerido *");
          }
        
          if($("#Apellidos").val() != ''){
             apellidos=true;
          }else{
           $("#ApellidosOK").html("Campo requerido *");
          }
            
          if($("#Correo").val() != ''){
             correo=true;
              
              re=/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/
	       if(!re.exec($("#Correo").val())){
		//  alert('email no valido');
                 $("#CorreoOK").html("Correo no válido");
           }
              else {
                 // alert('email valido');
                  //  $("#CorreoOK").html("email valido");
                  correo_valido = true;
                  
	       }
       


              
          }else{
           $("#CorreoOK").html("Campo requerido *");
          }
            
            
            
         if($("#contra1").val() != ''){
             contrasena1=true;
          }else{
           $("#contra1OK").html("Campo requerido *");
          }
            
         if($("#contra2").val() != ''){
             contrasena2=true;
          }else{
           $("#contra2OK").html("Campo requerido *");
          }
        
               
         if($("#Telefono").val() != ''){
             telefono=true;
          }else{
           $("#TelefonoOK").html("Campo requerido *");
          }
            
              if(nombre == true && apellidos == true && correo==true && correo_valido == true && contrasena1== true && contrasena2 == true){
        // alert("comparar las contraseñas");
                  if($("#contra1").val() == $("#contra2").val() ){
                     
                      document.getElementById('btn_update1').disabled=true;
                     //alert("mandar datos");
                      var idUsuario = $('#IdUsuarioUpdate').text();
                      var nombre = $('#Nombre').val();
                      var apellidos = $('#Apellidos').val();
                      var correo = $('#Correo').val();
                      var contrasena = $('#contra1').val();
                      var tipo = $('#tipo').val();
                      var socio = $('#socio').val();
                      var telefono = $('#Telefono').val();
                      var comprobantepago = $('#comprobante_pago').val();
                      var membresia = $('#membresia').val();
                      

                data={
                    "idusuario":idUsuario,
                    "Nombre":nombre,
                    "Apellidos":apellidos,
                    "correo":correo,
                    "tipo":tipo,
                    "socio":socio,
                    "contrasena":contrasena,
                    "telefono":telefono,
                    "comprobantepago":comprobantepago,
                    "membresia":membresia
                     }
            
                        $('#btnUpdate1').attr("disabled");
                       $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: "json",
                                data: data,
                                success: function (data) {
                                
                                    if (data != undefined) {
                                        if (data.respuesta == "1") {
                                            window.location.href = 'home_admin.php';
                                         
                                        }
                                        else if(data.respuesta == "0"){
                                      alert('Hubo un error intente nuevamente');
                                        }
                                    }
                                }
                            });
                     }else{
                 
                            $("#contra1OK").html("Las contraseñas no coinciden");
                            $("#contra2OK").html("Las contraseñas no coinciden");
                     }
           }
        }
        
        
      $("#socio").change(function(){
      var estado = $("#socio").val();
      //alert(estado);
          
          if(estado == 1){
               $('#Divmembresia').css('display', 'block');
            }else{
            $('#Divmembresia').css('display', 'none');
            }
    });
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