<?php 

// NO envia el email colocando el from

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers = "FROM: TodoFacil <contacto@todofacil.mx>\r\n";

//$headers .= "From: TodoFacil <contacto@todofacil.mx>" . "\r\n";    

mail("meneses.rigoberto@gmail.com","mi asunto1" , "mi mensaje1", $headers);


/*
// Si envia el email sin colocar el FROM

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

mail("meneses.rigoberto@gmail.com","mi asunto2" , "mi mensaje2", $headers);
*/


?>