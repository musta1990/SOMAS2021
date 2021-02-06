<?php
require("../conexion.php");


 

$idUsuario =$_POST['idusuario'];
//$idUsuario = 3;



$sql="delete from usuarios where idusuario='$idUsuario'";
	$result=$conexion->query($sql);


if($result){
	//header("location:../home_admin.php");
          $data['respuesta'] = '1';
        echo json_encode($data);
}else{
		      $data['respuesta'] = '0';
        echo json_encode($data);
}

?>
