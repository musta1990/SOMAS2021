<?php
require("../conexion.php");


 

$idFoto =$_POST['idfoto'];
//$idUsuario = 3;



$sql="delete from fotos where idfoto='$idFoto'";
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
