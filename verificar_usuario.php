<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true) {
    $now=time();
    if($now > $_SESSION["expire"]) {
        session_destroy();
        echo "Su sesión expiró. Por favor, inicie sesión nuevamente.";
        header("location:index.php");
    ?>
    <?php
    }
} else {
    echo "No tiene privilegios para acceder a este sitio. Por favor, primero inicie sesión";
   header("location:index.php");
    ?>

    <?php
    exit;
}
