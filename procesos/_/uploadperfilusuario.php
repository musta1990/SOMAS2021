<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/mysqlclass.php';
include_once 'lib/funciones.php';
include_once 'lib/phpmailer/libemail.php';
include_once 'lib/config.php';

$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

function getExtension($str) {

	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}


(isset($_POST['usuario_nombre'])) ? $usuario_nombre=$_POST['usuario_nombre'] : $usuario_nombre='';
(isset($_POST['usuario_apellido'])) ? $usuario_apellido=$_POST['usuario_apellido'] : $usuario_apellido='';
(isset($_POST['usuario_email'])) ? $usuario_email=$_POST['usuario_email'] : $usuario_email='';
(isset($_POST['usuario_telf'])) ? $usuario_telf=$_POST['usuario_telf'] : $usuario_telf='';
(isset($_POST['usuario_alias'])) ? $usuario_alias=$_POST['usuario_alias'] : $usuario_alias='';

(isset($_POST['usuario_clave'])) ? $usuario_clave=$_POST['usuario_clave'] : $usuario_clave='';
(isset($_POST['usuario_clave2'])) ? $usuario_clave2=$_POST['usuario_clave2'] : $usuario_clave2='';
(isset($_POST['tiporegistro'])) ? $tiporegistro=$_POST['tiporegistro'] : $tiporegistro='';


if ($usuario_clave!=$usuario_clave2){
  echo "<script language='JavaScript'>alert('Error: Las claves no coinciden, por favor verifique');</script>";
  exit();
}

$usuario_clave = utf8_decode($usuario_clave);
$usuario_nombre = utf8_decode($usuario_nombre);
$usuario_apellido = utf8_decode($usuario_apellido);
$usuario_email = utf8_decode($usuario_email);
$usuario_telf = utf8_decode($usuario_telf);

session_start();
$iniuser = $_COOKIE["iniuser"];


$fechaactual = formatoFechaHoraBd();

$conexion = new ConexionBd();

	$temp = explode(".", $_FILES["file1"]["name"]);
	$extension = end($temp);


for ($n=1; $n<=1; $n++){
	
	$temp = explode(".", $_FILES["file$n"]["name"]);
	$extension = end($temp);
	//
	//$temp = explode(".", $_FILES["file"]["name"]);
	

	if ($extension!="") {
		
		if ($iniuser  =="" || $iniuser  =="0")
		{
			echo "<script language='JavaScript'>alert('Error: Debe estar conectado');</script>";
			return false;
		}
			
			
		if (($_FILES["file$n"]["error"] > 0))
		{
			echo "<script language='JavaScript'>alert('Error 113 cargando el archivo, intente nuevamente. Codigo 113');</script>";
		}
		else
		{		
	
			define ("MAX_SIZE","50000");
	
			$errors=0;
	
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				echo 2;
				$image =$_FILES["file$n"]["name"];
				$uploadedfile = $_FILES['file$n']['tmp_name'];
		
			}
			//If no errors registred, print the success message
	
			if(isset($_POST['Submit']) && !$errors)
			{
				// mysql_query("update SQL statement ");
				echo "Image Uploaded Successfully!";
			}

			$tamano = $_FILES["file$n"]["size"] / 1024;
			$nombrearchivo = utf8_decode($_FILES["file$n"]["name"]);				
			
			echo "<br>";
				
			if ($tamano >= "0" ){
				
				echo "ext:".$extension;echo "<br>";echo "<br>";
				
				//$nombrearchivo = str_replace("%.$extension%", "", $nombrearchivo);
				$nombrearchivo = preg_replace("/\.[^.]+$/", "", $nombrearchivo);
				
				echo "nombre archivo:".$nombrearchivo;
				
				echo "<br>";echo "<br>";
				
				$nombrereal = $nombrearchivo.".".$extension;
				$nombrecolocar = uniqid();	
				$nombrecolocar = $nombrecolocar.".".$extension;
				
				$urlarchivo = "arch/".$nombrecolocar;				
				unlink($urlarchivo);
				
				

						
		
				$filename1 = $urlarchivo;
					
				$a = 1;
				$resultado = move_uploaded_file($_FILES["file$n"]["tmp_name"],$urlarchivo);
				//imagejpeg($tmp1,$filename1,100);
				if($a == 1){
					
					//$resultado = $conexion->doUpdate("repuesto", "repuestousuario_img = '1'","usuario_id='$usuario_id'");
					
					//echo "<script language='JavaScript'>alert('Cargado Correctamente');</script>";
					//echo "<script language='JavaScript'>window.parent.window.location = 'modificarperfil.php'; </script>";
				}
				else{
					echo "<script language='JavaScript'>alert('Error cargando el producto, por favor intente nuevamente. Codigo 114');</script>";
					//echo "<script language='JavaScript'>window.parent.window.location.reload(); </script>";
				}
			}
		}
		
	}


  if ($nombrecolocar!=""){
	$nombrecolocar = "usuario_img ='$nombrecolocar',";
}

	  $resultado = $conexion->doUpdate("usuario", "
		  usuario_nombre ='$usuario_nombre',
	      usuario_alias ='$usuario_alias',
	      usuario_apellido ='$usuario_apellido',
	      usuario_clave ='$usuario_clave',
	      $nombrecolocar
	      usuario_email ='$usuario_email',	      
	      usuario_telf ='$usuario_telf'
		  ",
		  "usuario_id='$iniuser'");

	}
  

echo "<script language='JavaScript'>alert('Perfil Guardado Correctamente');</script>";
echo "<script language='JavaScript'>window.parent.window.location = 'panel-perfil'; </script>";

?>