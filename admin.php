<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>

<!-- Meta Tags -->
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="FundPro - Nonprofit, Crowdfunding & Charity HTML5 Template" />
<meta name="keywords" content="charity,crowdfunding,nonprofit,orphan,Poor,funding,fundrising,ngo,children" />
<meta name="author" content="ThemeMascot" />

<!-- Page Title -->
<title>FundPro - Nonprofit, Crowdfunding & Charity HTML5 Template</title>

<!-- Favicon and Touch Icons -->
<link href="images/favicon.png" rel="shortcut icon" type="image/png">
<link href="images/apple-touch-icon.png" rel="apple-touch-icon">
<link href="images/apple-touch-icon-72x72.png" rel="apple-touch-icon" sizes="72x72">
<link href="images/apple-touch-icon-114x114.png" rel="apple-touch-icon" sizes="114x114">
<link href="images/apple-touch-icon-144x144.png" rel="apple-touch-icon" sizes="144x144">

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
<!-- <link href="css/style.css" rel="stylesheet" type="text/css"> -->

<!-- CSS | Theme Color -->
<link href="css/colors/theme-skin-orange.css" rel="stylesheet" type="text/css">

<!-- external javascripts -->
<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- JS | jquery plugin collection for this theme -->
<script src="js/jquery-plugin-collection.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="">
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
  

    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-push-3">
           <img src="img/logos_somas.png">
            <hr>
            <h3 style="text-align: center;">Congreso SOMAS 2021</h3>
            <form name="login-form" class="clearfix">
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="form_username_email">Correo</label>
                  <input name="form_username_email" class="form-control" type="text"  id="correo">
                      <span id="correoOK" style="color:red;"></span>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="form_password">Contraseña</label>
                  <input name="form_password" class="form-control" type="password" id="contrasena">
                      <span id="contrasenaOK" style="color:red;"></span>
                </div>
              </div>
              <div class="clear text-center pt-10">
              
                    <button type="button" class="btn btn-success btn-lg btn-block no-border mt-15 mb-15" onclick="login();" id="accesar">Accesar</button>
             
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>

    <script>
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
          }
 
        });
          
            document.getElementById('contrasena').addEventListener('input', function (evt) {
          if($("#contrasena").val() != ''){
             $("#contrasenaOK").html("");
          }
 
        });
      });
 
        
    function login(){
       
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
  <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>

<!-- end wrapper -->

<!-- Footer Scripts -->
<!-- JS | Custom script for all pages -->
<script src="js/custom.js"></script>

</body>
</html>