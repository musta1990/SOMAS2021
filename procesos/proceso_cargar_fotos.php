<?php
require("../conexion.php");


 


$id_accion=$_GET["idalbum"];


//var_dump($_FILES);

 $cantidad =count($_FILES['foto']["tmp_name"]);

for($x = 0; $x<$cantidad;$x++){
    
$carpeta="../fotos_concurso/";
opendir($carpeta);
$destino=$carpeta.$_FILES['foto']['name'][$x];
copy($_FILES['foto']['tmp_name'][$x],$destino);
$nombre=$_FILES['foto']['name'][$x];
    
	$sql="INSERT INTO `fotos`(`idfoto`,`idalbum`, `url`) VALUES (NULL, '$id_accion','fotos_concurso/$nombre')";
	$result=$conexion->query($sql);
	
	if($result){
		header("location:../cargar_fotos.php?idalbum=$id_accion");
		
	}else{
		
	}
}

?>
