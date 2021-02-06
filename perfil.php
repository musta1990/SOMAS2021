<?php

require("conexion.php");
require("verificar_usuario.php");

$idusuario= $_SESSION["idusuario"];
  
include("header.php");

?>

<div class="container">
         
          <div>
          <div class="col-md-6">
              <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Nombre</label>
            <input type="text" class="form-control" id="NombreP">
            <span id="NombreOKP" style="color:red;"></span>
          </div>
                <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Apellidos</label>
            <input type="text" class="form-control" id="ApellidosP">
            <span id="ApellidosOKP" style="color:red;"></span>
          </div>
              
        <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Correo</label>
            <input type="text" class="form-control" id="CorreoP">
            <span id="CorreoOKP" style="color:red;"></span>
          </div>
              
              <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Contraseña</label>
            <input type="password" class="form-control" id="contra1P">
            <span id="contra1OKP" style="color:red;"></span>
          </div>
              
              <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Confirmar contraseña</label>
            <input type="password" class="form-control" id="contra2P">
            <span id="contra2OKP" style="color:red;"></span>
          </div>
              </div>
                   <div class="col-md-6">
               <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Tipo</label>
          <select class="form-control" id="tipoP" disabled>
              <option value="U">Usuario</option>
              <option value="A">Administrador</option>
          </select>
           
          </div>
              
                    <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Socio</label>
          <select class="form-control" id="socioP" disabled>
              <option value="0">NO</option>
              <option value="1">SI</option>
          </select>
           
          </div>
                       
        <div class="form-group"  id="Divmembresia">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Número de Membresía </label>
            <input type="text" class="form-control" id="membresiaP">
          <!--  <span id="TelefonoOK" style="color:red;"></span>-->
          </div>
                       
        <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Teléfono</label>
            <input type="text" class="form-control" id="TelefonoP">
            <span id="TelefonoOKP" style="color:red;"></span>
        </div>
                       
                       
      
              
                  
        <div class="form-group">
            <label for="recipient-name" class="control-label" style="font-size: 20px;">Comprobante de pago</label>
          <select class="form-control" id="comprobante_pagoP" disabled>
              <option value="0">NO</option>
              <option value="1">SI</option>
          </select>
           
          </div>
           </div>
        <div  style="text-align: right;">
                <button type="button" class="btn btn-danger btn-lg btn-flat btn-theme-colored pl-20 pr-20 " onclick="UpdateUsuarioP();" id="btn_update1P"><label id="lbl-updateusuario"></label>Actualizar datos</button>
        </div>



          </div>

      

</div>

<script>
$( document ).ready(function() {

    AbrirModalUpdateUsuario(<?php echo $idusuario?>);
    
    
            //Para quitar los tags de error cuando escriban en los inputs 
      $(function () {
   
        document.getElementById('NombreP').addEventListener('input', function (evt) {
       if($("#NombreP").val() != ''){
             $("#NombreOKP").html("");
          }
 
        });
          
            document.getElementById('ApellidosP').addEventListener('input', function (evt) {
          if($("#ApellidosP").val() != ''){
             $("#ApellidosOKP").html("");
          }
 
        });
          
            document.getElementById('CorreoP').addEventListener('input', function (evt) {
          if($("#CorreoP").val() != ''){
             $("#CorreoOKP").html("");
          }
 
        });
          
          document.getElementById('contra1P').addEventListener('input', function (evt) {
          if($("#contra1P").val() != ''){
             $("#contra1OKP").html("");
          }
 
        });
          
             document.getElementById('contra2P').addEventListener('input', function (evt) {
          if($("#contra2P").val() != ''){
             $("#contra2OKP").html("");
          }
 
        });
          
                document.getElementById('TelefonoP').addEventListener('input', function (evt) {
          if($("#TelefonoP").val() != ''){
             $("#TelefonoOKP").html("");
          }
 
        });
      });
        
  
});
    
             function AbrirModalUpdateUsuario(idUsuario){                      
       // $('#NombreUsuario').html( $('#L'+idUsuario).text());

             
  
             
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
                                        
                                        $('#NombreP').val(nombre);
                                        $('#ApellidosP').val(apellidos);
                                        $('#CorreoP').val(correo);
                                        $('#contra1P').val(contrasena);
                                        $('#contra2P').val(contrasena);
                                        $('#tipoP').val(tipo);
                                        $('#socioP').val(socio);
                                        $('#TelefonoP').val(telefono);
                                        $('#comprobante_pagoP').val(comprobante);
                                         $('#membresiaP').val(membresia);
                                    
                                       
                                       
                                    }
                                }
                            });  
             }
             
        
            function UpdateUsuarioP(idUsuario){
      
           var idUsuarioP =<?php echo $idusuario?>;
      
        var nombre = false;
        var apellidos= false;
        var correo = false;
        var correo_valido = false;
        var contrasena1=false;
        var contrasena2=false;
        
        var telefono = false;
        var url ="procesos/proceso_editar_usuario.php";
            
              
          if($("#NombreP").val() != ''){
             nombre=true;
          }else{
           $("#NombreOKP").html("Campo requerido *");
          }
        
          if($("#ApellidosP").val() != ''){
             apellidos=true;
          }else{
           $("#ApellidosOKP").html("Campo requerido *");
          }
            
          if($("#CorreoP").val() != ''){
             correo=true;
              
              re=/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/
	       if(!re.exec($("#CorreoP").val())){
		//  alert('email no valido');
                 $("#CorreoOKP").html("Correo no válido");
           }
              else {
                 // alert('email valido');
                  //  $("#CorreoOK").html("email valido");
                  correo_valido = true;
                  
	       }
       


              
          }else{
           $("#CorreoOKP").html("Campo requerido *");
          }
            
            
            
         if($("#contra1P").val() != ''){
             contrasena1=true;
          }else{
           $("#contra1OKP").html("Campo requerido *");
          }
            
         if($("#contra2P").val() != ''){
             contrasena2=true;
          }else{
           $("#contra2OKP").html("Campo requerido *");
          }
        
               
         if($("#TelefonoP").val() != ''){
             telefono=true;
          }else{
           $("#TelefonoOKP").html("Campo requerido *");
          }
            
              if(nombre == true && apellidos == true && correo==true && correo_valido == true && contrasena1== true && contrasena2 == true){
        // alert("comparar las contraseñas");
                  if($("#contra1P").val() == $("#contra2P").val() ){
                     
                      document.getElementById('btn_update1P').disabled=true;
                   
                      var nombre = $('#NombreP').val();
                      var apellidos = $('#ApellidosP').val();
                      var correo = $('#CorreoP').val();
                      var contrasena = $('#contra1P').val();
                      var tipo = $('#tipoP').val();
                      var socio = $('#socioP').val();
                      var telefono = $('#TelefonoP').val();
                      var comprobantepago = $('#comprobante_pagoP').val();
                      var membresia = $('#membresiaP').val();
                      

                data={
                    "idusuario":idUsuarioP,
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
            
                        $('#btnUpdate1P').attr("disabled");
                       $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: "json",
                                data: data,
                                success: function (data) {
                                
                                    if (data != undefined) {
                                        if (data.respuesta == "1") {
                                            window.location.href = 'perfil.php';
                                         
                                        }
                                        else if(data.respuesta == "0"){
                                      alert('Hubo un error intente nuevamente');
                                        }
                                    }
                                }
                            });
                     }else{
                 
                            $("#contra1OKP").html("Las contraseñas no coinciden");
                            $("#contra2OKP").html("Las contraseñas no coinciden");
                     }
           }
        }

             
        
</script>
<?php
include("footer.php");
?>