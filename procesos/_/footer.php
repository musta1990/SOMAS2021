<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/mysqlclass.php';
include_once 'lib/funciones.php';
include_once 'lib/config.php';

$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

session_start();
$iniuser = $_COOKIE["iniuser"];
$login = $_COOKIE["login"];
$perfil = $_COOKIE["perfil"];


$conexion = new ConexionBd();
$arrresultado = ObtenerDatosCompania($SistemaCuentaId, $SistemaCompaniaId);
foreach($arrresultado as $i=>$valor){

    $compania_id = utf8_encode($valor["compania_id"]);
    $compania_nombre = utf8_encode($valor["compania_nombre"]);
    $compania_img = utf8_encode($valor["compania_img"]);
    $compania_imgicono = utf8_encode($valor["compania_imgicono"]);
    $compania_urlweb = utf8_encode($valor["compania_urlweb"]);
    $compania_whatsapp = utf8_encode($valor["compania_whatsapp"]);
    $compania_email = utf8_encode($valor["compania_email"]);


    $urlcompaniaimg = $UrlFiles."admin/arch/$compania_img";
    $urlcompaniaimgicono = $UrlFiles."admin/arch/$compania_imgicono";
}


$arrresultado = $conexion->doSelect("tipolista.tipolista_id, tipolista_nombre, tipolista_descrip,
  lista.lista_id, lista_cod,
  lista.lista_nombre, listaredsocial_nombre, listaredsocial_url, listaredsocial_id

",
  "
  tipolista
    inner join lista on lista.tipolista_id = tipolista.tipolista_id
    left join listacuenta on listacuenta.lista_id = lista.lista_id
    and listacuenta_activo = '1' and listacuenta.tipolista_id = '59'    
    inner join listaredsocial on listaredsocial.listacuenta_id = listacuenta.listacuenta_id

  ",
  "tipolista_activo = '1' and tipolista.tipolista_id = '59' and listacuenta.cuenta_id = '$SistemaCuentaId' and listacuenta.compania_id = '$SistemaCompaniaId' ", null, "lista_orden asc");


foreach($arrresultado as $i=>$valor){
    
  $tipolista_id = utf8_encode($valor["tipolista_id"]);
  $tipolista_nombre = utf8_encode($valor["tipolista_nombre"]);
  $tipolista_descrip = utf8_encode($valor["tipolista_descrip"]);  
  $lista_id = utf8_encode($valor["lista_id"]);
  $lista_nombre = utf8_encode($valor["lista_nombre"]);
  $lista_cod = utf8_encode($valor["lista_cod"]);
  $listaredsocial_nombre = utf8_encode($valor["listaredsocial_nombre"]);
  $listaredsocial_url = utf8_encode($valor["listaredsocial_url"]);
  $listaredsocial_id = utf8_encode($valor["listaredsocial_id"]);
  $nombrered = strtolower($lista_nombre);

  if ($lista_cod=="1"){
    $nombrefacebook = $listaredsocial_nombre;
    $linkfacebook = $listaredsocial_url;
  }

  if ($lista_cod=="2"){
    $nombreinstagram = $listaredsocial_nombre;
    $linkinstagram = $listaredsocial_url;
  }

}


?>

<footer class="footer section section-sm" style="margin-top: 40px">

<div class="container">
  <div class="row">
    <div class="col-lg-3 col-md-7 ">        
      <div class="block about">          
        <img src="<?php echo $urlcompaniaimg;?>" alt="<?php echo $compania_nombre;?>" class="img-responsive" style="height: 80px" />                          
          <p class="alt-color">
            
          </p>
       </div>

    </div>      
    <div class="col-lg-3 ">
      <div class="block">
        <h4>Nosotros</h4>
        <ul>
          <li>
            <a href="quienes-somos">¿Quienes Somos?</a>
          </li>                             
          <li>
            <a href="como-funciona">¿Cómo Funciona?</a>
          </li>           
          <li>
            <a href="contacto">Contacto</a>
          </li>                    
        </ul>
      </div>
    </div>          
    <div class="col-lg-3  ">
      <div class="block">
        <h4>Info</h4>
        <ul>                  
          <li>
            <a href="registro">Registro</a>
          </li> 
          <li>
            <a href="planes">Planes</a>
          </li>
          <li>
            <a href="blog">Consejos</a>
          </li> 
          <li>
            <a href="preguntas-frecuentes">Preguntas Frecuentes</a>
          </li>           
        </ul>
      </div>
    </div>          
    <div class="col-lg-3 col-md-3">
      <div class="block">
        <h4>Info de Contacto</h4>
        <ul>
          <li>
            <a href="https://api.whatsapp.com/send?phone=<?php echo $compania_whatsapp;?>">
              <img src="images/whatsapp.png" style="height:30px;" alt="Escribenos al WhatsApp - <?php echo $compania_nombre;?>"  title="Escribenos al WhatsApp - <?php echo $compania_nombre;?>" />
              +<?php echo $compania_whatsapp;?>
            </a>
          </li>
          <li>
            <a href="<?php echo $linkfacebook;?>" target="_blank">
              <img src="images/facebook2.png" style="height:30px;" alt="Facebook <?php echo $nombrefacebook;?>" title="Instagram Facebook <?php echo $nombrefacebook;?>" />
              <?php echo $nombrefacebook;?>
            </a>
          </li>
          <li>
            <a href="<?php echo $linkinstagram;?>" target="_blank">
              <img src="images/instagram2.png" style="height:30px;" alt="Instagram <?php echo $nombreinstagram;?>" title="Instagram <?php echo $nombreinstagram;?>" />
              @<?php echo $nombreinstagram;?>
            </a>
          </li>

        </ul>
      </div>
    </div>
  </div>
</div>

</footer>
<footer class="footer-bottom">
<div class="container">
  <div class="row">
    <div class="col-sm-6 col-12">        
      <div class="copyright">
        <p>Todos los Derechos Reservados a <?php echo $compania_nombre;?> 2020 </p>
      </div>
    </div>
    <div class="col-sm-6 col-12">        
      <ul class="social-media-icons text-right">
        <li>
          <a href="terminos-y-condiciones">Términos y Condiciones</a>
        </li>
        <li>
          <a href="politicas-de-privacidad">Políticas de Privacidad</a>
        </li>          
      </ul>
    </div>
  </div>
</div>
<div class="top-to">
  <a id="top" class="" href="#">
    <i class="fa fa-angle-up"></i>
  </a>
</div>
</footer>