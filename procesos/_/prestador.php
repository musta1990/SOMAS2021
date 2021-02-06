<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/base.php';
include_once 'lib/funciones.php';
include_once 'lib/mysqlclass.php';
include_once 'lib/config.php';

$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;

$base = base();

(isset($_GET['id'])) ? $getusuario_id =$_GET['id'] :$getusuario_id='';
(isset($_GET['sid'])) ? $getsolicitud_id =$_GET['sid'] :$getsolicitud_id='';

$perfilprestador_usuarioinfoserv_latitud = 0;
$perfilprestador_usuarioinfoserv_longitud = 0;
$perfilprestador_rangokm_nombre = 0;
$perfilprestador_usuario_rating= 0;


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

    $titulopagina = "Prestador - ".$compania_nombre;
    $descripcionpagina = "Prestador - $compania_nombre ";

}

$arrresultado = $conexion->doSelect("usuario.usuario_id, usuario_codigo, usuario_email, 
    usuario_nombre, usuario_apellido, usuario_img, usuario_rating,

    usuarioinfoserv_id, usuarioinfoserv_resumen, usuarioinfoserv_img, 
    usuarioinfoserv_latitud, usuarioinfoserv_longitud, usuarioinfoserv_dircompleta,     
    usuarioinfoserv_activo,  
    usuarioinfoserv_eliminado, usuarioinfoserv_fechareg,
    usuarioinfoserv_infodir, usuarioinfoserv_infocalle, usuarioinfoserv_infocodpostal,
    usuarioinfoserv_infociudad, usuarioinfoserv_infociudad2, usuarioinfoserv_infosublocalidad, 
    usuarioinfoserv_inforegion, usuarioinfoserv_infocountry, usuarioinfoservicio.l_rangokm_id,
    rangokm.lista_nombre as rangokm_nombre
    ",
    "usuario
        inner join usuarioinfoservicio on usuario.usuario_id = usuarioinfoservicio.usuario_id
        inner join lista rangokm on rangokm.lista_id = usuarioinfoservicio.l_rangokm_id
    ",
    "usuario_activo = '1' and usuario.usuario_id = '$getusuario_id' and usuario.cuenta_id = '$SistemaCuentaId' and usuario.compania_id = '$SistemaCompaniaId' ");
foreach($arrresultado as $i=>$valor){

    $perfilprestador_usuarioinfoserv_infodir = utf8_encode($valor["usuarioinfoserv_infodir"]);
    $perfilprestador_usuarioinfoserv_infocalle = utf8_encode($valor["usuarioinfoserv_infocalle"]);
    $perfilprestador_usuarioinfoserv_infocodpostal = utf8_encode($valor["usuarioinfoserv_infocodpostal"]);
    $perfilprestador_usuarioinfoserv_infociudad = utf8_encode($valor["usuarioinfoserv_infociudad"]);
    $perfilprestador_usuarioinfoserv_infociudad2 = utf8_encode($valor["usuarioinfoserv_infociudad2"]);
    $perfilprestador_usuarioinfoserv_infosublocalidad = utf8_encode($valor["usuarioinfoserv_infosublocalidad"]);
    $perfilprestador_usuarioinfoserv_inforegion = utf8_encode($valor["usuarioinfoserv_inforegion"]);
    $perfilprestador_usuarioinfoserv_infocountry = utf8_encode($valor["usuarioinfoserv_infocountry"]);  

    $perfilprestador_rangokm_nombre = utf8_encode($valor["rangokm_nombre"]);
    $perfilprestador_usuario_id = utf8_encode($valor["usuario_id"]);
    $perfilprestador_usuario_codigo = utf8_encode($valor["usuario_codigo"]);
    $perfilprestador_usuario_email = utf8_encode($valor["usuario_email"]);  
    $perfilprestador_usuario_nombre = utf8_encode($valor["usuario_nombre"]);
    $perfilprestador_usuario_apellido = utf8_encode($valor["usuario_apellido"]);
    $perfilprestador_usuario_img = utf8_encode($valor["usuario_img"]);
    $perfilprestador_usuario_rating = utf8_encode($valor["usuario_rating"]);
    
    $perfilprestador_usuarioinfoserv_id = utf8_encode($valor["usuarioinfoserv_id"]);
    $perfilprestador_usuarioinfoserv_resumen = nl2br(utf8_encode($valor["usuarioinfoserv_resumen"]));
    $perfilprestador_usuarioinfoserv_img = utf8_encode($valor["usuarioinfoserv_img"]);
    $perfilprestador_usuarioinfoserv_latitud = utf8_encode($valor["usuarioinfoserv_latitud"]);
    $perfilprestador_usuarioinfoserv_longitud = utf8_encode($valor["usuarioinfoserv_longitud"]);
    $perfilprestador_usuarioinfoserv_dircompleta = utf8_encode($valor["usuarioinfoserv_dircompleta"]);
    
    $perfilprestador_usuarioinfoserv_activo = utf8_encode($valor["usuarioinfoserv_activo"]);
    $perfilprestador_usuarioinfoserv_eliminado = utf8_encode($valor["usuarioinfoserv_eliminado"]);
    $perfilprestador_usuarioinfoserv_fechareg = utf8_encode($valor["usuarioinfoserv_fechareg"]);



    $perfilprestador_l_rangokm_id = utf8_encode($valor["l_rangokm_id"]);

    $perfilprestador_urlimg = "arch/$perfilprestador_usuario_img";

    $perfilprestador = $perfilprestador_usuario_nombre." ".$perfilprestador_usuario_apellido;

}

