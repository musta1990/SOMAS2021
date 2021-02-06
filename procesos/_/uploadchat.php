<?php
define ("EXP",6000000);
setlocale (LC_CTYPE, 'es_ES');
ini_set ("display_errors","0");
ini_set ("memory_limit","-1");

include_once 'lib/mysqlclass.php';
include_once 'lib/funciones.php';
include_once 'lib/phpmailer/libemail.php';
include_once 'lib/config.php';

$SistemaCuentaId = SistemaCuentaId;
$SistemaCompaniaId = SistemaCompaniaId;
$UrlFiles = UrlFiles;


session_start();
$iniuser = $_COOKIE["iniuser"];

if ($iniuser==""){echo "<script language='JavaScript'>window.location = 'index'; </script>";}

function getExtension($str) {

	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}


(isset($_POST['id'])) ? $solicitudservpresta_id=$_POST['id'] : $solicitudservpresta_id='';
(isset($_POST['mid'])) ? $getmodulo_id=$_POST['mid'] : $getmodulo_id='';
(isset($_POST['mensaje'])) ? $mensaje=$_POST['mensaje'] : $mensaje='';

$getmodulo_id=176;

$mensaje = utf8_decode($mensaje);

$fechaactual = formatoFechaHoraBd();

$conexion = new ConexionBd();

$temp = explode(".", $_FILES["file1"]["name"]);
$extension = end($temp);

$tipoarchivo = 0;

