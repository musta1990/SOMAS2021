<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/base.php';
include_once 'lib/funciones.php';
include_once 'lib/mysqlclass.php';
include_once 'lib/config.php';
include_once 'lib/xajax_0.2.4/xajax.inc.php';

$xajax = new xajax('lib/ajx_fnci.php');
$xajax->registerFunction('actualizarchat');
$xajax->printJavascript('lib/');


$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

$base = base();

session_start();
$iniuser = $_COOKIE['iniuser'];
$login = $_COOKIE['login'];
$perfil = $_COOKIE['perfil'];

if ($iniuser==""){
  echo "<script language='JavaScript'>window.location = 'iniciar-sesion?i=1'; </script>";
  exit();
}

(isset($_GET['id'])) ? $getsolicitudservpresta_id=$_GET['id'] :$getsolicitudservpresta_id='';

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

    $titulopagina = "Chat de Solicitud - ".$compania_nombre;
    $descripcionpagina = "Chat de Solicitud - $compania_nombre ";

}


$arrresultado = $conexion->doSelect("usuario_id, usuario_codigo, usuario_email, usuario_clave, usuario_nombre, usuario_apellido, 
    usuario_telf, usuario_activo, usuario_eliminado, usuario_documento, usuario_img, perfil_id, 
    DATE_FORMAT(usuario_fechanac,'%d/%m/%Y') as usuario_fechanac, nivelriesgo_id,
    DATE_FORMAT(usuario_fechareg,'%d/%m/%Y') as usuario_fechareg, usuario_alias, l_tipousuarioserv_id",
	"usuario",
	"usuario_activo = '1' and usuario_id = '$iniuser' and usuario.cuenta_id = '$SistemaCuentaId' and usuario.compania_id = '$SistemaCompaniaId'  ", null, "usuario_id asc");
foreach($arrresultado as $i=>$valor){

    $usuario_alias = utf8_encode($valor["usuario_alias"]);

	$usuario_id = utf8_encode($valor["usuario_id"]);
	$usuario_codigo = utf8_encode($valor["usuario_codigo"]);
	$usuario_email = utf8_encode($valor["usuario_email"]);


	$usuario_clave = utf8_encode($valor["usuario_clave"]);
	$usuario_nombre = utf8_encode($valor["usuario_nombre"]);
	$usuario_apellido = utf8_encode($valor["usuario_apellido"]);
	$usuario_telf = utf8_encode($valor["usuario_telf"]);
	$usuario_fechareg = utf8_encode($valor["usuario_fechareg"]);
	$usuario_activo = utf8_encode($valor["usuario_activo"]);
	$usuario_documento = utf8_encode($valor["usuario_documento"]);
	$t_perfil_id = utf8_encode($valor["perfil_id"]);
    $usuario_fechareg = utf8_encode($valor["usuario_fechareg"]);
    $l_tipousuarioserv_id = utf8_encode($valor["l_tipousuarioserv_id"]);
    $usuario_img = utf8_encode($valor["usuario_img"]);
}



