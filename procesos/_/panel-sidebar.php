<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/base.php';
include_once 'lib/mysqlclass.php';
include_once 'lib/funciones.php';
include_once 'lib/config.php';

$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

$base = base();

session_start();
$iniuser = $_COOKIE['iniuser'];
$login = $_COOKIE['login'];
$perfil = $_COOKIE['perfil'];
$tipousuarioserv = $_COOKIE['tipousuarioserv'];


if ($iniuser==""){
  echo "<script language='JavaScript'>window.location = 'iniciar-sesion?i=1'; </script>";
  exit();
}

$urlactual = geturlactual();

if ($urlpath == "panel"){$activepanel = " active ";}
if ($urlpath == "panel-perfil"){$activepanelperfil = " active ";}
if ($urlpath == "panel-balance"){$activepanelbalance = " active ";}
if ($urlpath == "panel-solicitudes"){$activepanelsolicitudes = " active ";}
if ($urlpath == "panel-referidos"){$activepanelreferidos = " active ";}
if ($urlpath == "panel-opciones-retiro"){$activepanelopcionesretiro = " active ";}
if ($urlpath == "panel-retiros"){$activepanelretiros = " active ";}


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
    l_tipousuarioserv_id, tipousuarioservicio.lista_nombre as tipousuario,
    estatus.lista_nombre as estatus_nombre, usuario.l_estatus_id, 
    estatus.lista_cod as estatus_cod,
    estatus.lista_color as estatus_color

    ",
	"usuario
        left join lista tipousuarioservicio on tipousuarioservicio.lista_id = usuario.l_tipousuarioserv_id 
        left join lista estatus on estatus.lista_id = usuario.l_estatus_id
    ",
	"usuario_activo = '1' and usuario.usuario_id = '$iniuser' and usuario.cuenta_id = '$SistemaCuentaId' and usuario.compania_id = '$SistemaCompaniaId' ");
foreach($arrresultado as $i=>$valor){
	$sidebar_usuario_id = utf8_encode($valor["usuario_id"]);	
	$sidebar_usuario_nombre = utf8_encode($valor["usuario_nombre"]);
	$sidebar_usuario_fechareg = utf8_encode($valor["usuario_fechareg"]);	
    $sidebar_usuario_img = utf8_encode($valor["usuario_img"]);
    $sidebar_tipousuario = utf8_encode($valor["tipousuario"]);
    $sidebar_l_tipousuarioserv_id = utf8_encode($valor["l_tipousuarioserv_id"]);
    $sidebar_l_estatus_id = utf8_encode($valor["l_estatus_id"]);
    $sidebar_estatus_nombre = utf8_encode($valor["estatus_nombre"]);
    $sidebase_estatus_color = utf8_encode($valor["estatus_color"]);
    $sidebar_estatus_cod = utf8_encode($valor["estatus_cod"]);



    if ($sidebar_estatus_cod==4){
        $sidebar_urlpanel = "panel-centro-verificacion";
    }

    if ($sidebar_estatus_cod!=3 ){ // Diferente a Confirmado
        $sidebardivcentroverificacion = "
        <a href='panel-centro-verificacion'>
            <center>
                <img src='images/verificacion.png' style='height: 80px;' class='img-responsive' />
                <h3 style='font-size: 18px; padding-top: 5px; color: #525252'>Panel Verificación</h3>
            </center>
        </a>
        ";
    }else{
        $sidebardivcentroverificacion = "
        <a href='panel-centro-verificacion'>
            <center>
                <img src='images/usuarioverificado.png' style='height: 80px;' class='img-responsive' />
                <h3 style='font-size: 18px; padding-top: 5px; color: #525252'>Usuario Verificado</h3>
            </center>
        </a>
        ";
    }


    if ($sidebar_l_tipousuarioserv_id=="143"){
        $_COOKIE["tipousuarioserv"] = "2";     
        $sidebar_tipousuarioserv = $_COOKIE["tipousuarioserv"];
    }else{
        $_COOKIE["tipousuarioserv"] = "1";     
        $sidebar_tipousuarioserv = $_COOKIE["tipousuarioserv"];
    }

    
}


