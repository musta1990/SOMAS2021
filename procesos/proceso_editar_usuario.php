<?php
require("../conexion.php");
use PHPMailer\PHPMailer\PHPMailer;
require '../vendor/autoload.php';

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


$sql="update usuarios set nombre='$nombre',apellidos='$apellidos',correo='$correo',contrasena='$contrasena',tipo='$tipo',socio='$socio',telefono='$telefono',comprobante_deposito='$comprobantepago',membresia='$membresia' where idusuario=$idUsuario";


$sql;
$resultado=$conexion->query($sql);
 
function MandarCorreo(){
    
global $nombre;
global $apellidos;
global $correo;
global $contrasena;



$mail = new PHPMailer;
$mail->isSMTP();
//$mail->SMTPDebug = 2;
$mail->Host = 'smtp.hostinger.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'somasprecidencia@somascongreso2021.com';
$mail->Password = 'Somas2021*';
$mail->setFrom('somasprecidencia@somascongreso2021.com');
$mail->FromName = "CONGRESO SOMAS 2021";
//$mail->addReplyTo('alisabamustafa@gmail.com', 'Your Name');
$mail->IsHTML(true);
$mail->AddAddress($correo);
$mail->Subject = 'Registro completado';
$mail->msgHTML(file_get_contents('message.html'), __DIR__);
$mail->Body = '
<html>
    <head>
    </head>
<body>
    <div style="text-align: center;">
    <img src="http://www.somascongreso2021.com/img/encabezado.PNG" style="width: 45%">
    <h1>Bienvenido(a) ' . $nombre . ' '. $apellidos .' </h1>
    <h2>Tu registro ha sido completado</h2>
    <h4>Tus credenciales para acceder a la plataforma son las siguientes</h4>
    <h5>Te sugerimos cambiarla por cuestiones de seguridad en la sección de MI PERFIL</5>
    <p style="font-size:15px;">usuario: ' .$correo .'<br>password: ' .$contrasena .'</p>
    <h3><a href="">Accede a la plataforma</a></h3>
    <img src="http://www.somascongreso2021.com/img/pie.PNG" style="width: 50%">
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