for ($n=1; $n<=1; $n++){
	
	$temp = explode(".", $_FILES["file$n"]["name"]);
	$extension = end($temp);
	//
	//$temp = explode(".", $_FILES["file"]["name"]);
	

	if ($extension!="") {
		
		if ($iniuser  =="" || $iniuser  =="0")
		{
			echo "<script language='JavaScript'>alert('Error: Debe estar conectado');</script>";
			return false;
		}
			
			
		if (($_FILES["file$n"]["error"] > 0))
		{
			echo "<script language='JavaScript'>alert('Error 113 cargando el archivo, intente nuevamente. Codigo 113');</script>";
		}
		else
		{		
	
			define ("MAX_SIZE","50000");
	
			$errors=0;
	
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				echo 2;
				$image =$_FILES["file$n"]["name"];
				$uploadedfile = $_FILES['file$n']['tmp_name'];
		
			}
			//If no errors registred, print the success message
	
			if(isset($_POST['Submit']) && !$errors)
			{
				// mysql_query("update SQL statement ");
				echo "Image Uploaded Successfully!";
			}

			$tamano = $_FILES["file$n"]["size"] / 1024;
			$nombrearchivo = utf8_decode($_FILES["file$n"]["name"]);				
			
			echo "<br>";
				
			if ($tamano >= "0" ){
				
				echo "ext:".$extension;echo "<br>";echo "<br>";
				
				//$nombrearchivo = str_replace("%.$extension%", "", $nombrearchivo);
				$nombrearchivo = preg_replace("/\.[^.]+$/", "", $nombrearchivo);
				
				echo "nombre archivo:".$nombrearchivo;
				
				echo "<br>";echo "<br>";
				
				$nombrereal = $nombrearchivo.".".$extension;
				$nombrecolocar = uniqid();	
				$nombrecolocar = $nombrecolocar.".".$extension;
				
				$urlarchivo = "arch/".$nombrecolocar;				
				unlink($urlarchivo);
				
				$tipoarchivo = 0;
				
				if ($extension=="pdf"){
					$tipoarchivo = "58";
				}else if ($extension=="xls" || $extension=="xlsx"){
					$tipoarchivo = "59";
				}else if ($extension=="doc" || $extension=="docx"){
					$tipoarchivo = "60";
				}else if ($extension=="jpg" || $extension=="jpeg" || $extension=="png" || $extension=="bmp" || $extension=="gif"){
					$tipoarchivo = "61";
				}else if ($extension=="txt"){
					$tipoarchivo = "62";
				}
						
		
				$filename1 = $urlarchivo;
					
				$a = 1;
				$resultado = move_uploaded_file($_FILES["file$n"]["tmp_name"],$urlarchivo);
				//imagejpeg($tmp1,$filename1,100);
				if($a == 1){
					
					//$resultado = $conexion->doUpdate("repuesto", "repuestousuario_img = '1'","usuario_id='$usuario_id'");
					
					//echo "<script language='JavaScript'>alert('Cargado Correctamente');</script>";
					//echo "<script language='JavaScript'>window.parent.window.location = 'modificarperfil'; </script>";
				}
				else{
					echo "<script language='JavaScript'>alert('Error cargando el producto, por favor intente nuevamente. Codigo 114');</script>";
					//echo "<script language='JavaScript'>window.parent.window.location.reload(); </script>";
				}
			}
		}		
	}
         

	if ($nombrecolocar==""){
		$nombrecolocar = "";
	}

	$arrresultado = $conexion->doSelect("chat.chat_id, solicitudservicio.solicitudserv_id, solicitudservicio.usuario_id,
		solicitudservicioprestador.usuario_id AS usuario_idprestador
		",
	  "solicitudservicio
	  	inner join solicitudservicioprestador on solicitudservicioprestador.solicitudserv_id = solicitudservicio.solicitudserv_id
	  	
	  	left join chatsolicitud on chatsolicitud.solicitudservpresta_id = solicitudservicioprestador.solicitudservpresta_id
	  	left join chat on chat.chat_id = chatsolicitud.chat_id	  	

	  ",
	  "solicitudservicioprestador.solicitudservpresta_id = '$solicitudservpresta_id' ");

	//echo "<script language='JavaScript'>alert('$solicitudservpresta_id');</script>";
    	
  	foreach($arrresultado as $i=>$valor){  
    	$chat_id = utf8_encode($valor["chat_id"]);
    	$solicitudserv_id = utf8_encode($valor["solicitudserv_id"]);
    	$usuario_idsolicitud = utf8_encode($valor["usuario_id"]);
    	$usuario_idprestador = utf8_encode($valor["usuario_idprestador"]);

    	$titulo = "Solicitud #$solicitudserv_id";

    	//echo "<script language='JavaScript'>alert('9999999');</script>";
	}	

	//echo "<script language='JavaScript'>alert('$usuario_idsolicitud');</script>";
	//echo "<script language='JavaScript'>alert('$usuario_idprestador');</script>";
	//echo "<script language='JavaScript'>alert('$iniuser');</script>";

	if ($usuario_idsolicitud==$iniuser){
		$usuario_iddestino = $usuario_idprestador;
	}else if ($usuario_idprestador==$iniuser){
		$usuario_iddestino = $usuario_idsolicitud;
	}else{
		echo "<script language='JavaScript'>alert('Error: No tiene permisos para enviar el mensaje');</script>";
		//echo "<script language='JavaScript'>window.parent.window.location = 'index?s=1';</script>";
		exit();

	}

	if ($chat_id==""){

		$resultado = $conexion->doInsert("
		chat(
			chat_titulo, chat_ultfecha, chat_ultmsje, usuario_idorigen, usuario_iddestino, chat_leido,
			 modulo_id, elemento_id, cuenta_id, compania_id, chat_fechareg, chat_activo, chat_eliminado, 
			 usuario_idcliente, usuario_idpropietario, chat_msjes)
		",
		"'$titulo', '$fechaactual','$mensaje','$iniuser', '$usuario_idsolicitud','0',
		'$getmodulo_id','$solicitudserv_id','$SistemaCuentaId', '$SistemaCompaniaId','$fechaactual', '1','0',
		'$usuario_idsolicitud','$iniuser','0'");

		$arrresultado = $conexion->doSelect("max(chat_id) as chat_id","chat",
		  "chat.modulo_id = '$getmodulo_id' and chat.elemento_id = '$solicitudserv_id'");
	    	
	  	foreach($arrresultado as $i=>$valor){  
	    	$chat_id = utf8_encode($valor["chat_id"]);
		}	


		$resultado = $conexion->doInsert("
		chatsolicitud
		(chat_id, solicitudserv_id, solicitudservpresta_id, chatsolicitud_activo, chatsolicitud_eliminado) 
		",
		"'$chat_id', '$solicitudserv_id','$solicitudservpresta_id','1', '0'");

		$nuevochat = 1;

	}


	$resultado = $conexion->doInsert("
		chatmsje
			(chat_id, chatmsje_titulo, chatmsje_arch, chatmsje_archorig, chatmsje_texto, chatmsje_fechareg, 
			usuario_idorigen, usuario_iddestino, chatmsje_leido, chatmsje_activo, chatmsje_eliminado, l_tipoarchivo_id)
		",
		"'$chat_id', '$titulo','$nombrecolocar','$nombrereal', '$mensaje', '$fechaactual',
		'$iniuser','$usuario_iddestino', '0', '1','0','$tipoarchivo'");

	$arrresultado = $conexion->doSelect("max(chatmsje_id) as chatmsje_id","chatmsje",
	  "chat_id = '$chat_id'");
    	
  	foreach($arrresultado as $i=>$valor){  
    	$chatmsje_id = utf8_encode($valor["chatmsje_id"]);
	}	

	//if ($nuevochat=="1"){
		InformarChatSolicitud($chat_id, $chatmsje_id);
	//}	

	// Cuento Mensajes del Chat
	$arrresultado = $conexion->doSelect("count(chatmsje_id) as total","chatmsje",
	  "chat_id = '$chat_id' and chatmsje_activo = '1'");
  
  	foreach($arrresultado as $i=>$valor){  
    	$total = utf8_encode($valor["total"]);

    	$resultado = $conexion->doUpdate("chat", "chat_msjes = '$total'", "chat_id='$chat_id'");
	}	

}

echo "<script language='JavaScript'>alert('Mensaje Enviado Correctamente');</script>";
echo "<script language='JavaScript'>window.parent.window.location = 'panel-chat?id=$solicitudservpresta_id'; </script>";

?>