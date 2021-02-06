<?php
require("../conexion.php");


$correo = $_POST['correo'];
$contrasena =$_POST['contrasena'];


if(!empty($correo) && !empty($contrasena)){
$sql= "select * from usuarios where correo='$correo' AND contrasena='$contrasena' ";

$resultado=$conexion->query($sql);
    
    if($resultado->num_rows>0){
       $fila=$resultado->fetch_assoc();
      
        $tipo=$fila["tipo"];
         $comprobante_deposito=$fila["comprobante_deposito"];
        if($tipo=='A'){
             session_start();
        $_SESSION["loggedin"]=true;
        $_SESSION["nombre"]=$fila["nombre"];
        $_SESSION["idusuario"]=$fila["idusuario"];
        $_SESSION["tipo"]=$fila["tipo"];
        $_SESSION["socio"]=$fila["socio"];
        $_SESSION["start"]=time();
        $_SESSION["expire"]=$_SESSION["start"]+(12*3600);
              $data['respuesta'] = '1';
        echo json_encode($data);
            
        }else{
            if($comprobante_deposito == 0){
            $data['respuesta'] = '2';
            echo json_encode($data);
            }else if($comprobante_deposito == 1){
                 session_start();
        $_SESSION["loggedin"]=true;
        $_SESSION["nombre"]=$fila["nombre"];
        $_SESSION["idusuario"]=$fila["idusuario"];
        $_SESSION["tipo"]=$fila["tipo"];
        $_SESSION["socio"]=$fila["socio"];
        $_SESSION["start"]=time();
        $_SESSION["expire"]=$_SESSION["start"]+(12*3600);
        $data['respuesta'] = '3';
                 echo json_encode($data);
            }
       
        }
        
        }else{
              $data['respuesta'] = '0';
            echo json_encode($data);
    }
}else{
 
          $data['respuesta'] = 'Variables vacias';
}

?>