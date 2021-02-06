<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/mysqlclass.php';
include_once 'lib/config.php';
include_once 'lib/funciones.php';

$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

$urlactual = geturlactual();

$conexion = new ConexionBd();
$arrresultado = ObtenerDatosCompania($SistemaCuentaId, $SistemaCompaniaId);
foreach($arrresultado as $i=>$valor){

    $compania_id = utf8_encode($valor["compania_id"]);
    $compania_nombre = utf8_encode($valor["compania_nombre"]);
    $compania_img = utf8_encode($valor["compania_img"]);
    $compania_imgicono = utf8_encode($valor["compania_imgicono"]);
    $compania_urlweb = utf8_encode($valor["compania_urlweb"]);

    $urlcompaniaimg = $UrlFiles."admin/arch/$compania_img";
    $urlcompaniaimgicono = $UrlFiles."admin/arch/$compania_imgicono";

    $titulopagina = "Inicio - ".$compania_nombre;
    $descripcionpagina = "Inicio - $compania_nombre ";

}


$arrresultado = $conexion->doSelect("
    pregunta.preg_id, pregunta.preg_nombre, pregunta.preg_respuesta, pregunta.preg_img, 
    pregunta.preg_videourl, pregunta.preg_videocodigo, pregunta.preg_url, 
    pregunta.l_tiposeccion_id, pregunta.cuenta_id, pregunta.compania_id, 
    pregunta.preg_activo, pregunta.preg_eliminado, 
    pregunta.preg_orden, pregunta.usuario_idreg,
    tiposeccion.lista_nombre as tiposeccion_nombre,
    tiposeccion.lista_img as tiposeccion_img,
    tiposeccion.lista_nombredos as tiposeccion_nombredos,
    tiposeccion.lista_icono as tiposeccion_icono,
    tiposeccion.lista_orden as tiposeccion_orden,
    DATE_FORMAT(pregunta.preg_fechareg,'%d/%m/%Y %H:%i:%s') as preg_fechareg,       
    cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
    cuenta.usuario_apellido as cuenta_apellido, compania_nombre
    ",
    "pregunta           
      inner join usuario cuenta on cuenta.usuario_id = pregunta.cuenta_id
        inner join compania on compania.compania_id = pregunta.compania_id        
        left join lista tiposeccion on tiposeccion.lista_id = pregunta.l_tiposeccion_id  
    ",
    "preg_activo = '1'  and pregunta.compania_id = '$SistemaCompaniaId' and pregunta.cuenta_id = '$SistemaCuentaId' ", null, "tiposeccion_orden, pregunta.l_tiposeccion_id desc");

  $cont = 0;
  foreach($arrresultado as $i=>$valor){

    $cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
    $cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
    $cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
    $cuenta = $cuenta_nombre." ".$cuenta_apellido." ";
    $compania_nombre = utf8_encode($valor["compania_nombre"]);

    $tiposeccion_orden = utf8_encode($valor["tiposeccion_orden"]);
    $tiposeccion_nombre = utf8_encode($valor["tiposeccion_nombre"]);
    $tiposeccion_nombredos = utf8_encode($valor["tiposeccion_nombredos"]);
    $tiposeccion_icono = utf8_encode($valor["tiposeccion_icono"]);
    $tiposeccion_img = utf8_encode($valor["tiposeccion_img"]);

    $preg_id = utf8_encode($valor["preg_id"]);
    $preg_nombre = utf8_encode($valor["preg_nombre"]);
    $preg_respuesta = utf8_encode($valor["preg_respuesta"]);
    $preg_img = utf8_encode($valor["preg_img"]);
    $preg_videourl = utf8_encode($valor["preg_videourl"]);
    $preg_videocodigo = utf8_encode($valor["preg_videocodigo"]);
    $preg_url = utf8_encode($valor["preg_url"]);
    $l_tiposeccion_id = utf8_encode($valor["l_tiposeccion_id"]);
    $preg_activo = utf8_encode($valor["preg_activo"]);
    $preg_fechareg = utf8_encode($valor["preg_fechareg"]);
    $preg_orden = utf8_encode($valor["preg_orden"]);    

    $t_cuenta_id = utf8_encode($valor["cuenta_id"]);
    $t_compania_id = utf8_encode($valor["compania_id"]);

    $usuario = $usuario_nombre." ".$usuario_apellido;

    $urlpf = $UrlFiles."admin/arch/$tiposeccion_img";
    
    /*
    if ($l_tiposeccion_idold!=$l_tiposeccion_id){
      $preguntasfrecuenteshtml .="
        <div class='row' style='margin-top:15px; margin-bottom: 20px'>
            <div class='col-lg-1'>                
                <img src='$urlpf' class='img-responsive' style='height: 80px' />
            </div>
            <div class='col-lg-10'>
                <div class='heading pb-2'>
                    <h3 style='font-size: 25px'>
                      $tiposeccion_nombre 
                    </h3>
                </div>               
            </div>
        </div>
      ";
    }

    */

    $preguntasfrecuenteshtml .="
      <div class='card'>
        <div class='card-header' id='heading$preg_id'>
          <h5 class='mb-0'>
            <button class='btn btn-link collapsed' data-toggle='collapse' data-target='#collapse$preg_id' aria-expanded='false' aria-controls='collapse$preg_id' style='text-align:left'>                    
              $preg_nombre
            </button>
          </h5>
        </div>
        <div id='collapse$preg_id' class='collapse' aria-labelledby='heading$preg_id' data-parent='#accordion'>
          <div class='card-body' style='text-align: justify'>
              $preg_respuesta
          </div>
        </div>
      </div>     
    ";


    $l_tiposeccion_idold = $l_tiposeccion_id;

    $cont = $cont+1;

}


//if (count($arrresultado)>0){
?>
  <section class="section  sectiontext" style="padding-top: 0px; margin-bottom: 40px">
      <div class="container">
          
          <div class="row">
              <div class="col-md-12">
                  <div id="accordion">
                     <?php echo $preguntasfrecuenteshtml; ?>
                  </div>
              </div>          
          </div>
          
          
      </div>
  </section>
<?php 
//  }
?>