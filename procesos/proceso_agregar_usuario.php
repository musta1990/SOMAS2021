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




$sql="INSERT INTO `usuarios` (`idusuario`, `nombre`, `apellidos`, `correo`, `contrasena`, `tipo`,`socio` ,`telefono`, `comprobante_deposito`) VALUES (NULL, '$nombre', '$apellidos', '$correo', '$contrasena', '$tipo',$socio,'$telefono', $comprobantepago);";


$resultado=$conexion->query($sql);

//echo $sql;
 
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