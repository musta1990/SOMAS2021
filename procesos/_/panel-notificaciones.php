<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/base.php';
include_once 'lib/mysqlclass.php';
include_once 'lib/config.php';
include_once 'lib/funciones.php';

$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

(isset($_GET['r'])) ? $getreenviaremail_id=$_GET['r'] :$getreenviaremail_id='';
(isset($_GET['i'])) ? $notif_getinfo=$_GET['i'] :$notif_getinfo='';

$base = base();

session_start();
$iniuser = $_COOKIE['iniuser'];
$login = $_COOKIE['login'];
$perfil = $_COOKIE['perfil'];

if ($iniuser==""){
  echo "<script language='JavaScript'>window.location = 'iniciar-sesion?i=1'; </script>";
  exit();
}

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



$arrresultado = $conexion->doSelect("usuario.usuario_id, usuario_nombre, 
usuario_img,DATE_FORMAT(usuario_fechareg,'%d/%m/%Y') as usuario_fechareg, 
 l_tipousuarioserv_id, tipousuarioservicio.lista_nombre as tipousuario

",
"usuario
    left join lista tipousuarioservicio on tipousuarioservicio.lista_id = usuario.l_tipousuarioserv_id 
",
"usuario_activo = '1' and usuario.usuario_id = '$iniuser'");
foreach($arrresultado as $i=>$valor){
    $notif_l_tipousuarioserv_id = utf8_encode($valor["l_tipousuarioserv_id"]);    
}



$arrresultado = $conexion->doSelect("
    requisito.requisito_id, requisito.l_requisitolista_id, requisito_descrip, requisito.l_tipoarchivo_id, requisito_arch, 
    requisito_archnombre, requisito_cantarchivos, requisito.cuenta_id, requisito.compania_id,
    requisito_activo, requisito_eliminado, requisito_fechareg, 
    requisito.usuario_idreg, requisito.l_estatus_id, requisito.usuario_id,
    usuario.usuario_id, usuario.usuario_codigo, usuario.usuario_email, usuario.usuario_nombre, usuario.usuario_apellido, 
    usuario.usuario_telf, usuario.usuario_activo, usuario.usuario_eliminado, 
    usuario.usuario_documento, usuario.usuario_img, usuario.perfil_id, 

    cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
    cuenta.usuario_apellido as cuenta_apellido, compania_nombre, 
    listarequisito.lista_id as requisitolista_id,
    listarequisito.lista_nombre as requisitolista_nombre,
    estatus.lista_nombre as estatus_nombre,
    tipoarchivo.lista_nombre as tipoarchivo_nombre,
    tipoarchivo.lista_img as tipoarchivo_img

    ",
    "lista listarequisito
        inner join listarequisitotipousuarioserv on listarequisitotipousuarioserv.l_requisitolista_id = listarequisito.lista_id
        left join requisito on requisito.l_requisitolista_id = listarequisito.lista_id and requisito.usuario_id = '$iniuser' and requisito.cuenta_id = '$SistemaCuentaId' and requisito.compania_id = '$SistemaCompaniaId' 
        left join lista tipoarchivo on tipoarchivo.lista_id = requisito.l_tipoarchivo_id
        left join lista estatus on estatus.lista_id = requisito.l_estatus_id
        left join usuario on usuario.usuario_id = requisito.usuario_id
        left join usuario cuenta on cuenta.usuario_id = usuario.cuenta_id
        left join compania on compania.compania_id = usuario.compania_id

    ",
    "listarequisito.lista_activo = '1' and listarequisitotipousuarioserv.l_tipousuarioserv_id = '$notif_l_tipousuarioserv_id' and listarequisito.tipolista_id  ='49' ", null, "listarequisito.lista_orden asc");
foreach($arrresultado as $i=>$valor){

    $notif_requisito_id = utf8_encode($valor["requisito_id"]);
    $notif_l_requisitolista_id = utf8_encode($valor["l_requisitolista_id"]);
    $notif_requisito_descrip = utf8_encode($valor["requisito_descrip"]);
    $notif_l_tipoarchivo_id = utf8_encode($valor["l_tipoarchivo_id"]);
    $notif_requisito_arch = utf8_encode($valor["requisito_arch"]);
    $notif_requisito_archnombre = utf8_encode($valor["requisito_archnombre"]);
    $notif_requisito_cantarchivos = utf8_encode($valor["requisito_cantarchivos"]);
    $notif_t_cuenta_id = utf8_encode($valor["cuenta_id"]);
    $notif_t_compania_id = utf8_encode($valor["compania_id"]);
    $notif_requisito_activo = utf8_encode($valor["requisito_activo"]);
    $notif_requisito_fechareg = utf8_encode($valor["requisito_fechareg"]);
    $notif_l_estatus_id = utf8_encode($valor["l_estatus_id"]);
    $notif_usuario_id = utf8_encode($valor["usuario_id"]);
    $notif_usuario_codigo = utf8_encode($valor["usuario_codigo"]);
    $notif_usuario_email = utf8_encode($valor["usuario_email"]);
    
    $notif_requisitolista_id = utf8_encode($valor["requisitolista_id"]);
    $notif_requisitolista_nombre = utf8_encode($valor["requisitolista_nombre"]);
    $notif_estatus_nombre = utf8_encode($valor["estatus_nombre"]);
    $notif_tipoarchivo_nombre = utf8_encode($valor["tipoarchivo_nombre"]);
    $notif_tipoarchivo_img = utf8_encode($valor["tipoarchivo_img"]);

    if ($notif_requisito_id==""){ // Si esta vacio es porque no se ha cargado
    
        if ($notif_requisitolista_id=="162"){
             $listanotificaciones .= "
              <div class='alert alert-warning' style='text-align: left; font-weight: bold'>
                  <a style='color: #000' href='panelreenviar-email'>
                      <i class='fa fa-exclamation-circle'></i> Por favor confirme su email (reenviar confirmación)
                  </a>
              </div>     ";  

        }else{
            $listanotificaciones .= "
              <div class='alert alert-warning' style='text-align: left; font-weight: bold'>
                  <a style='color: #000' href='panel-cargarrequisito?id=$notif_requisitolista_id'>
                      <i class='fa fa-exclamation-circle'></i> $notif_requisitolista_nombre <span style='font-weight: normal'>es requerido para habilitarse como Prestador de Servicio</span> $requisito_id
                  </a>
              </div>     ";
        }
    }

}

if ($notif_getinfo=="1"){

    $listanotificaciones="";
}


?>

<?php echo $listanotificaciones; ?>