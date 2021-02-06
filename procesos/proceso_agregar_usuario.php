<?php

//echo $fecha_Y_hora_ini=$fecha_ini." ".$hora_ini;

require("../conexion.php");


$idUsuario=$_POST['idusuario'];
$nombre=utf8_decode($_POST['Nombre']);
$apellidos=$_POST['Apellidos'];
$correo=$_POST['correo'];
$contrasena=$_POST['contrasena'];
$tipo=$_POST['tipo'];
$socio=$_POST['socio'];
$telefono=$_POST['telefono'];
$comprobantepago=$_POST['comprobantepago'];
$membresia=$_POST['membresia'];




$sql="INSERT INTO `usuarios` (`idusuario`, `nombre`, `apellidos`, `correo`, `contrasena`, `tipo`,`socio` ,`telefono`, `comprobante_deposito`,`membresia`) VALUES (NULL, '$nombre', '$apellidos', '$correo', '$contrasena', '$tipo',$socio,'$telefono', $comprobantepago,'$membresia');";


$resultado=$conexion->query($sql);
 
function MandarCorreo(){
    
global $nombre;
global $apellidos;
global $correo;
global $contrasena;


require '../PHPMailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
$mail->IsSMTP();

//Configuracion servidor mail
$mail->From = "somaspresidencia@gmail.com"; //remitente
$mail->FromName = "CONGRESO SOMAS 2021"; //remitente
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls'; //seguridad
$mail->Host = "smtp.gmail.com"; // servidor smtp
$mail->Port = 587; //puerto
$mail->Username ='somaspresidencia@gmail.com'; //nombre usuario
$mail->Password = 'Somas2021*'; //contraseña
$mail->IsHTML(true);
//Agregar destinatario
$mail->AddAddress($correo);
$mail->Subject = 'Registro completado';
$mail->Body = 
    '
<html>
    <head>
    </head>
<body>
 <div style="text-align: center;">
    <img src="img/encabezado.PNG" style="width: 50%">
       <h1>Bienvenido (a) ' . $nombre . ' '. $apellidos .' </h1>
     <h2>Tu registro a sido completado</h2>
     <h4>Tus credenciales para acceder a la plataforma son las siguientes</h4>
     <h5>Te sugerimos cambiarla por cuestiones desegurida en la sección de MI PERFIL</5>
   usuario:' .$correo .'<br> password:' .$contrasena .'
     <h3><a href="">Accede a la plataforma</a></h3>
         <img src="img/pie.PNG" style="width: 50%">
    </div>
  
    
</body>
</html>     
    ';
$mail->Send();
}

if($resultado){
    if($comprobantepago ==1){
     MandarCorreo();
    }
     $data['respuesta'] = '1';
      echo json_encode($data);
    
}else{
     $data['respuesta'] = '0';
      echo json_encode($data);
}

?>