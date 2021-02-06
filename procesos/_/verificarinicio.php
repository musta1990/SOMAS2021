<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/mysqlclass.php';

(isset($_GET['id'])) ? $tipo=$_GET['id'] :$tipo='';
(isset($_GET['i'])) ? $getinfo=$_GET['i'] :$getinfo='';
(isset($_GET['elem'])) ? $getelem=$_GET['elem'] :$getelem='';
(isset($_GET['sid'])) ? $getservicioid=$_GET['sid'] :$getservicioid='';
(isset($_GET['c'])) ? $mantenerconectado=$_GET['c'] :$mantenerconectado='';

date_default_timezone_set('America/Mexico_City');

session_start();
$iniuser = $_SESSION["iniuser"];
$login = $_SESSION["login"];
$perfil = $_SESSION["perfil"];


if ($mantenerconectado=="1"){
	
	setcookie("iniuser",$iniuser, time() + 86400); 
	setcookie("login",$login, time() + 86400);   
	setcookie("perfil",$perfil, time() + 86400); 	

	//setcookie('iniuser',$iniuser,time() + (60 * 60 * 24 * 365),'/',$_SERVER['HTTP_HOST']);
	//setcookie('login',$login,time() + (60 * 60 * 24 * 365),'/',$_SERVER['HTTP_HOST']);
	//setcookie('perfil',$perfil,time() + (60 * 60 * 24 * 365),'/',$_SERVER['HTTP_HOST']);

}else{

	setcookie("iniuser",$iniuser, time() + 3600); 
	setcookie("login",$login, time() + 3600);   
	setcookie("perfil",$perfil, time() + 3600); 	
		

}

if ($perfil=="2"){
	header("Location: admin/panel");	
}else if ($perfil=="83"){
	header("Location: admin/userbalance");	
}else if ($perfil=="82"){
	header("Location: admin/userbalance");	
}else{
	header("Location: admin/panel");	
}



//header("Location: https://www.gestiongo.com/admin/panel");


?>