if ($sidebar_usuario_id==""){
  echo "<script language='JavaScript'>window.location = 'iniciar-sesion'; </script>";
  exit();
}

if ($sidebar_tipousuarioserv=="2"){ // Prestador

    if ($sidebar_urlpanel==""){$sidebar_urlpanel = "panelprestador";}

    $sidebar_urlmiperfil = "panelprestador-perfil";
    $sidebar_menuside = "
            <ul>
                <li><a href='panelprestador'><i class='fa fa-list'></i>Panel</a></li>
                <li><a href='$sidebar_urlmiperfil'><i class='fa fa-user'></i> Mi Perfil </a></li>
                <li><a href='panelprestador-servicios'><i class='fa fa-briefcase'></i>Servicios Ofrecidos</a></li>                                   
                <li><a href='panelprestador-solicitudes'><i class='fa fa-paper-plane'></i>Solicitudes Portal</a></li> 
                <li><a href='panel-membresia'><i class='fa fa-star'></i>Mi Membresía</a></li> 
                <li><a href='panelnotificaciones'><i class='fa fa-envelope'></i>Notificaciones</a></li> 
                <li><a href='panel-centro-verificacion'><i class='fa fa-id-card'></i>Panel Verificación</a></li> 
                <li><a href='panel-cambiar-perfil'><i class='fa fa-edit'></i> Cambia Tu Perfil</a></li>                                   
                <li class=''>
                    <a href='index?s=1'>
                            <i class='fa fa-power-off'></i>Salir                                        
                    </a>
                </li>
            </ul>
        ";
}else{

    if ($sidebar_urlpanel==""){$sidebar_urlpanel = "panelusuario";}    

    $sidebar_urlmiperfil = "panelusuario-perfil";
    $sidebar_menuside = "
            <ul>
                <li><a href='panelusuario'><i class='fa fa-list'></i>Panel</a></li>
                <li><a href='$sidebar_urlmiperfil'><i class='fa fa-user'></i> Mi Perfil </a></li>           
                <li><a href='panelusuario-solicitudes'><i class='fa fa-briefcase'></i> Mis Solicitudes </a></li> 
                <li><a href='panelnotificaciones'><i class='fa fa-envelope'></i>Notificaciones</a></li>           
                <li><a href='panel-cambiar-perfil'><i class='fa fa-edit'></i> Cambia Tu Perfil</a></li>                                   
                <li class=''>
                    <a href='index?s=1'>
                            <i class='fa fa-power-off'></i>Salir                                        
                    </a>
                </li>
            </ul>
        ";

}

 $btnestatus = "
    <a href='$sidebar_urlpanel' class='btn btn-main-sm' style='background: $sidebase_estatus_color; color: #FFF '>$sidebar_estatus_nombre</a>
";

?>
<div class="sidebar">                        
    <div class="widget user-dashboard-profile">
        <a href="<?php echo $sidebar_urlmiperfil;?>">
            <div class="profile-thumb">
                <img src="arch/<?php echo $sidebar_usuario_img;?>" alt="<?php echo $compania_nombre;?>" class="rounded-circle">
            </div>   

            <h5 class="text-center"><?php echo $sidebar_usuario_nombre;?></h5>
        </a>
        <a href="panel-cambiar-perfil">                            
            <h5 class="text-center" style="font-size: 16px; font-weight: normal;"><?php echo $sidebar_tipousuario;?> <i class="fa fa-edit"></i></h5>
        </a>
            <p style="text-align: center;">Miembro desde <?php echo $sidebar_usuario_fechareg;?></p>
            
            <?php echo $btnestatus;?>
    </div>                        
    <div class="widget user-dashboard-menu" style="padding-top: 0px">
        <?php echo $sidebar_menuside;?>
    </div>                                            
</div>