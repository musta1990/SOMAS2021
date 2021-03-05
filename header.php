<?php 
if(empty($_SESSION)){
    session_start();
}
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
</head>

    
    
<body class="container">
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

   <div class="header-top bg-theme-colored sm-text-center">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
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
                <li class="m-0 pl-10 pr-10"> <i class="fa fa-envelope text-white"></i> <a href="#" class="text-white">somaspresidencia@gmail.com</a>
                <li class="m-0 pl-10 pr-10"> <i class="fa fa-phone text-white"></i> <a href="#" class="text-white">229 400 6123</a>
              </ul>
            </div><div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="header-nav">
      <div class="header-nav-wrapper navbar-scrolltofixed bg-silver-light">
        <div class="container-fluid">
          <nav id="menuzord-right" class="menuzord default no-bg">
            <ul class="menuzord-menu">
              <li class=""><a href="index.php">BIENVENIDA</a>
              <li class=""><a href="informacion_general.php">INFORMACIÓN GENERAL</a> <!-- href="#servicios_home" CAMBIE -->
              <li class=""><a href="#galeria_home">INDICACIONES PARA PONENTES</a>
                <ul class="dropdown">
                  <li><a href="index-rtl-mp-layout1.html">A1 </a></li>
                  <li><a href="index-rtl-mp-layout1.html">A2</a></li>
                  <li><a href="index-rtl-mp-layout1.html">A3 </a></li>
                </ul>
              </li>
              <ul class="dropdown">
                <li><a href="#">XVI Simposio Internacional de Agricultura Sostenible</a></li>
                <li><a href="#">XI Congreso Nacional de Agricultura Sostenible</a></li>
                <li><a href="#">Eventos Paralelos</a></li>
                <li><a href="#">Concursos </a></li>
                <li><a href="#">Cursos Precongreso</a></li>     
              </ul>
             <li><a href="#">INSCRIPCIONES Y REGISTRO</a>
                <ul class="dropdown">
                  <li><a href="inscripciones_registro.php">PROCEDIMIENTO DE INSCRIPCIÓN AL CONGRESO</a></li>
                  <li><a href="inscripcion_precongreso.php">INSCRIPCIÓN CURSOS PRECONGRESO</a></li>
                </ul>
            </li>
                  
            <!--  <li><a href="#" onclick="AbrirModalDatos(0)">INSCRIPCIONES Y REGISTRO</a></li>-->
              
              <?php
                //var_dump($_SESSION["loggedin"]);
                if(!empty($_SESSION["loggedin"])) {
              ?>
              
              <li class=""><a href="#galeria_home">Galeria</a>
              
              <?php
}
    ?>
              
                    <ul class="dropdown">
                      <li><a href="index-rtl-mp-layout1.html">Concurso de Fotografía</a></li>
                      <li><a href="index-rtl-mp-layout1.html">Expor Virtual de experiencias exitosas</a></li>
                      <li><a href="index-rtl-mp-layout1.html">Memoria Fotográfica </a></li>
                    </ul>
                  
              </li>
                <!--ELIMINADO-->
                <!--<li><a href="#ubicacion">Contáctanos</a></li>-->
                 <?php
                if(!empty($_SESSION["loggedin"])){
                ?> 
                <li><a href="perfil.php"> Mi perfil <span><i class="fa fa-user "></i></span></a></li>
                     <li><a href="destruir_sesion.php" >CERRAR SESIÓN</a></li>
                <?php
                }else{   ?>
              
                  <li><a href="#" data-toggle="modal" data-target="#exampleModal">INICIAR SESIÓN</a></li>    
               <?php } ?>
               <li class=""><a href="programa_detallado.php">PROGRAMA DETALLADO</a>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <div>
    <div style="float: right;">
      <a class="menuzord-brand pull-left flip" href="#">
        <img src="img/logos_somas.png" alt="Logo de SOMAS" style="height:40px;">
        <img src="img/emblema.jpg" alt="Emblema" style="">
      </a>
    </div>
    </div>
    
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="color:#1a6b10">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"  style="color:#1a6b10;text-align:center;">Congreso SOMAS</h4>
      </div>
      <div class="modal-body" >
          <div>
   <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Correo electrónico</label>
            <input type="text" class="form-control" id="correo">
            <span id="correoOK" style="color:red;"></span>
          </div>
        
            <div class="form-group">
            <label for="message-text" class="control-label" style="font-size: 20px;">Contraseña</label>
             <input type="password" class="form-control" id="contrasena">
             <span id="contrasenaOK" style="color:red;"></span>
          </div>
              <div id="aviso_pago" style="color:white;;background:red;text-align:center;display:none;">
                  Para tener acceso a la plataforma debe de completar el pago de inscripción
              </div>
       <div style="text-align:center">
          <a href="" style="color:#1a6b10;font-size: 20px;" >Registrarse</a><br>
          <a style="color:#1a6b10;font-size: 20px;">¿Olvidaste tu contraseña?</a>
          
     </div>
        <div  style="text-align: right;">
                <button type="button" class="btn btn-colored btn-lg btn-flat btn-theme-colored pl-20 pr-20 " onclick="accesar();" id="accesar">Accesar</button>
        </div>



          </div>