if ($perfilprestador_usuario_rating==""){
  $perfilprestador_usuario_rating= 0;
}

$porcentaje = round(((100*$perfilprestador_usuario_rating)/5));

//$porcentaje = 0;


$arrresultado = $conexion->doSelect("cliente.usuario_id, cliente.usuario_codigo, cliente.usuario_email, cliente.usuario_clave, cliente.usuario_nombre, cliente.usuario_apellido, cliente.usuario_telf,  cliente.usuario_activo, cliente.usuario_img, cliente.perfil_id, cliente.l_tipodocumento_id,
    cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
    cuenta.usuario_apellido as cuenta_apellido, compania_nombre,
    DATE_FORMAT(cliente.usuario_fechareg,'%d/%m/%Y %H:%i:%s') as usuario_fechareg,

    usuarioservicio.usuarioservicio_id, usuarioservicio.usuario_id, usuarioservicio.l_categservicio_id,
    usuarioservicio.l_subcategservicio_id, 
    usuarioservicio.cuenta_id, usuarioservicio.compania_id, 
    usuarioservicio.usuarioservicio_activo, usuarioservicio_eliminado, 
    usuarioservicio.usuarioservicio_fechareg, usuarioservicio.usuario_idreg,

    categoria.lista_nombre as categ_nombre, categoria.lista_img as categ_img, 
    subcategoria.lista_nombre as subcateg_nombre, subcategoria.lista_img as subcateg_img

    ",
    "usuario cliente
        inner join usuarioservicio on usuarioservicio.usuario_id = cliente.usuario_id
        inner join usuario cuenta on usuarioservicio.cuenta_id = cuenta.usuario_id
        inner join compania on compania.compania_id = usuarioservicio.compania_id
        inner join lista categoria on categoria.lista_id = usuarioservicio.l_categservicio_id           
        inner join lista subcategoria on subcategoria.lista_id = usuarioservicio.l_subcategservicio_id
    ",
    "cliente.usuario_eliminado = '0' and usuarioservicio_activo = '1' and usuarioservicio.usuario_id = '$perfilprestador_usuario_id' and cliente.cuenta_id = '$SistemaCuentaId' and cliente.compania_id = '$SistemaCompaniaId' ", null, "categoria.lista_nombre, categoria.lista_id asc");
$cont = 0;
foreach($arrresultado as $i=>$valor){

    $categ_nombre = utf8_encode($valor["categ_nombre"]);
    $subcateg_nombre = utf8_encode($valor["subcateg_nombre"]);

    $categ_img = utf8_encode($valor["categ_img"]);
    $subcateg_img = utf8_encode($valor["subcateg_img"]);  

    $urlca = $UrlFiles."admin/arch/$subcateg_img";

    $subcategoriasusuarios .="
        <div class='row'>
            <div class='col-lg-12'>
                <div class='heading pb-2' style='text-align: left; padding-top: 10px'>
                    <h4 style='font-size: 18px; color: #2B2B2B'>
                      <span style='font-weight: normal;'>$categ_nombre / $subcateg_nombre</span> <img src='$urlca' class='img-responsive' style='height: 40px' />                      
                      </h4>
                </div>               
            </div>
        </div>  
    ";

}




