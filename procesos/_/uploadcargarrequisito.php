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

function getExtension($str) {

	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}


(isset($_POST['reqlistaid'])) ? $requisitolista_id=$_POST['reqlistaid'] : $requisitolista_id='';
(isset($_POST['reqid'])) ? $getrequisito_id=$_POST['reqid'] : $getrequisito_id='';

session_start();
$iniuser = $_COOKIE["iniuser"];

$fechaactual = formatoFechaHoraBd();

$conexion = new ConexionBd();

	$temp = explode(".", $_FILES["file1"]["name"]);
	$extension = end($temp);


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

				$extension = strtolower($extension);
				
				$nombrereal = $nombrearchivo.".".$extension;
				$nombrecolocar = uniqid();	
				$nombrecolocar = $nombrecolocar.".".$extension;
				
				$urlarchivo = "arch/".$nombrecolocar;				
				unlink($urlarchivo);

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
					//echo "<script language='JavaScript'>window.parent.window.location = 'modificarperfil.php'; </script>";
				}
				else{
					echo "<script language='JavaScript'>alert('Error cargando el producto, por favor intente nuevamente. Codigo 114');</script>";
					//echo "<script language='JavaScript'>window.parent.window.location.reload(); </script>";
				}
			}
		}
		
	}

	if ($tipoarchivo==""){$tipoarchivo=0;}

	if ($getrequisito_id==""){

		$obtenerCodigoLista = 1;
		$obtenerTipoLista = 50;
		$estatusid = ObtenerIdLista($obtenerCodigoLista, $obtenerTipoLista);

		$resultado = $conexion->doInsert("
	    requisito
	      (l_requisitolista_id, requisito_descrip, l_tipoarchivo_id, requisito_arch, requisito_archnombre, requisito_cantarchivos, cuenta_id, compania_id, requisito_activo, requisito_eliminado, requisito_fechareg, usuario_idreg, l_estatus_id, usuario_id)
	    ",
	    "'$requisitolista_id', '', '$tipoarchivo', '$nombrecolocar', '$nombrereal', 
	    '1', '$SistemaCuentaId', '$SistemaCompaniaId', '1', '0', '$fechaactual',
	    '$iniuser', '$estatusid', '$iniuser'");

	    $arrresultado2 = $conexion->doSelect("max(requisito_id) as requisito_id","requisito", "requisito_activo = '1' and cuenta_id = '$SistemaCuentaId' and compania_id = '$SistemaCompaniaId'");
		if (count($arrresultado2)>0){
			foreach($arrresultado2 as $i=>$valor){
				$requisito_id = $valor["requisito_id"];
			}

			$resultado = $conexion->doInsert("
		    requisitoarchivo
		    	(requisito_id, requisitoarch_arch, requisitoarch_nombre, l_tipoarchivo_id, 
		    	requisitoarch_activo, requisitoarch_eliminado, requisitoarch_fechareg, usuario_idreg, l_estatus_id) 
		    ",
		    "'$requisito_id',  '$nombrecolocar', '$nombrereal', '$tipoarchivo', 
		    '1', '0', '$fechaactual', '$iniuser', '$estatusid'");


		}	

	}else{

		$arrresultado2 = $conexion->doSelect("requisitoarch_nombre","requisitoarchivo", "requisitoarch_activo = '1' and requisitoarch_nombre = '$nombrereal aaaaaaaaaaaaaaa'");
		if (count($arrresultado2)>0){
			foreach($arrresultado2 as $i=>$valor){
				$requisito_id = $valor["requisito_id"];
			}

			//echo "<script language='JavaScript'>alert('Verificar: Ya este nombre de archivo se encuentra cargado por ud, por favor verifique que no este repetido o cambie el nombre del archivo');</script>";
			//exit();

		}else{


			$resultado = $conexion->doInsert("
		    requisitoarchivo
		    	(requisito_id, requisitoarch_arch, requisitoarch_nombre, l_tipoarchivo_id, 
		    	requisitoarch_activo, requisitoarch_eliminado, requisitoarch_fechareg, usuario_idreg, l_estatus_id) 
		    ",
		    "'$getrequisito_id',  '$nombrecolocar', '$nombrereal', '$tipoarchivo', 
		    '1', '0', '$fechaactual', '$iniuser', '167'");

		    $arrresultado2 = $conexion->doSelect("count(requisitoarch_id) as total","requisitoarchivo", "requisitoarch_activo = '1' and requisito_id = '$getrequisito_id' ");
			if (count($arrresultado2)>0){
				$total = 1;

				foreach($arrresultado2 as $i=>$valor){
					$total = $valor["total"];
				}

				$resultado = $conexion->doUpdate("requisito", "
		        	requisito_cantarchivos ='$total'
		        ",
		        "requisito_id='$getrequisito_id'");	   
			}	

		}



	}

	



 }

echo "<script language='JavaScript'>alert('Requisito Cargado Correctamente');</script>";
echo "<script language='JavaScript'>window.parent.window.location = 'panel-centro-verificacion'; </script>";

?>