</div>
      </div>
      
    </div>
  </div>
    
     <!--Modal Datos de usuarios -->
    
        <div class="modal fade" id="ModalDatos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="color:#1a6b10"  >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="padding-bottom: 220px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"  style="color:#1a6b10;text-align:center;font-family:sans-serif";>Congreso SOMAS 2021</h4>
      </div>
      <div class="modal-body">
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
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Contraseña</label>
            <input type="password" class="form-control" id="contra1">
            <span id="contra1OK" style="color:red;"></span>
          </div>
              
        
              
            <div class="form-group" >
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Tipo de Inscripción</label>
          <select class="form-control" id="socio">
              <option value="0">ESTUDIANTE</option>
              <option value="1">NO SOCIO</option>
            <option value="2">SOCIO</option>
          </select>

          </div>
             

        
        <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Correo</label>
            <input type="text" class="form-control" id="Correo">
            <span id="CorreoOK" style="color:red;"></span>
          </div>
             
            
              </div>
                   <div class="col-md-6">
                           <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Apellidos</label>
            <input type="text" class="form-control" id="Apellidos">
            <span id="ApellidosOK" style="color:red;"></span>
          </div>
               
              <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Confirmar contraseña</label>
            <input type="password" class="form-control" id="contra2">
            <span id="contra2OK" style="color:red;"></span>
          </div>
                       
       
                
                        
                 <div class="form-group" style="display:none;" id="Divmembresia">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Número de Membresía</label>
            <input type="text" class="form-control" id="membresia">
          <!--  <span id="TelefonoOK" style="color:red;"></span>-->
          </div>

        <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Teléfono</label>
            <input type="text" class="form-control" id="Telefono">
            <span id="TelefonoOK" style="color:red;"></span>
        </div>

           </div>
        <div  style="text-align: right;">
                <button type="button" class="btn btn-danger btn-lg btn-flat btn-theme-colored pl-20 pr-20 " onclick="UpdateUsuario()" id="btn_update1"><label id="lbl-updateusuario"></label>Registarse</button>
        </div>



          </div>

</div>
      </div>
      
    </div>
  </div>
        </div>

    


<script>
          
      $("#socio").change(function(){
      var estado = $("#socio").val();
      //alert(estado);
          
          if(estado == 1){
               $('#Divmembresia').css('display', 'block');
            }else{
            $('#Divmembresia').css('display', 'none');
            }
    });
    
     function limpiarDatos(){
               $('#Nombre').val('');
               $('#Apellidos').val('');
               $('#Correo').val('');
               $('#contra1').val('');
               $('#contra2').val('');
              
               $('#socio').val(0);
               $('#Telefono').val('');
              
               
        }
    
  function AbrirModalDatos(idUsuario){                      
       // $('#NombreUsuario').html( $('#L'+idUsuario).text());
            
       
         $("#ModalDatos").modal("show");
             
           //  limpiarDatos();
               
      
             
        }    
    
    
    
        function UpdateUsuario(){
      
     
            
        var nombre = false;
        var apellidos= false;
        var correo = false;
        var correo_valido = false;
        var contrasena1=false;
        var contrasena2=false;
        
        var telefono = false;
        var url ="";
            

               url="procesos/proceso_agregar_usuario.php";
            
                
               
             
       
            
            
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
                 
                      var socio = $('#socio').val();
                      var telefono = $('#Telefono').val();
                
                      var membresia = $('#membresia').val();
                      

                data={
                    "idusuario":idUsuario,
                    "Nombre":nombre,
                    "Apellidos":apellidos,
                    "correo":correo,
                    "tipo":"U",
                    "socio":socio,
                    "contrasena":contrasena,
                    "telefono":telefono,
                    "comprobantepago":0,
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
                                            var idusuario = data.idusuario;
                                            window.location.href = 'index.php';
                                         
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
    
    //Para quitar los tags de error cuando escriban en los inputs 
      $(function () {
          
          $("#correo").bind('keydown', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#accesar').click();
        }
    });
          
              $("#contrasena").bind('keydown', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#accesar').click();
        }
    });

   
        document.getElementById('correo').addEventListener('input', function (evt) {
       if($("#correo").val() != ''){
             $("#correoOK").html("");
           document.getElementById("aviso_pago").style.display = "none";
          }
 
        });
          
            document.getElementById('contrasena').addEventListener('input', function (evt) {
          if($("#contrasena").val() != ''){
             $("#contrasenaOK").html("");
          }
                document.getElementById("aviso_pago").style.display = "none";
 
        });
      });
    
    function accesar(){
        var correo = $("#correo").val();
        var contrasena =  $("#contrasena").val();
   
        if(correo != ''){
            if(contrasena !=''){
                
                      
                data={
                    "correo":correo,
                    "contrasena":contrasena
                }
                
                    $.ajax({
                                type: 'POST',
                                url: 'procesos/proceso_login.php',
                               dataType: "json",
                                data: data,
                                success: function (data) {
                                
                                    if (data != undefined) {
                                        if (data.respuesta == "1") {
                                            window.location.href = 'home_admin.php';
                                         
                                        }else if(data.respuesta == "2"){
                                       
                                                  document.getElementById("aviso_pago").style.display = "block";
                                        }else if(data.respuesta == "3"){
                                               window.location.href = 'index.php';    
                                           
                                        }
                                        else if(data.respuesta == "0"){
                                        $("#contrasenaOK").html("Usuario o contraseña incorrrecta");
                                        }
                                    }
                                }
                            });
               
               }else{
                      $("#contrasenaOK").html("Introduzca una contraseña");
               }
         
           }else{
                 $("#correoOK").html("Introduzca un correo electrónico");
           }
  
    }
</script>


<style>
    #tipoInscripcion{
    margin-top: 50px;
    }
</style>





