<?php  

    session_start();

    echo "abc:".$_COOKIE["abc"];

    session_destroy();
    echo "<br>";

    echo "abc:".$_COOKIE["abc"];

  echo "<br>";
  echo "Elimino Cookie Valor: ".$_COOKIE["micookie"];
  echo "<br>";  
  setcookie("micookie","abc", time() - 86400);   ; 

  echo "<br>";
  echo "Leo Cookie Valor: ".$_COOKIE["micookie"];
  echo "<br>";  

  exit();


?>