$arrresultado = $conexion->doSelect("
  solicitudservicio.solicitudserv_id, solicitudservicio.usuario_id, solicitudservicio.solicitudserv_titulo, 
  solicitudservicio.solicitudserv_descrip, solicitudservicio.solicitudserv_latitud, solicitudservicio.solicitudserv_longitud,
  solicitudservicio.solicitudserv_dircompleta, solicitudservicio.solicitudserv_infodir, solicitudservicio.solicitudserv_infocalle,
  solicitudservicio.solicitudserv_infocodpostal, solicitudservicio.solicitudserv_infociudad, 
  solicitudservicio.solicitudserv_infociudad2, solicitudservicio.solicitudserv_infosublocalidad, 
  solicitudservicio.solicitudserv_inforegion, solicitudservicio.solicitudserv_infocountry, 
  solicitudservicio.cuenta_id, solicitudservicio.compania_id, solicitudservicio.solicitudserv_activo,
  solicitudservicio.solicitudserv_eliminado,
  solicitudservicio.usuario_idreg, 
  usuario.usuario_nombre, usuario.usuario_apellido, usuario.usuario_img, 
  cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
  cuenta.usuario_apellido as cuenta_apellido, compania_nombre, 

  solicitudserv_codigo, solicitudserv_codigoint, solicitudservicio.l_estatus_id, 
  estatus.lista_nombre as estatus_nombre,
  solicitudservicio.l_categ_id, solicitudservicio.l_subcateg_id,
  categoria.lista_nombre as categ_nombre, categoria.lista_img as categ_img,
  subcategoria.lista_nombre as subcateg_nombre, subcategoria.lista_img as subcateg_img,
  DATE_FORMAT(solicitudservicio.solicitudserv_fechareg,'%d/%m/%Y %H:%i:%s') as solicitudserv_fechareg,

  solicitudservicioprestador.solicitudservpresta_id,  
  solicitudservicioprestador.usuario_id, solicitudservicioprestador.l_estatus_id, 
  DATE_FORMAT(solicitudservicioprestador.solicitudservpresta_fechareg,'%d/%m/%Y %H:%i:%s') as solicitudservpresta_fechareg

  ",
  "solicitudservicio
    inner join lista categoria on categoria.lista_id = solicitudservicio.l_categ_id
    inner join lista subcategoria on subcategoria.lista_id = solicitudservicio.l_subcateg_id

    inner join solicitudservicioprestador on solicitudservicioprestador.solicitudserv_id = solicitudservicio.solicitudserv_id and solicitudservpresta_activo = '1'

    inner join usuario on usuario.usuario_id = solicitudservicio.usuario_id
    inner join usuario cuenta on cuenta.usuario_id = solicitudservicio.cuenta_id
    inner join compania on compania.compania_id = solicitudservicio.compania_id
    inner join lista estatus on estatus.lista_id = solicitudservicio.l_estatus_id

    $agregarinner

  ",
  "solicitudserv_activo = '1' and solicitudservicio.solicitudserv_id = '$getsolicitud_id' and solicitudservicioprestador.usuario_id = '$getusuario_id' "); 

foreach($arrresultado as $i=>$valor){

  $solicitudservpresta_id = utf8_encode($valor["solicitudservpresta_id"]);
  $s_l_estatus_id = utf8_encode($valor["l_estatus_id"]);
  $solicitudservpresta_fechareg = utf8_encode($valor["solicitudservpresta_fechareg"]);
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
  $infosolicitud_t_usuario_id = utf8_encode($valor["usuario_id"]);
  $infosolicitud_solicitudserv_titulo = utf8_encode($valor["solicitudserv_titulo"]);
  $infosolicitud_solicitudserv_descrip = utf8_encode($valor["solicitudserv_descrip"]);
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
  $infosolicitud_usuario_nombre = utf8_encode($valor["usuario_nombre"]);
  $infosolicitud_usuario_apellido = utf8_encode($valor["usuario_apellido"]);
  $infosolicitud_usuario_img = utf8_encode($valor["usuario_img"]);
  $infosolicitud_compania_nombre = utf8_encode($valor["compania_nombre"]);

  $infosolicitud_usuario = $infosolicitud_usuario_nombre." ".$infosolicitud_usuario_apellido." ";

  $infosolicitud_cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
  $infosolicitud_cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
  $infosolicitud_cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
  $infosolicitud_cuenta = $infosolicitud_cuenta_nombre." ".$infosolicitud_cuenta_apellido." ";


  $infosolicitud_titulo = "#$infosolicitud_solicitudserv_codigo";  

  $infosolicitud_idsolicitud = "<a href='versolicitud.php?id=$infosolicitud_solicitudserv_id'>$infosolicitud_titulo (Ver)</a>";

  $infosolicitud_verenmapa = "<a href='https://www.google.com/maps?ll=$infosolicitud_solicitudserv_latitud,$infosolicitud_solicitudserv_longitud&z=16&t=m&hl=es-AR&gl=US&mapclient=embed&q=34%C2%B036%2713.5%22S+58%C2%B022%2753.7%22W+$infosolicitud_solicitudserv_latitud,+$solicitudserv_longitud@$infosolicitud_solicitudserv_latitud,$infosolicitud_solicitudserv_longitud' target='_blank'  style='color: #0B787A'> (Ver)</a>";


  if ($s_l_estatus_id=="330"){
      $btncalificar = "&nbsp
      <a href='panel-calificar?id=$perfilprestador_usuario_id&sid=$getsolicitud_id' class='btn btn-main-sm' style='color: #FFF; background: #E78E08; font-size: 16px'>
       <i class='fa fa-star'></i> Calificar al Prestador
      </a>
      <br><br>
    ";
  }

  if ($s_l_estatus_id =="156"){
      $btncontratar = "&nbsp
      <a href='panel-contratar?id=$perfilprestador_usuario_id&sid=$getsolicitud_id' class='btn btn-main-sm' style='color: #FFF; font-size: 16px'>
       <i class='fa fa-check'></i> Contratar al Prestador
      </a>
      <br><br>
    ";
  }


}

