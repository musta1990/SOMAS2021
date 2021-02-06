<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","1");
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


	  
(isset($_POST['usuarioinfoserv_resumen'])) ? $usuarioinfoserv_resumen=$_POST['usuarioinfoserv_resumen'] : $usuarioinfoserv_resumen='';
(isset($_POST['usuarioinfoserv_infodir'])) ? $usuarioinfoserv_infodir=$_POST['usuarioinfoserv_infodir'] : $usuarioinfoserv_infodir='';
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
(isset($_POST['rangokm'])) ? $rangokm=$_POST['rangokm'] : $rangokm='';


$usuarioinfoserv_resumen = utf8_decode($usuarioinfoserv_resumen);
$usuarioinfoserv_infodir = utf8_decode($usuarioinfoserv_infodir);
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

if ($rangokm==""){$rangokm=152;}

$fechaactual = formatoFechaHoraBd();

$conexion = new ConexionBd();

if ($infolongitud=="" || $infolatitud=="" || $infolongitud=="undefined" || $infolatitud=="undefined" || $infolongitud=="0" || $infolatitud=="0" ){
	echo "<script language='JavaScript'>alert('Por favor busca su direccion en el listado de Google');</script>";
	echo "<script language='JavaScript'>window.parent.window.location = 'panelprestador-servicios'; </script>";
	return false;
}

$arrresultado = $conexion->doSelect("usuarioinfoserv_id
    ",
	"usuario
		inner join usuarioinfoservicio on usuario.usuario_id = usuarioinfoservicio.usuario_id
	",
	"usuario_eliminado = '0' and usuarioinfoserv_activo = '1' and usuario.usuario_id = '$_COOKIE[iniuser]' ");
foreach($arrresultado as $i=>$valor){
	$usuarioinfoserv_id = utf8_encode($valor["usuarioinfoserv_id"]);
}

if ($usuarioinfoserv_id==""){

	if ($nombrecolocar==""){
		$nombrecolocar = "0.jpg";
	}

	$resultado = $conexion->doInsert("
		usuarioinfoservicio
			(usuario_id, usuarioinfoserv_resumen, usuarioinfoserv_img, usuarioinfoserv_latitud, 
			usuarioinfoserv_longitud, usuarioinfoserv_dircompleta, usuarioinfoserv_infodir, 
			usuarioinfoserv_infocalle, usuarioinfoserv_infocodpostal, usuarioinfoserv_infociudad,
			usuarioinfoserv_infociudad2, usuarioinfoserv_infosublocalidad, usuarioinfoserv_inforegion,
			usuarioinfoserv_infocountry, cuenta_id, compania_id, usuarioinfoserv_activo, 
			usuarioinfoserv_eliminado, usuarioinfoserv_fechareg, usuario_idreg, l_rangokm_id) 

		",
		"'$_COOKIE[iniuser]', '$usuarioinfoserv_resumen', '$nombrecolocar', '$infolatitud', 
		'$infolongitud', '$usuarioinfoserv_infodir', '$infodir', 
		'$infocalle', '$infocodpostal', '$infociudad', 
		'$infociudad2', '$infosublocalidad', '$inforegion', 
		'$infocountry', '$SistemaCuentaId', '$SistemaCompaniaId', '1',
		'0', '$fechaactual', '$_COOKIE[iniuser]','$rangokm'");


}else{


	if ($nombrecolocar!=""){
		$nombrecolocar = "usuarioinfoserv_img ='$nombrecolocar',";
	}			

	$resultado = $conexion->doUpdate("usuarioinfoservicio", 
		"						
		$nombrecolocar
		usuarioinfoserv_resumen = '$usuarioinfoserv_resumen',
		usuarioinfoserv_latitud = '$infolatitud',
		usuarioinfoserv_longitud = '$infolongitud',
		usuarioinfoserv_dircompleta = '$usuarioinfoserv_infodir',
		usuarioinfoserv_infodir = '$usuarioinfoserv_infodir',
		usuarioinfoserv_infocalle = '$infocalle',
		usuarioinfoserv_infocodpostal = '$infocodpostal',
		usuarioinfoserv_infociudad = '$infociudad',
		usuarioinfoserv_infociudad2 = '$infociudad2',
		usuarioinfoserv_infosublocalidad = '$infosublocalidad',
		usuarioinfoserv_inforegion = '$inforegion',
		usuarioinfoserv_infocountry = '$infocountry',
		l_rangokm_id = '$rangokm',
		usuarioinfoserv_fechareg = '$fechaactual'				
		", 
		"usuario_id='$_COOKIE[iniuser]'");
	
}


echo "<script language='JavaScript'>alert('Perfil de Servicio Guardado Correctamente');</script>";
echo "<script language='JavaScript'>window.parent.window.location = 'panelprestador-servicios'; </script>";

?>