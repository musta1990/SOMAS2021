<?php

 define("APPLICATION_PATH", realpath('.'));
 $paths = array(
    APPLICATION_PATH.'/controllers',
    APPLICATION_PATH.'/models',
    APPLICATION_PATH.'/views',
    APPLICATION_PATH.'/libs',
    APPLICATION_PATH.'/includes',
    get_include_path()
);

set_include_path(implode(PATH_SEPARATOR, $paths));

function __autoload($className){	
	
	$fileName = str_replace('\\','/', $className);

	if ($fileName=="login"){
		$fileName = "index";
	}

	require_once "$fileName.php";
	//require_once "index.php";
}

new Bootstrap();


/*

echo $_GET['url'];

exit();
echo 1;

print_r($_REQUEST);




$link = $_SERVER['PHP_SELF'];
$link_array = explode('/',$link);
$url = end($link_array);

echo $url;


exit();
include_once 'lib/config.php';

session_start();
$login=$_SESSION[login];
$imguser=$_SESSION[imguser];

(isset($_GET['s'])) ? $getsalir_id=$_GET['s'] :$getsalir_id='';

if ($getsalir_id==1){
	session_start();
	session_destroy();
	$info  = "
		    <div class='alert alert-success' style='text-align: center; font-weight: normal;'>
            <a style='color: #000; font-size: 14px; text-decoration: none;'>
                Cerrada la sesión correctamente
            </a><br>
        </div>
	";
}

$xajax->registerFunction('ingresarusuario');


$conexion = new ConexionBd();
session_start();
$_SESSION["logo"] = $logo;
$_SESSION["titulo"] = $titulo;	
$_SESSION["colorsistema"] = $colorsistema;
$_SESSION["letrasistema"] = $letrasistema;	

(isset($_GET['email'])) ? $email=$_GET['email'] :$email='';
(isset($_GET['generar'])) ? $generar=$_GET['generar'] :$generar='';


if ($email!=""){

  $info  = "
        <div class='alert alert-danger' style='text-align: center; font-weight: normal;'>
            <a style='color: #000; font-size: 14px; text-decoration: none;'>
                Correo $email no existe en el sistema, por favor verifique
            </a><br>
        </div>
  ";
	

	$arrresultado = $conexion->doSelect("
		usuario_id, usuario_nombre, usuario_apellido, usuario_clave, usuario_telf, usuario_email
	","usuario
	", " usuario_email = '$email' and usuario_activo = '1'");

	if (count($arrresultado)>0){
		foreach($arrresultado as $m=>$valor){

			$usuario_id = utf8_encode($valor["usuario_id"]);
			$usuario_nombre = utf8_encode($valor["usuario_nombre"]);
			$usuario_apellido = utf8_encode($valor["usuario_apellido"]);
			$usuario_clave = utf8_encode($valor["usuario_clave"]);
			$usuario_email = utf8_encode($valor["usuario_email"]);
      $usuario_telf = utf8_encode($valor["usuario_telf"]);

      if ($usuario_email!=""){$incluiremail = "<br>Email: ".$usuario_email;}
      if ($usuario_telf!=""){$incluirtef = "<br>Telefono: ".$usuario_telf;}			

			$uniqid = uniqid();

			//$resultado = $conexion->doUpdate("usuario", "usuario_resetclave = '$uniqid'", "usuario_id='$usuario_id'");

			$libemail = new LibEmail();

			$texto = "
			Recibimos su mensaje para recuperar su clave para ingresar a GestionGo 
			<br><br>	
			".$incluiremail."
      ".$incluirtef."			
			<br>Clave: ".$usuario_clave."
			<br><br>
			";
			$asunto = "Recuperación de Clave - GestionGo";

			$resultado = $libemail->enviarcorreo($email, $asunto, $texto, $titulo, $logo);
			$resultado = $libemail->enviarcorreo("meneses.rigoberto@gmail.com", $asunto, $texto, $titulo, $logo);


			$info = "
        <div class='alert alert-success' style='text-align: center; font-weight: normal;'>
            <a style='color: #000; font-size: 14px; text-decoration: none;'>
                Mensaje enviado correctamente a su email con las instrucciones para recuperar la clave
            </a><br>
        </div>
      ";

		}
	}	
}

else if ($generar!=""){

  $info  = "
        <div class='alert alert-danger' style='text-align: center; font-weight: normal;'>
            <a style='color: #000; font-size: 14px; text-decoration: none;'>
                Correo o Telefono $generar no existe en el sistema, por favor verifique
            </a><br>
        </div>
  ";

	$arrresultado = $conexion->doSelect("
		usuario_id, usuario_nombre, usuario_apellido, usuario_clave, usuario_telf, usuario_email
	","usuario
	", " (usuario_email = '$generar' or usuario_telf = '$generar') and usuario_activo = '1'");

	if (count($arrresultado)>0){
		foreach($arrresultado as $m=>$valor){

			$usuario_id = utf8_encode($valor["usuario_id"]);
			$usuario_nombre = utf8_encode($valor["usuario_nombre"]);
			$usuario_apellido = utf8_encode($valor["usuario_apellido"]);
			$usuario_clave = utf8_encode($valor["usuario_clave"]);
			$usuario_email = utf8_encode($valor["usuario_email"]);
			$usuario_telf = utf8_encode($valor["usuario_telf"]);

      if ($usuario_email!=""){$incluiremail = "<br>Email: ".$usuario_email;}
      if ($usuario_telf!=""){$incluirtef = "<br>Telefono: ".$usuario_telf;}     

			$uniqid = uniqid();

			//$resultado = $conexion->doUpdate("usuario", "usuario_resetclave = '$uniqid'", "usuario_id='$usuario_id'");

			$libemail = new LibEmail();

			$texto = "
			Recibimos su mensaje para asignar su clave para ingresar a GestionGo 
			<br><br>	
			".$incluiremail."
      ".$incluirtef."     
			<br>Clave: ".$usuario_clave."
			<br><br>
			";
			$asunto = "Asignar Clave - GestionGo";

			$resultado = $libemail->enviarcorreo($email, $asunto, $texto, $titulo, $logo);
			$resultado = $libemail->enviarcorreo("meneses.rigoberto@gmail.com", $asunto, $texto, $titulo, $logo);

      $info = "
        <div class='alert alert-success' style='text-align: center; font-weight: normal;'>
            <a style='color: #000; font-size: 14px; text-decoration: none;'>
                Mensaje enviado correctamente a su email con las instrucciones para asignar su clave
            </a><br>
        </div>
      ";			

		}
	}

	
}

require_once "views/index.php";

*/

?>