$arrresultado = $conexion->doSelect("
  solicitudservicio.solicitudserv_id, solicitudservicio.solicitudserv_titulo, 
  solicitudservicio.solicitudserv_descrip, solicitudservicio.solicitudserv_latitud, solicitudservicio.solicitudserv_longitud,
  solicitudservicio.solicitudserv_dircompleta, solicitudservicio.solicitudserv_infodir, solicitudservicio.solicitudserv_infocalle,
  solicitudservicio.solicitudserv_infocodpostal, solicitudservicio.solicitudserv_infociudad, 
  solicitudservicio.solicitudserv_infociudad2, solicitudservicio.solicitudserv_infosublocalidad, 
  solicitudservicio.solicitudserv_inforegion, solicitudservicio.solicitudserv_infocountry, 
  solicitudservicio.cuenta_id, solicitudservicio.compania_id, solicitudservicio.solicitudserv_activo,
  solicitudservicio.solicitudserv_eliminado,
  solicitudservicio.usuario_idreg, 

  usuario.usuario_id, usuario.usuario_nombre, usuario.usuario_apellido, usuario.usuario_img, 
  usuario.usuario_telf, usuario.usuario_email,

  usuarioprestador.usuario_id as usuarioprestador_id,
  usuarioprestador.usuario_nombre as usuarioprestador_nombre, usuarioprestador.usuario_apellido as usuarioprestador_apellido, 
  usuarioprestador.usuario_img as usuarioprestador_img, 
  usuarioprestador.usuario_telf as usuarioprestador_telf, usuarioprestador.usuario_email as usuarioprestador_email,

  cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
  cuenta.usuario_apellido as cuenta_apellido, compania_nombre, 

  solicitudserv_codigo, solicitudserv_codigoint, solicitudservicio.l_estatus_id, 
  estatus.lista_nombre as estatus_nombre,
  solicitudservicio.l_categ_id, solicitudservicio.l_subcateg_id,
  categoria.lista_nombre as categ_nombre, categoria.lista_img as categ_img,
  subcategoria.lista_nombre as subcateg_nombre, subcategoria.lista_img as subcateg_img,
  DATE_FORMAT(solicitudservicio.solicitudserv_fechareg,'%d/%m/%Y %H:%i:%s') as solicitudserv_fechareg,


  solicitudservicioprestador.solicitudservpresta_id,  
  solicitudservicioprestador.l_estatus_id as estatus_idservicioprestador, 
  solicitudservicioprestador.solicitudservpresta_fechareg, solicitudservicioprestador.cuenta_id, 
  solicitudservicioprestador.compania_id, solicitudservicioprestador.solicitudservpresta_activo, 
  solicitudservicioprestador.solicitudservpresta_eliminado, solicitudservicioprestador.usuario_idreg,
  estatusservicioprestador.lista_cod as estatusservicioprestador_cod,
  estatusservicioprestador.lista_nombre as estatusservicioprestador_nombre


  ",
  "solicitudservicio
    inner join lista categoria on categoria.lista_id = solicitudservicio.l_categ_id
    inner join lista subcategoria on subcategoria.lista_id = solicitudservicio.l_subcateg_id

    inner join usuario on usuario.usuario_id = solicitudservicio.usuario_id
    inner join usuario cuenta on cuenta.usuario_id = solicitudservicio.cuenta_id
    inner join compania on compania.compania_id = solicitudservicio.compania_id
    inner join lista estatus on estatus.lista_id = solicitudservicio.l_estatus_id

    inner join solicitudservicioprestador on solicitudservicioprestador.solicitudserv_id = solicitudservicio.solicitudserv_id
              and solicitudservpresta_activo = '1'

    inner join usuario usuarioprestador on usuarioprestador.usuario_id = solicitudservicioprestador.usuario_id

    inner join lista estatusservicioprestador on estatusservicioprestador.lista_id = solicitudservicioprestador.l_estatus_id

  ",
  "solicitudserv_activo = '1' and solicitudservicioprestador.solicitudservpresta_id = '$getsolicitudservpresta_id' and solicitudservicio.cuenta_id = '$SistemaCuentaId' and solicitudservicio.compania_id = '$SistemaCompaniaId'  
  and ( solicitudservicio.usuario_id = '$iniuser' or solicitudservicioprestador.usuario_id = '$iniuser') "); 

foreach($arrresultado as $i=>$valor){


  $solicitudservpresta_id = utf8_encode($valor["solicitudservpresta_id"]);
  $s_l_estatus_id = utf8_encode($valor["l_estatus_id"]);
  $estatus_idservicioprestador = utf8_encode($valor["estatus_idservicioprestador"]);
  $solicitudservpresta_fechareg = utf8_encode($valor["solicitudservpresta_fechareg"]);

  $estatusservicioprestador_cod = utf8_encode($valor["estatusservicioprestador_cod"]);
  $estatusservicioprestador_nombre = utf8_encode($valor["estatusservicioprestador_nombre"]);

  $infosolicitud_categ_nombre = utf8_encode($valor["categ_nombre"]);
  $infosolicitud_categ_img = utf8_encode($valor["categ_img"]);
  $infosolicitud_subcateg_nombre = utf8_encode($valor["subcateg_nombre"]);
  $infosolicitud_subcateg_img = utf8_encode($valor["subcateg_img"]);

  $infosolicitud_solicitudserv_codigo = utf8_encode($valor["solicitudserv_codigo"]);
  $infosolicitud_solicitudserv_codigoint = utf8_encode($valor["solicitudserv_codigoint"]);
  $infosolicitud_l_estatus_id = utf8_encode($valor["l_estatus_id"]);
  $infosolicitud_estatus_nombre = utf8_encode($valor["estatus_nombre"]);

  $infosolicitud_solicitudserv_id = utf8_encode($valor["solicitudserv_id"]);  
  $infosolicitud_solicitudserv_titulo = utf8_encode($valor["solicitudserv_titulo"]);
  $infosolicitud_solicitudserv_descrip = nl2br(utf8_encode($valor["solicitudserv_descrip"]));
  $infosolicitud_solicitudserv_latitud = utf8_encode($valor["solicitudserv_latitud"]);
  $infosolicitud_solicitudserv_longitud = utf8_encode($valor["solicitudserv_longitud"]);
  $infosolicitud_solicitudserv_dircompleta = utf8_encode($valor["solicitudserv_dircompleta"]);
  $infosolicitud_solicitudserv_infodir = utf8_encode($valor["solicitudserv_infodir"]);
  $infosolicitud_solicitudserv_infocalle = utf8_encode($valor["solicitudserv_infocalle"]);
  $infosolicitud_solicitudserv_infocodpostal = utf8_encode($valor["solicitudserv_infocodpostal"]);
  $infosolicitud_solicitudserv_infociudad = utf8_encode($valor["solicitudserv_infociudad"]);
  $infosolicitud_solicitudserv_infociudad2 = utf8_encode($valor["solicitudserv_infociudad2"]);
  $infosolicitud_solicitudserv_infosublocalidad = utf8_encode($valor["solicitudserv_infosublocalidad"]);
  $infosolicitud_solicitudserv_inforegion = utf8_encode($valor["solicitudserv_inforegion"]);
  $infosolicitud_solicitudserv_infocountry = utf8_encode($valor["solicitudserv_infocountry"]);
  $infosolicitud_t_cuenta_id = utf8_encode($valor["cuenta_id"]);
  $infosolicitud_t_compania_id = utf8_encode($valor["compania_id"]);
  $infosolicitud_solicitudserv_activo = utf8_encode($valor["solicitudserv_activo"]);
  $infosolicitud_solicitudserv_fechareg = utf8_encode($valor["solicitudserv_fechareg"]);

  $infosolicitud_usuario_id = utf8_encode($valor["usuario_id"]);
  $infosolicitud_usuario_nombre = utf8_encode($valor["usuario_nombre"]);
  $infosolicitud_usuario_apellido = utf8_encode($valor["usuario_apellido"]);
  $infosolicitud_usuario_telf = utf8_encode($valor["usuario_telf"]);
  $infosolicitud_usuario_email = utf8_encode($valor["usuario_email"]);
  $infosolicitud_usuario_img = utf8_encode($valor["usuario_img"]);

  $infosolicitud_usuarioprestador_id = utf8_encode($valor["usuarioprestador_id"]);
  $infosolicitud_usuarioprestador_nombre = utf8_encode($valor["usuarioprestador_nombre"]);
  $infosolicitud_usuarioprestador_apellido = utf8_encode($valor["usuarioprestador_apellido"]);
  $infosolicitud_usuarioprestador_telf = utf8_encode($valor["usuarioprestador_telf"]);
  $infosolicitud_usuarioprestador_email = utf8_encode($valor["usuarioprestador_email"]);
  $infosolicitud_usuarioprestador_img = utf8_encode($valor["usuarioprestador_img"]);


  $infosolicitud_compania_nombre = utf8_encode($valor["compania_nombre"]);

  $infosolicitud_usuario = $infosolicitud_usuario_nombre." ".$infosolicitud_usuario_apellido." ";
  $infosolicitud_usuarioprestador = $infosolicitud_usuarioprestador_nombre." ".$infosolicitud_usuarioprestador_apellido." ";

  $infosolicitud_cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
  $infosolicitud_cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
  $infosolicitud_cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
  $infosolicitud_cuenta = $infosolicitud_cuenta_nombre." ".$infosolicitud_cuenta_apellido." ";


  $infosolicitud_titulo = "#$infosolicitud_solicitudserv_codigo";  

  $infosolicitud_idsolicitud = "<a href='versolicitud.php?id=$infosolicitud_solicitudserv_id'>$infosolicitud_titulo (Ver)</a>";

  $infosolicitud_verenmapa = "<a href='https://www.google.com/maps?ll=$infosolicitud_solicitudserv_latitud,$infosolicitud_solicitudserv_longitud&z=16&t=m&hl=es-AR&gl=US&mapclient=embed&q=34%C2%B036%2713.5%22S+58%C2%B022%2753.7%22W+$infosolicitud_solicitudserv_latitud,+$solicitudserv_longitud@$infosolicitud_solicitudserv_latitud,$infosolicitud_solicitudserv_longitud' target='_blank'  style='color: #0B787A'> (Ver)</a>";

  if ($estatusservicioprestador_cod=="4"){
      $btncalificar = "&nbsp
      <br><br>
      <a href='panel-calificar?id=$infosolicitud_usuarioprestador_id&sid=$infosolicitud_solicitudserv_id' class='btn btn-main-sm' style='color: #FFF; background: #E78E08; font-size: 16px'>
       <i class='fa fa-star'></i> Calificar al Prestador
      </a>
      <br>
    ";
  }

  if ($estatusservicioprestador_cod =="3"){
      $btncontratar = "&nbsp<br><br>
      <a href='panel-contratar?id=$infosolicitud_usuarioprestador_id&sid=$infosolicitud_solicitudserv_id' class='btn btn-main-sm' style='color: #FFF; font-size: 16px'>
       <i class='fa fa-check'></i> Contratar al Prestador
      </a>
      <br>
    ";
  }


}

if ($estatusservicioprestador_cod=="6" || $estatusservicioprestador_cod=="1"  ){ 
  echo "<script language='JavaScript'>window.location = 'index?s=1'; </script>";
  exit();
}



$btnaccion = $btncalificar.$btncontratar;

$destino = "";

if ($iniuser==$infosolicitud_usuario_id){
    $destino = "
        <a href='prestador?id=$infosolicitud_usuarioprestador_id' style=' color: #328D9C' target='_blank'>
            $infosolicitud_usuarioprestador (Ver Perfil)
        </a>
    ";

    $destinoimg = $infosolicitud_usuarioprestador_img;
}else{

    $elemento = "div_datoscontacto";
    
    if ($estatusservicioprestador_cod=="3"){
      $destino = "
          <a style='font-weight: 600'>
              $infosolicitud_usuario
          </a>
      ";
    }

    if ($estatusservicioprestador_cod=="4" || $estatusservicioprestador_cod=="5" ){

      $destino = "
        <a style='font-weight: 600'>
            $infosolicitud_usuario <span style='font-size: 16px; color: #328D9C; cursor: pointer'  onclick='mostrardiv(\"".$elemento."\")'> (Ver Datos de Contacto)</span>
        </a>
    ";

      $destino .="
          <div style='margin-top: 5px; line-height:30px; display: none' id='div_datoscontacto'>
            Teléfono: $infosolicitud_usuario_telf
            <br>
            Email: $infosolicitud_usuario_email
          </div>
      ";
    }

    $btncontratar = "";
    $btncalificar = "";
    $btnaccion = "";

    $destinoimg = $infosolicitud_usuario_img;
}


$arrresultado = $conexion->doSelect("
        chat.chat_id, chat.chat_titulo, chat.chat_ultmsje, 
        chat.chat_leido, chat.modulo_id, chat.elemento_id, chat.cuenta_id, chat.compania_id, 
        chat.chat_activo, chat.chat_eliminado, chat.chat_msjes,
        usuarioorigen.usuario_nombre, usuarioorigen.usuario_apellido, usuarioorigen.usuario_img,
        DATE_FORMAT(chat.chat_fechareg,'%d/%m/%Y %H:%i:%s') as chat_fechareg,
        DATE_FORMAT(chat.chat_ultfecha,'%d/%m/%Y %H:%i:%s') as chat_ultfecha,
        modulo_url, modulo_nombreunico,
        cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
        cuenta.usuario_apellido as cuenta_apellido, compania_nombre,

        chatmsje.chatmsje_id, chatmsje.chat_id, chatmsje_titulo, chatmsje_arch, chatmsje_archorig, 
        chatmsje_texto, chatmsje.usuario_idorigen, chatmsje.usuario_iddestino, 
        chatmsje_leido, chatmsje_activo, chatmsje_eliminado,
        DATE_FORMAT(chatmsje_fechareg,'%d/%m/%Y %H:%i:%s') as chatmsje_fechareg,
        usuario.usuario_nombre, usuario.usuario_apellido, usuario.usuario_img, 
        chatmsje.l_tipoarchivo_id,

        chatsolicitud.chatsolicitud_id, chatsolicitud.chat_id, chatsolicitud.solicitudserv_id, 
        chatsolicitud.solicitudservpresta_id, chatsolicitud.chatsolicitud_activo, chatsolicitud.chatsolicitud_eliminado

        ",
        "
        chat
            inner join modulo on modulo.modulo_id = chat.modulo_id
            inner join usuario cuenta on cuenta.usuario_id = chat.cuenta_id
            inner join compania on compania.compania_id = chat.compania_id 

            inner join chatmsje on chat.chat_id = chatmsje.chat_id
            inner join usuario usuarioorigen on usuarioorigen.usuario_id = chatmsje.usuario_idorigen

            inner join chatsolicitud on chatsolicitud.chat_id = chat.chat_id
            inner join solicitudservicio on solicitudservicio.solicitudserv_id = chatsolicitud.solicitudserv_id
            inner join solicitudservicioprestador on solicitudservicioprestador.solicitudserv_id = solicitudservicio.solicitudserv_id
        
            inner join usuario on chatmsje.usuario_idorigen = usuario.usuario_id            
        ",
        "chatmsje_activo = '1' and solicitudservicioprestador.solicitudservpresta_id = '$getsolicitudservpresta_id'  and chat.cuenta_id = '$SistemaCuentaId' and chat.compania_id = '$SistemaCompaniaId'  ", null, "chatmsje_id desc");
    foreach($arrresultado as $i=>$valor){

        $chatsolicitud_id = utf8_encode($valor["chatsolicitud_id"]);
        $solicitudserv_id = utf8_encode($valor["solicitudserv_id"]);
        $solicitudservpresta_id = utf8_encode($valor["solicitudservpresta_id"]);

        $chatmsje_id = utf8_encode($valor["chatmsje_id"]);
        $chat_id = utf8_encode($valor["chat_id"]);
        $chatmsje_titulo = utf8_encode($valor["chatmsje_titulo"]);
        $chatmsje_arch = utf8_encode($valor["chatmsje_arch"]);
        $chatmsje_archorig = utf8_encode($valor["chatmsje_archorig"]);
        $chatmsje_texto = utf8_encode($valor["chatmsje_texto"]);
        $usuario_idorigen = utf8_encode($valor["usuario_idorigen"]);
        $usuario_iddestino = utf8_encode($valor["usuario_iddestino"]);
        $chatmsje_leido = utf8_encode($valor["chatmsje_leido"]);
        $chatmsje_activo = utf8_encode($valor["chatmsje_activo"]);
        $chatmsje_fechareg = utf8_encode($valor["chatmsje_fechareg"]);
        $l_tipoarchivo_id = utf8_encode($valor["l_tipoarchivo_id"]);

        if ($chatmsje_leido=="1"){
          $msjeleido = "<br><i class='fa fa-check' style='font-size: 10px; color: #78B9FF; font-weight: bold' title='Leido'></i> <i class='fa fa-check' style='font-size: 10px; color: #78B9FF; font-weight: bold' title='Leido'></i>";
        }else{
          $msjeleido = "<br><i class='fa fa-check' style='font-size: 10px; color: #A4A4A4; font-weight: bold' title='Entregado - No Leido'></i> <i class='fa fa-check' style='font-size: 10px; color: #A4A4A4; font-weight: bold' title='Entregado - No Leido'></i>";
        }


        $usuario_nombre = utf8_encode($valor["usuario_nombre"]);
        $usuario_apellido = utf8_encode($valor["usuario_apellido"]);
        $usuario_img = utf8_encode($valor["usuario_img"]);

        $usuario = $usuario_nombre." ".$usuario_apellido." ";   

        $agregarchivoadjunto = "";
        $labeladjunto = "";

        $color1 = "#F4F4F4";
        $color2 = "#DEEEEE";

        if ($usuario_idorigen==$iniuser){
            $background = $color1;
        }else{
            $background = $color2;
        }


        if ($chatmsje_arch!="" && $chatmsje_arch!="0.jpg"){

            $labeladjunto = "Archivo Adjunto:";

            if ($l_tipoarchivo_id=="58"){

                $labeladjunto = "$tipoarchivo_nombre Adjunto:";
                $agregarchivoadjunto = "
                    <a href='arch/$chatmsje_arch' target='_blank'>
                        <img src='images/tipoarchivo/".$l_tipoarchivo_id.".jpg' style='height: 20px' />
                        $chatmsje_archorig
                    </a>
                ";
            }else if ($l_tipoarchivo_id=="59"){

                $labeladjunto = "$tipoarchivo_nombre Adjunto:";
                $agregarchivoadjunto = "
                    <a href='arch/$chatmsje_arch' target='_blank'>
                        <img src='images/tipoarchivo/".$l_tipoarchivo_id.".jpg' style='height: 20px' />
                        $chatmsje_archorig
                    </a>
                ";
            }else if ($l_tipoarchivo_id=="60"){

                $labeladjunto = "$tipoarchivo_nombre Adjunto:";
                $agregarchivoadjunto = "
                    <a href='arch/$chatmsje_arch' target='_blank'>
                        <img src='images/tipoarchivo/".$l_tipoarchivo_id.".jpg' style='height: 20px' />
                        $chatmsje_archorig
                    </a>
                ";
            }else if ($l_tipoarchivo_id=="61"){
                $labeladjunto = "$tipoarchivo_nombre Adjunto:";
                $agregarchivoadjunto = "
                    <a class='fancybox' href='arch/$chatmsje_arch' data-fancybox-group='gallery'>
                        <img class='img-responsive' src='arch/$chatmsje_arch' style='height: 100px; border-radius: 10px' />
                    </a>
                ";
            }else if ($l_tipoarchivo_id=="62"){

                $labeladjunto = "$tipoarchivo_nombre Adjunto:";
                $agregarchivoadjunto = "
                    <a href='arch/$chatmsje_arch' target='_blank'>
                        <img src='images/tipoarchivo/".$l_tipoarchivo_id.".jpg' style='height: 20px' />
                        $chatmsje_archorig
                    </a>
                ";
            }
            else{
                $agregarchivoadjunto = "
                    <a href='arch/$chatmsje_arch' target='_blank'>
                        $chatmsje_archorig
                    </a>
                ";
            }
        }

        $mensajes .= "
                 <div class='row' style='margin-top: 0px; background: $background; padding: 10px 0px; border-bottom: 1px solid #DFDFDF'>
                   
                    <div class='col-md-12' style='text-align: left;'>
                        <div class='box-header'>                                 
                            <div class='row'>
                                <div class='col-md-3 col-4' style='padding-top: 5px'> 
                                    <center>
                                        <img src='arch/$usuario_img' class='user-image' style='height: 60px;border-radius: 50%; max-width: 100%'>
                                        <br>
                                        $usuario

                                    </center>                                                   
                                </div> 
                                <div class='col-md-9 col-8' style='text-align: justify;'>
                                    <p style='text-align: left'>
                                        $chatmsje_fechareg
                                    </p>
                                    <p>
                                        $chatmsje_texto
                                    </p>
                                    $msjeleido
                                </div>                                   
                            </div>
                            <div class='row'>
                                <div class='col-md-1' style='padding-top: 5px'> 
                                    
                                </div> 
                                <div class='col-md-2' style='padding-top: 5px; text-align: right'> 
                                    $labeladjunto
                                </div> 
                                <div class='col-md-8' style='text-align: left; padding-top:5px'>
                                    $agregarchivoadjunto
                                </div>                                   
                            </div>
                        </div>   
                    </div>                                    
                </div>    
                           
            ";

    }


    if ($mensajes==""){

        $mensajes .= "
             <div class='row'>              
                <div class='col-md-12' style='text-align: left;'>
                    <div class='box-header with-border' style='background: #FFF; '>                                 
                        <div class='row'>
                            <div class='col-md-12' style='padding-top: 5px'> 
                                <div class='alert alert-success' style='text-align: center; font-weight: normal;'>
                                    <a style='color: #000; font-size: 14px; text-decoration: none;'>
                                        Ahora puede escribir un mensaje  para mayor detalle de la solicitud
                                    </a>
                                </div>                                                 
                            </div>                                                              
                        </div>                        
                    </div>   
                </div>                                    
            </div>            
        ";
    }else{

      $resultado = $conexion->doUpdate("chatmsje", "
        chatmsje_leido ='1'
      ",
      "chat_id='$chat_id' and usuario_iddestino = '$iniuser'");   
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php echo $base; ?>
    <meta charset="utf-8">

    <meta http-equiv="refresh" content="300">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $descripcionpagina;?>">
    <meta name="author" content="<?php echo $compania_nombre;?>">

    <title><?php echo $titulopagina;?></title>

    <meta name="keywords" content="<?php echo $titulopagina;?>">
    <meta name="description" content="<?php echo $descripcionpagina;?>">

    <meta property="og:image" content="<?php echo $urlcompaniaimg;?>">
    <meta property="og:title" content="<?php echo $descripcionpagina;?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $compania_urlweb;?>" />
    <meta property="og:description" content="<?php echo $descripcionpagina;?>">
    <meta property="og:site_name" content="<?php echo $compania_nombre;?>" />
    <meta name="robots" content="index, follow">
        
    <meta name="twitter:card" content="summary" />
    
    <meta name="twitter:title" content="<?php echo $descripcionpagina;?>" />
    <meta name="twitter:description" content="<?php echo $descripcionpagina;?>" />
    <meta name="twitter:image" content="<?php echo $urlcompaniaimg;?>" />
  
    <link href="<?php echo $urlcompaniaimgicono;?>" rel="shortcut icon">
    <!-- PLUGINS CSS STYLE -->
    <!-- <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"> -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap-slider.css">
    <!-- Font Awesome -->
    <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Owl Carousel -->
    <link href="plugins/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="plugins/slick-carousel/slick/slick-theme.css" rel="stylesheet">
    <!-- Fancy Box -->
    <link href="plugins/fancybox/jquery.fancybox.pack.css" rel="stylesheet">
    <link href="plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <!-- CUSTOM CSS -->
    <link href="css/style2.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="lib/fancy/source/jquery.fancybox.css?v=2.1.5" media="screen" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous"> -->

    
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo GoogleAnalytics?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo GoogleAnalytics;?>');
</script>

</head>
<body class="body-wrapper">

    <?php include_once "header.php"; ?>

    <!--==================================
    =            User Profile            =
    ===================================-->
    <section class="dashboard section">
        <!-- Container Start -->
        <div class="container">            
            <!-- Row Start -->
            <div class="row">
                <div class="col-md-10 offset-md-1 col-lg-3 offset-lg-0 order-sm-1 order-2">
                    <?php include_once "panel-sidebar.php"; ?>
                </div>
                <div class="col-md-10 offset-md-1 col-lg-9 offset-lg-0 order-sm-2 order-1">
                    <?php include_once "panel-notificaciones.php"; ?>
                    <!-- Edit Profile Welcome Text -->
                    <div class="widget welcome-message" style="padding-bottom: 10px">
                        <div class="row">
                            <div class="col-md-2 col-4">
                                <img src="arch/<?php echo $destinoimg;?>" style="width: 100%;">
                            </div>
                            <div class="col-md-9 col-8" style="padding-top: 10px">
                                <h3><a href="panel-solicitud?id=<?php echo $infosolicitud_solicitudserv_id;?>" target='_blank' style="color: #007bff">Solicitud #<?php echo $infosolicitud_solicitudserv_id;?></a></h3>
                                <h3>Estatus Solicitud: <span style="font-weight: normal;"><?php echo $estatusservicioprestador_nombre;?></span></h3>
                                <h3 style="font-weight: normal;">
                                    Chat con 
                                    
                                    <?php echo $destino;?>
                                    <?php echo $infocliente;?>
                                    <?php echo $btnaccion;?>

                                </h3>
                            </div>                            
                        </div>                       
                    </div>

                    <div class="box" style="margin-top: 10px">                                                        
                            <div class="box-body">
                                <div style="max-height: 340px; overflow-y: auto; overflow-x: hidden;">                    
                                  <?php echo $mensajes; ?>

                                </div>                                
                            </div>
                        </div>
                    <!-- Edit Personal Info -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget personal-info">

                                <form target='iframeupload'  action="uploadchat" enctype="multipart/form-data" method="POST">
                                    <div class="box-body">                                    
                                        <div class="row">
                                            <div class="form-group col-md-9 col-9">                                            
                                                <textarea placeholder="Escriba su Mensaje *" class="textarea" placeholder="Message" name="mensaje" id="mensaje" required="required"
                                                style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                            </div>
                                            <div class="form-group col-md-3 col-3"> 
                                                <input type="submit" name="submit" value="Enviar" class="btn btn-primary">                                          
                                                <label for="file1" style="cursor: pointer; margin-top: 5px;">
                                                    <img src="images/adjuntar.png" style="height: 30px">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-8" style="display: nonee;">                                            
                                                <span class="control-fileupload">
                                                  <label for="file1">Adjuntar Archivo :</label>
                                                  <input type="file" id="file1" name="file1">
                                                </span>
                                            </div>                                           
                                        </div>
                                                                    
                                    </div>
                                    
                                    <input type="hidden" name="id" value="<?php echo $solicitudservpresta_id;?>">                                    
                                </form>
                                <iframe id="iframeupload" name="iframeupload" height="0" width="0" style="display: none" ></iframe>
                                                            
                            </div>
                        </div>                                          
                    </div>
                   
                </div>
            </div>
            <!-- Row End -->
        </div>
        <!-- Container End -->
    </section>

    <?php include_once "footer.php"; ?>

    <!-- JAVASCRIPTS -->
    <script src="plugins/jQuery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/popper.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap-slider.js"></script>
    <!-- tether js -->
    <script src="plugins/tether/js/tether.min.js"></script>
    <script src="plugins/raty/jquery.raty-fa.js"></script>
    <script src="plugins/slick-carousel/slick/slick.min.js"></script>    
    <script src="plugins/fancybox/jquery.fancybox.pack.js"></script>
    <script src="plugins/smoothscroll/SmoothScroll.min.js"></script>
    <script src="js/script.js"></script>

    <script type="text/javascript" src="lib/fancy/source/jquery.fancybox.js?v=2.1.5"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.fancybox').fancybox();
        });
    </script>

    <script type="text/javascript">
    $(document).ready(function() {  
        function ActualizarChat() {
            xajax_actualizarchat(<?php echo $solicitudservpresta_id;?>);
        }
        setInterval(ActualizarChat, 10000);
    });
    </script>

   


</body>
</html>