$divinfosolicitud =" style ='display: none'";
if ($infosolicitud_solicitudserv_id!=""){
    $divinfosolicitud =" ";
}


$infosolicitud_displaynonegooglemaps=" style ='display: none'";
if ($infosolicitud_solicitudserv_latitud!=""){
  $infosolicitud_displaynonegooglemaps = " style= 'margin-top: 15px'";
}

if ($infosolicitud_textosolicitudes==""){
    $infosolicitud_textosolicitudes .= "
    <tr style='font-size: 14px'>
        <td colspan='5' style='text-align: center'>
            <a href='solicitar'>
                Aún no tienes solicitudes abiertas, click aquí para ver nuestros servicios
            </a>
        </td>        
    </tr>
        ";
}



$arrresultado = $conexion->doSelect("usuariorating.usuariorating_id, usuariorating.usuario_idorigen,
      usuariorating.usuario_iddestino, usuariorating.usuariorating_valor,
      usuariorating.usuariorating_comentario,
      usuariorating.usuariorating_activo, 
      usuariorating.usuariorating_eliminado, usuariorating.l_estatus_id, 
      usuariorating.cuenta_id, usuariorating.compania_id,
      DATE_FORMAT(usuariorating.usuariorating_fechareg,'%d/%m/%Y %H:%i:%s') as usuariorating_fechareg,

      usuarioorigen.usuario_nombre as usuarioorigen_nombre, 
      usuarioorigen.usuario_apellido as usuarioorigen_apellido, 
      usuarioorigen.usuario_img as usuarioorigen_img, 

      usuariodestino.usuario_nombre as usuariodestino_nombre, 
      usuariodestino.usuario_apellido as usuariodestino_apellido, 
      usuariodestino.usuario_img as usuariodestino_img, 

      usuariodestino.usuario_ratingcalidad as usuariodestino_ratingcalidad, 
      usuariodestino.usuario_ratingprecio as usuariodestino_ratingprecio, 
      usuariodestino.usuario_ratingrapidez as usuariodestino_ratingrapidez, 



      cuenta.usuario_codigo as cuenta_codigo, cuenta.usuario_nombre as cuenta_nombre,
      cuenta.usuario_apellido as cuenta_apellido, compania_nombre,

      ratingcalidad.usuarioratingdet_valor as calidadvalor,
      ratingrapidez.usuarioratingdet_valor as rapidezvalor,
      ratingprecio.usuarioratingdet_valor as preciovalor
    ",
    "
    usuariorating
        inner join usuario usuarioorigen on usuarioorigen.usuario_id = usuariorating.usuario_idorigen    
        inner join usuario usuariodestino on usuariodestino.usuario_id = usuariorating.usuario_iddestino    
        inner join usuario cuenta on cuenta.usuario_id = usuariorating.cuenta_id
        inner join compania on compania.compania_id = usuariorating.compania_id    

        inner join usuarioratingdetalle ratingcalidad on ratingcalidad.usuariorating_id = usuariorating.usuariorating_id
        and ratingcalidad.l_rating_id = '207'

        inner join usuarioratingdetalle ratingrapidez on ratingrapidez.usuariorating_id = usuariorating.usuariorating_id
        and ratingrapidez.l_rating_id = '208'

        inner join usuarioratingdetalle ratingprecio on ratingprecio.usuariorating_id = usuariorating.usuariorating_id
        and ratingprecio.l_rating_id = '209'  



    ",
    "usuariorating_activo = '1' and usuariorating.cuenta_id = '$SistemaCuentaId' and usuariorating.compania_id = '$SistemaCompaniaId' and usuariorating.l_estatus_id in ('212','210') and usuariorating.usuario_iddestino = '$perfilprestador_usuario_id'", null, "usuariorating.usuariorating_id desc");

$total = count($arrresultado);
$cont = 0;


$listaratingprestador_porcentajecalidad = 0;
$listaratingprestador_porcentajerapidez = 0;
$listaratingprestador_porcentajeprecio = 0;

$listarating_porcentajecalidad = 0;
$listarating_porcentajerapidez = 0;
$listarating_porcentajeprecio = 0;

