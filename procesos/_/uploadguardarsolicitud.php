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


(isset($_POST['titulo'])) ? $titulo=$_POST['titulo'] : $titulo='';
(isset($_POST['ubicacion'])) ? $ubicacion=$_POST['ubicacion'] : $ubicacion='';
(isset($_POST['descripcion'])) ? $descripcion=$_POST['descripcion'] : $descripcion='';
(isset($_POST['categ_id'])) ? $categ_id=$_POST['categ_id'] : $categ_id='';
(isset($_POST['subcateg_id'])) ? $subcateg_id=$_POST['subcateg_id'] : $subcateg_id='';

(isset($_POST['ubicacion'])) ? $ubicacion=$_POST['ubicacion'] : $ubicacion='';
(isset($_POST['infolatitud'])) ? $infolatitud=$_POST['infolatitud'] : $infolatitud='';
(isset($_POST['infolongitud'])) ? $infolongitud=$_POST['infolongitud'] : $infolongitud='';
(isset($_POST['infocountry'])) ? $infocountry=$_POST['infocountry'] : $infocountry='';
(isset($_POST['infodir'])) ? $infodir=$_POST['infodir'] : $infodir='';
(isset($_POST['infocalle'])) ? $infocalle=$_POST['infocalle'] : $infocalle='';
(isset($_POST['infocodpostal'])) ? $infocodpostal=$_POST['infocodpostal'] : $infocodpostal='';
(isset($_POST['infosublocalidad'])) ? $infosublocalidad=$_POST['infosublocalidad'] : $infosublocalidad='';
(isset($_POST['inforegion'])) ? $inforegion=$_POST['inforegion'] : $inforegion='';
(isset($_POST['infociudad'])) ? $infociudad=$_POST['infociudad'] : $infociudad='';
(isset($_POST['infociudad2'])) ? $infociudad2=$_POST['infociudad2'] : $infociudad2='';

$ubicacion = utf8_decode($ubicacion);
$infolatitud = utf8_decode($infolatitud);
$infolongitud = utf8_decode($infolongitud);
$infocountry = utf8_decode($infocountry);
$infodir = utf8_decode($infodir);
$infocalle = utf8_decode($infocalle);
$infocodpostal = utf8_decode($infocodpostal);
$infosublocalidad = utf8_decode($infosublocalidad);
$inforegion = utf8_decode($inforegion);
$infociudad = utf8_decode($infociudad);
$infociudad2 = utf8_decode($infociudad2);


$titulo = utf8_decode($titulo);
$descripcion = utf8_decode($descripcion);



session_start();
$iniuser = $_COOKIE["iniuser"];


$fechaactual = formatoFechaHoraBd();

$fechafinrecibir = date('Y-m-d H:i:s', strtotime("$fechaactual + 1 day"));

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

	$arrresultado = $GLOBALS[conexion]->doSelect("max(solicitudserv_codigoint) as solicitudserv_codigoint","solicitudservicio",
		"cuenta_id = '$SistemaCuentaId' and compania_id='$SistemaCompaniaId'");
	foreach($arrresultado as $i=>$valor){
		$solicitudserv_codigoint = utf8_encode($valor["solicitudserv_codigoint"]);
	}

	if ($solicitudserv_codigoint==""){$solicitudserv_codigoint = 0;}
	$solicitudserv_codigoint = $solicitudserv_codigoint + 1;


	if ($infolongitud=="" || $infolatitud=="" || $infolongitud=="undefined" || $infolatitud=="undefined" || $infolongitud=="0" || $infolatitud=="0" ){
		echo "<script language='JavaScript'>alert('Por favor busca su direccion en el listado de Google');</script>";
		echo "<script language='JavaScript'>window.parent.window.location = 'solicitar-paso2?c=$categ_id&s=$subcateg_id'; </script>";
		return false;
	}

	if ($iniuser==""){$iniuser="0";}

	$obtenerCodigoLista = 1;
	$obtenerTipoLista = 43;
	$estatusid = ObtenerIdLista($obtenerCodigoLista, $obtenerTipoLista);

	$resultado = $conexion->doInsert("
		solicitudservicio
		(
			usuario_id, solicitudserv_titulo, solicitudserv_descrip, solicitudserv_latitud, 
			solicitudserv_longitud, solicitudserv_dircompleta, solicitudserv_infodir, solicitudserv_infocalle, 
			solicitudserv_infocodpostal, solicitudserv_infociudad, solicitudserv_infociudad2, 
			solicitudserv_infosublocalidad, solicitudserv_inforegion, solicitudserv_infocountry, 
			cuenta_id, compania_id, solicitudserv_activo, solicitudserv_eliminado, solicitudserv_fechareg, usuario_idreg, 
			solicitudserv_codigo, solicitudserv_codigoint, l_estatus_id,
			l_categ_id, l_subcateg_id, solicitudserv_leidos, solicitudserv_contactados, solicitudserv_notif, 
			solicitudserv_fechafinrecibir
		)
		",
		" 
    '$iniuser', '$titulo', '$descripcion', '$infolatitud',
    '$infolongitud', '$ubicacion', '$ubicacion', '$infocalle',
    '$infocodpostal', '$infociudad', '$infociudad2', 
    '$infosublocalidad', '$inforegion', '$infocountry', 
    '$SistemaCuentaId', '$SistemaCompaniaId', '1', '0', '$fechaactual','$iniuser',
    '$solicitudserv_codigoint', '$solicitudserv_codigoint', '$estatusid',
    '$categ_id', '$subcateg_id','0','0', '0',
    '$fechafinrecibir'
    ");
  
  $arrresultado2 = $conexion->doSelect("max(solicitudserv_id) as solicitudserv_id","solicitudservicio");
  if (count($arrresultado2)>0){
	  foreach($arrresultado2 as $i=>$valor){
		  $solicitudserv_id = strtoupper($valor["solicitudserv_id"]);
	  }




  }     
           
     
}

//echo "<script language='JavaScript'>alert('Sol Registrado Correctamente, en breve se confirmará el mismo y será notificado cuando se haya aprobado');</script>";

if ($iniuser=="" || $iniuser=="0"){
	echo "<script language='JavaScript'>window.parent.window.location = 'solicitar-paso3?id=$solicitudserv_id'; </script>";	
}else{

	// Envio notificacion de nueva solicitud
	InformarNuevaSolicitud($solicitudserv_id);

	echo "<script language='JavaScript'>window.parent.window.location = 'solicitar-pasofin?id=$solicitudserv_id'; </script>";
}


?>