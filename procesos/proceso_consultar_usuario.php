<?php
require("../conexion.php");

$idusuario=$_POST["idusuario"];


$sql="select * from usuarios where idusuario='$idusuario';";


$result=$conexion->query($sql);

  if($result->num_rows>0) {
                while($row=$result->fetch_assoc()) {
            $data['nombre'] = utf8_encode($row["nombre"]);
            $data['apellidos'] = utf8_encode($row["apellidos"]);
            $data['correo'] = utf8_encode($row["correo"]);
            $data['tipo'] = utf8_encode($row["tipo"]);
            $data['socio'] = utf8_encode($row["socio"]);        
            $data['contrasena'] = utf8_encode($row["contrasena"]);
            $data['telefono'] = utf8_encode($row["telefono"]);
            $data['comprobante_deposito'] = utf8_encode($row["comprobante_deposito"]);
            $data['membresia'] = utf8_encode($row["membresia"]);            

            }
        echo json_encode($data);
  }else{
        $data['respuesta'] = '0';
      echo json_encode($data);
  }


    


?>