$usuariodestino_ratingcalidad = 0;
$usuariodestino_ratingprecio = 0;
$usuariodestino_ratingrapidez = 0;

foreach($arrresultado as $i=>$valor){

    $usuariodestino_ratingcalidad = utf8_encode($valor["usuariodestino_ratingcalidad"]);
    $usuariodestino_ratingprecio = utf8_encode($valor["usuariodestino_ratingprecio"]);
    $usuariodestino_ratingrapidez = utf8_encode($valor["usuariodestino_ratingrapidez"]);    

    $listaratingprestador_porcentajecalidad = round(((100*$usuariodestino_ratingcalidad)/5));
    $listaratingprestador_porcentajerapidez = round(((100*$usuariodestino_ratingrapidez)/5));
    $listaratingprestador_porcentajeprecio = round(((100*$usuariodestino_ratingprecio)/5));



    $calidadvalor = utf8_encode($valor["calidadvalor"]);
    $rapidezvalor = utf8_encode($valor["rapidezvalor"]);
    $preciovalor = utf8_encode($valor["preciovalor"]);

    $listarating_usuariorating_id = utf8_encode($valor["usuariorating_id"]);
    $listarating_usuario_idorigen = utf8_encode($valor["usuario_idorigen"]);
    $listarating_usuario_iddestino = utf8_encode($valor["usuario_iddestino"]);
    $listarating_usuariorating_valor = utf8_encode($valor["usuariorating_valor"]);
    $listarating_usuariorating_comentario = nl2br(utf8_encode($valor["usuariorating_comentario"]));
    $listarating_usuariorating_fechareg = utf8_encode($valor["usuariorating_fechareg"]);
    $listarating_usuariorating_activo = utf8_encode($valor["usuariorating_activo"]);
    $listarating_l_estatus_id = utf8_encode($valor["l_estatus_id"]);
    $listarating_cuenta_id = utf8_encode($valor["cuenta_id"]);
    $listarating_compania_id = utf8_encode($valor["compania_id"]);

    $listarating_usuarioorigen_nombre = utf8_encode($valor["usuarioorigen_nombre"]);
    $listarating_usuarioorigen_apellido = utf8_encode($valor["usuarioorigen_apellido"]);
    $listarating_usuarioorigen_img = utf8_encode($valor["usuarioorigen_img"]);

    $listarating_usuarioorigen = $listarating_usuarioorigen_nombre." ".$listarating_usuarioorigen_apellido;

    $listarating_usuariodestino_nombre = utf8_encode($valor["usuariodestino_nombre"]);
    $listarating_usuariodestino_apellido = utf8_encode($valor["usuariodestino_apellido"]);
    $listarating_usuariodestino_img = utf8_encode($valor["usuariodestino_img"]);

    $listarating_usuariodestino = $listarating_usuariodestino_nombre." ".$listarating_usuariodestino_apellido;

    $listarating_cuenta_codigo = utf8_encode($valor["cuenta_codigo"]);
    $listarating_cuenta_nombre = utf8_encode($valor["cuenta_nombre"]);
    $listarating_cuenta_apellido = utf8_encode($valor["cuenta_apellido"]);
    $listarating_compania_nombre = utf8_encode($valor["compania_nombre"]);

    $listarating_porcentaje = round(((100*$listarating_usuariorating_valor)/5));

    $listarating_porcentajecalidad = round(((100*$calidadvalor)/5));
    $listarating_porcentajerapidez = round(((100*$rapidezvalor)/5));
    $listarating_porcentajeprecio = round(((100*$preciovalor)/5));
    

    $textoratings .="
        <div style='border: 1px solid #E7E7E7; border-radius: 20; padding: 20px 10px 10px 10px; margin-top: 20px'>           
          <div class='row' style='margin-top: 0px'>
              <div class='col-md-2 col-3'>
                <center>
                  <img src='arch/$listarating_usuarioorigen_img' style='height: 80px'>                  
                </center>
              </div>
              <div class='col-md-9 col-9' style='padding-top: 10px'>
                <h4>$listarating_usuarioorigen </h4>
                <div class='row'>
                  <div class='col-md-2 col-4' style='padding-top:7px; text-align: right; padding-right: 0px'>
                    Calidad:
                  </div>
                  <div class='col-md-7 col-8'>
                    <div class='star-ratings' title='$calidadvalor / 5 '>
                      <div class='fill-ratings' style='width: $listarating_porcentajecalidad%;' >
                        <span style='cursor: default;'>★★★★★</span>
                      </div>
                      <div class='empty-ratings'>
                        <span style='cursor: default;'>★★★★★</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class='row'>
                  <div class='col-md-2 col-4' style='padding-top:7px; text-align: right; padding-right: 0px'>
                    Rapidez:
                  </div>
                  <div class='col-md-7 col-8'>
                    <div class='star-ratings' title='$rapidezvalor / 5'>
                      <div class='fill-ratings' style='width: $listarating_porcentajerapidez%;' >
                        <span style='cursor: default;'>★★★★★</span>
                      </div>
                      <div class='empty-ratings'>
                        <span style='cursor: default;'>★★★★★</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class='row'>
                  <div class='col-md-2 col-4' style='padding-top:7px; text-align: right; padding-right: 0px'>
                    Precio:
                  </div>
                  <div class='col-md-7 col-8'>
                    <div class='star-ratings' title='$preciovalor / 5'>
                      <div class='fill-ratings' style='width: $listarating_porcentajeprecio%;' >
                        <span style='cursor: default;'>★★★★★</span>
                      </div>
                      <div class='empty-ratings'>
                        <span style='cursor: default;'>★★★★★</span>
                      </div>
                    </div>
                  </div>
                </div>
                
                <p>
                  $listarating_usuariorating_comentario
                </p>
                <div>
                  $listarating_usuariorating_fechareg
                </div>

              </div>
          </div>
        </div>
    ";

}

