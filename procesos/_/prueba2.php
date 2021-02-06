<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/mysqlclass.php';

$conexion = new ConexionBd();

$sqlstring="DELETE FROM banner WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM blog WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM chat WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM compania WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM configuracionganancia WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM formulario WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);


$sqlstring="DELETE FROM gasto WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM historialestatus WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM historialtasacambio WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM lista WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listaconfig WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listacuenta WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listacuentarel WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listaformapago WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);

$sqlstring="DELETE FROM listaplanservicio WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listaredsocial WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listarequisitotipousuarioserv WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);

$sqlstring="DELETE FROM notificacion WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM pago WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM perfil WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM perfilpermiso WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM perfilpermisorow WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM portafolio WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM pregunta WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);

$sqlstring="DELETE FROM requisito WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM seccion WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM solicitudservicio WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM solicitudservicioprestador WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM sucursal WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);

$sqlstring="DELETE FROM temptransaccion WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM ticket WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM transaccion WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM transaccionganancia WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM transacciongananciausuario WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuario WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuarioinfoservicio WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuariomultinivel WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuariomultiniveldetalle WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuariomultinivelresumen WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuarioplan WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuariorating WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuarioservicio WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuarioubicacion WHERE compania_id not in (1,3)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM banner WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM blog WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM chat WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM compania WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM configuracionganancia WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM formulario WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);

$sqlstring="DELETE FROM gasto WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM historialestatus WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM historialtasacambio WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM lista WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listaconfig WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listacuenta WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listacuentarel WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listaformapago WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);

$sqlstring="DELETE FROM listaplanservicio WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listaredsocial WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM listarequisitotipousuarioserv WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);

$sqlstring="DELETE FROM notificacion WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM pago WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM perfil WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM perfilpermiso WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM perfilpermisorow WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM portafolio WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM pregunta WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);


$sqlstring="DELETE FROM requisito WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM seccion WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM solicitudservicio WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM solicitudservicioprestador WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM sucursal WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);

$sqlstring="DELETE FROM tempdetalle WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM temptransaccion WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM ticket WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM transaccion WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM transaccionganancia WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM transacciongananciausuario WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuario WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuarioinfoservicio WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuariomultinivel WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuariomultiniveldetalle WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuariomultinivelresumen WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuarioplan WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuariorating WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuarioservicio WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);
$sqlstring="DELETE FROM usuarioubicacion WHERE cuenta_id not in (1,2,8)"; $arrresultado = $conexion->doQuery($sqlstring);print_r($arrresultado);




?>