if ($perfilprestador_rangokm_nombre==""){$perfilprestador_rangokm_nombre=0;}

$zoomcolocar = 10;

if ($perfilprestador_rangokm_nombre=="1"){$zoomcolocar = 14;}
if ($perfilprestador_rangokm_nombre=="2"){$zoomcolocar = 13;}
if ($perfilprestador_rangokm_nombre=="3"){$zoomcolocar = 13;}
if ($perfilprestador_rangokm_nombre=="4"){$zoomcolocar = 12;}
if ($perfilprestador_rangokm_nombre=="5"){$zoomcolocar = 12;}
if ($perfilprestador_rangokm_nombre=="6"){$zoomcolocar = 12;}
if ($perfilprestador_rangokm_nombre=="7"){$zoomcolocar = 12;}
if ($perfilprestador_rangokm_nombre=="8"){$zoomcolocar = 12;}
if ($perfilprestador_rangokm_nombre=="9"){$zoomcolocar = 11;}
if ($perfilprestador_rangokm_nombre=="10"){$zoomcolocar = 11;}
if ($perfilprestador_rangokm_nombre>"10" && $perfilprestador_rangokm_nombre<="15"){$zoomcolocar = 11;}
if ($perfilprestador_rangokm_nombre>"15" && $perfilprestador_rangokm_nombre<="20"){$zoomcolocar = 10;}
if ($perfilprestador_rangokm_nombre>"20" && $perfilprestador_rangokm_nombre<="30"){$zoomcolocar = 10;}
if ($perfilprestador_rangokm_nombre>"30" && $perfilprestador_rangokm_nombre<="40"){$zoomcolocar = 9;}
if ($perfilprestador_rangokm_nombre>="50"){$zoomcolocar = 9;}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php echo $base; ?>
    <meta charset="utf-8">
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
    <style>    
      #map {
        height: 400px;
      }

      .star-ratings {
        unicode-bidi: bidi-override;
        color: #ccc;
        font-size: 30px;
        position: relative;
        margin: 0;
        padding: 0;
      }
      .star-ratings .fill-ratings {
        color: #e7711b;
        padding: 0;
        position: absolute;
        z-index: 1;
        display: block;
        top: 0;
        left: 0;
        overflow: hidden;
      }
      .star-ratings .fill-ratings span {
        display: inline-block;
      }
      .star-ratings .empty-ratings {
        padding: 0;
        display: block;
        z-index: 0;
      }
    </style>

    <?php include_once "header.php"; ?>

    <!--================================
    =            Page Title            =
    =================================-->
    <section class="page-title">
        <!-- Container Start -->
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <!-- Title text -->
                    <h3>Perfil del Prestador del Servicio</h3>
                </div>
            </div>
        </div>
        <!-- Container End -->
    </section>
    <section class="section" >
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 d-none d-md-block">
                    <center>
                        <div class="card my-3 my-lg-0 " style="text-align: center;">

                            <img class="card-img-top" src="<?php echo $perfilprestador_urlimg;?>" class="img-fluid w-100" alt="<?php echo $perfilprestador;?>" style="height: 150px; width: 150px; max-width: 100%">
                        </div>                     
                    </center>
                </div>
                <div class="col-lg-8 col-md-9 pt-2 pt-lg-0">
                    <div class="about-content">
                        <div>          

                            <div class="my-3 my-lg-0 d-md-none" style="margin-bottom: 15px">
                                
                                <img class="card-img-top" src="<?php echo $perfilprestador_urlimg;?>" class="img-responsive" alt="<?php echo $perfilprestador;?>" style="width: 100px;">
                            </div> 
                            <div>
                              <?php echo $btncontratar;?>
                              <?php echo $btncalificar;?>
                            </div>
                            <h2><?php echo $perfilprestador;?></h2>
                            <div class="row">

                              <div class="col-md-12" style="text-align: right; padding-left: 10px">
                                <div class='row'>
                                  <div class='col-md-2 col-4' style='padding-top:10px; text-align: right; padding-right: 0px; font-weight: 700'>
                                    Rating:
                                  </div>
                                  <div class='col-md-7 col-8'>
                                    <div class="star-ratings" style="float: left;">
                                      <div class="fill-ratings" style="width: <?php echo $porcentaje;?>%;">
                                        <span style="cursor: default;">★★★★★</span>
                                      </div>
                                      <div class="empty-ratings">
                                        <span style="cursor: default;">★★★★★</span>
                                      </div>
                                    </div>
                                    <div  style="text-align: right; padding-top: 0px; float: left; padding-left: 10px">
                                      <h3 style="font-size: 34px">
                                        <?php echo $perfilprestador_usuario_rating;?> <span style="font-size: 24px">/ 5</span>
                                        <a href="prestador?id=<?php echo $perfilprestador_usuario_id;?>#comentarios">
                                          <span style="font-size: 20px; font-weight: 500">
                                            (<?php echo $total;?> comentarios)
                                          </span>
                                        </a>
                                      </h3>
                                    </div>
                                  </div>
                                </div>
                                <div class='row'>
                                  <div class='col-md-2 col-4' style='padding-top:7px; text-align: right; padding-right: 0px'>
                                    Calidad:
                                  </div>
                                  <div class='col-md-7 col-8'>
                                    <div class='star-ratings' title="<?php echo $usuariodestino_ratingcalidad; ?> / 5">
                                      <div class='fill-ratings' style='width: <?php echo $listaratingprestador_porcentajecalidad; ?>%' >
                                        <span style='cursor: default;'>★★★★★</span>
                                      </div>
                                      <div class='empty-ratings'>
                                        <span style='cursor: default;'>★★★★★</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class='row'>
                                  <div class='col-md-2 col-4' style='padding-top:7px; text-align: right; padding-right: 0px'>
                                    Rapidez:
                                  </div>
                                  <div class='col-md-7 col-8'>
                                    <div class='star-ratings' title='<?php echo $usuariodestino_ratingrapidez?> / 5'>
                                      <div class='fill-ratings' style='width: <?php echo $listaratingprestador_porcentajerapidez;?>%' >
                                        <span style='cursor: default;'>★★★★★</span>
                                      </div>
                                      <div class='empty-ratings'>
                                        <span style='cursor: default;'>★★★★★</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class='row'>
                                  <div class='col-md-2 col-4' style='padding-top:7px; text-align: right; padding-right: 0px'>
                                    Precio:
                                  </div>
                                  <div class='col-md-7 col-8'>
                                    <div class='star-ratings' title='<?php echo $usuariodestino_ratingprecio;?>  / 5 '>
                                      <div class='fill-ratings' style='width: <?php echo $listaratingprestador_porcentajeprecio;?>%' >
                                        <span style='cursor: default;'>★★★★★</span>
                                      </div>
                                      <div class='empty-ratings'>
                                        <span style='cursor: default;'>★★★★★</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>



                                
                              </div>                              
                            </div>
                         
                            <p><?php echo $perfilprestador_usuarioinfoserv_resumen;?></p>
                        </div>
                       
                        <div style="margin-top: 40px">
                            <h3 class="tab-title" style="margin-bottom: 10px">Servicios Ofrecidos</h3>                            
                            <div>
                                <?php echo $subcategoriasusuarios;?>
                            </div>
                        </div>

                        <div style="margin-top: 40px">
                            <h3 class="tab-title" style="margin-bottom: 10px">Ubicación Actual</h3>                            
                            <div>
                                <label style="font-weight: 700">Dirección:</label> <?php echo $perfilprestador_usuarioinfoserv_infodir;?>
                                <br>
                                <label style="font-weight: 700">Rango Cubierto en Km:</label> <?php echo $perfilprestador_rangokm_nombre;?>
                                <br>
                                <label style="font-weight: 700">Dirección en Google Maps:</label> 
                                <br>
                                <div id="map"></div>
                            </div>
                        </div>
                        <div style="margin-top: 40px" id="comentarios">
                            <h3 class="tab-title" style="margin-bottom: 10px">Comentarios Recibidos</h3>                 

                            <?php echo $textoratings;?>
                        </div>
                        <div <?php echo $divinfosolicitud;?> >
                            <div style="margin-top: 40px" id="solicitud">
                                <h3 class="tab-title" style="margin-bottom: 10px">Solicitud #<?php echo $infosolicitud_solicitudserv_codigo;?></h3>                            
                                <div>                                                                
                                    <div class="row" style="margin-top: 15px">
                                      <div class="col-md-4" style="text-align: right; font-weight: 700">
                                        Usuario:
                                      </div>
                                      <div class="col-md-8" style="text-align: left">
                                        <?php echo $infosolicitud_usuario;?>
                                      </div>
                                      
                                    </div>
                                    <div class="row" style="margin-top: 15px">
                                      <div class="col-md-4" style="text-align: right; font-weight: 700">
                                        Servicio:
                                      </div>
                                      <div class="col-md-8" style="text-align: left">
                                        <?php echo $infosolicitud_categ_nombre;?> / <?php echo $infosolicitud_subcateg_nombre;?>
                                      </div>
                                      
                                    </div>
                                    <div class="row" style="margin-top: 15px">
                                      <div class="col-md-4" style="text-align: right; font-weight: 700">
                                        Fecha:
                                      </div>
                                      <div class="col-md-8" style="text-align: left">
                                        <?php echo $infosolicitud_solicitudserv_fechareg;?>
                                      </div>
                                      
                                    </div>
                                    <div class="row" style="margin-top: 15px">
                                      <div class="col-md-4" style="text-align: right; font-weight: 700">
                                        Titulo Solicitud:
                                      </div>
                                      <div class="col-md-8" style="text-align: left">
                                        <?php echo $infosolicitud_solicitudserv_titulo;?>
                                      </div>
                                      
                                    </div>
                                    <div class="row" style="margin-top: 15px">
                                      <div class="col-md-4" style="text-align: right; font-weight: 700">
                                        Descripción del Problema:
                                      </div>
                                      <div class="col-md-8" style="text-align: left">
                                        <?php echo $infosolicitud_solicitudserv_descrip;?>
                                      </div>
                                      
                                    </div>
                                    <div class="row" style="margin-top: 15px">
                                      <div class="col-md-4" style="text-align: right; font-weight: 700">
                                        Ubicación de la Solicitud:   
                                      </div>
                                      <div class="col-md-8" style="text-align: left">
                                        <?php echo $infosolicitud_solicitudserv_infodir." ".$infosolicitud_verenmapa;?> 



                                        <div class="form-group " <?php echo $infosolicitud_displaynonegooglemaps;?> >                
                                            <iframe src="https://maps.google.com/maps?q=<?php echo $infosolicitud_solicitudserv_latitud;?>,<?php echo $infosolicitud_solicitudserv_longitud;?>&hl=es;z=14&amp;output=embed" id="iframemaps" name="iframemaps" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                                        </div>
                                      </div>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
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
    <script src="plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
    <script src="plugins/fancybox/jquery.fancybox.pack.js"></script>
    <script src="plugins/smoothscroll/SmoothScroll.min.js"></script>
    <script src="js/script.js"></script>


    <script async defer  type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPhrxAS4PTETtyWsUE3blCecc7hGacoms&libraries=places&callback=initMap"></script>

    <script type="text/javascript">
        function initMap() {

            var map = new google.maps.Map(document.getElementById('map'), {
              center: {lat: <?php echo $perfilprestador_usuarioinfoserv_latitud;?>, lng: <?php echo $perfilprestador_usuarioinfoserv_longitud;?>},
              zoom: <?php echo $zoomcolocar;?>
            });
            
            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            if (<?php echo $perfilprestador_usuarioinfoserv_latitud;?>!="0"){
                var citymap = {
                    punto: {
                      center: {lat: <?php echo $perfilprestador_usuarioinfoserv_latitud;?>, lng: <?php echo $perfilprestador_usuarioinfoserv_longitud;?>},
                      population: 2714856
                    }
                  };                


                var rangokm = <?php echo $perfilprestador_rangokm_nombre;?>;

                for (var city in citymap) {
                  // Add the circle for this city to the map.
                  var cityCircle = new google.maps.Circle({
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    map: map,
                    center: citymap[city].center,
                    radius: rangokm * 1000
                  });
                }
            }
          
        }

        /*
  The solution below is a way to fix the percentages being off
  in iOs and Android devices and even browsers. It's also scalable
  because you can change the font-size of the stars and the width
  will adjust accordingly. This is the only way I found you could do
  unicode and CSS percentages for ratings.
*/

$(document).ready(function() {
  // Gets the span width of the filled-ratings span
  // this will be the same for each rating
  var star_rating_width = $('.fill-ratings span').width();
  // Sets the container of the ratings to span width
  // thus the percentages in mobile will never be wrong
  $('.star-ratings').width(star_rating_width);
});
    </script>
</body>
</html>



