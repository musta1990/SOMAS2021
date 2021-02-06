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


(isset($_POST['monto'])) ? $monto=$_POST['monto'] : $monto='';
(isset($_POST['referencia'])) ? $referencia=$_POST['referencia'] : $referencia='';
(isset($_POST['fechapago'])) ? $fechapago=$_POST['fechapago'] : $fechapago='';
(isset($_POST['observaciones'])) ? $observaciones=$_POST['observaciones'] : $observaciones='';
(isset($_POST['formpago'])) ? $formpago=$_POST['formpago'] : $formpago='';
(isset($_POST['formpagocuenta'])) ? $formpagocuenta=$_POST['formpagocuenta'] : $formpagocuenta='';
(isset($_POST['plan_id'])) ? $plan_id=$_POST['plan_id'] : $plan_id='';
(isset($_POST['moneda_id'])) ? $l_moneda_id=$_POST['moneda_id'] : $l_moneda_id='';


session_start();
$iniuser = $_COOKIE["iniuser"];

$monto = utf8_decode($monto);
$referencia = utf8_decode($referencia);
$fechapago = utf8_decode($fechapago);
$observaciones = utf8_decode($observaciones);

$dia = substr($fechapago,0,2);
$mes = substr($fechapago,3,2);
$ano = substr($fechapago,6,4);
$fechapago = $ano."-".$mes."-".$dia;


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


	$obtenerCodigoLista = 1;
	$obtenerTipoLista = 55;
	$estatusid = ObtenerIdLista($obtenerCodigoLista, $obtenerTipoLista);

	$resultado = $conexion->doInsert("
    pago
		(pago_monto, pago_fechareg, pago_fecha, pago_referencia, pago_banco, pago_comentario, pago_img, 
		l_formapago_id, usuario_id, usuario_idreg, pago_activo, pago_eliminado, cuenta_id, compania_id, l_tipoarchivo_id, l_moneda_id, 
		l_estatus_id) 
    ",
    "'$monto', '$fechaactual', '$fechapago', '$referencia', '', '$observaciones', '$nombrecolocar',
    '$formpago', '$iniuser', '$iniuser', '1','0','$SistemaCuentaId', '$SistemaCompaniaId','$tipoarchivo','$l_moneda_id', '$estatusid'");

    $arrresultado2 = $conexion->doSelect("max(pago_id) as pago_id","pago", "pago_activo = '1' and cuenta_id = '$SistemaCuentaId' and compania_id = '$SistemaCompaniaId'");
	if (count($arrresultado2)>0){
		foreach($arrresultado2 as $i=>$valor){
			$pago_id = $valor["pago_id"];
		}


		$resultado = $conexion->doInsert("
	    pagoplan
	    (pago_id, l_plan_id, pagoplan_fechareg, pagoplan_observacion, usuario_idreg)
	    ",
	    "'$pago_id',  '$plan_id', '$fechaactual', '', '$iniuser'");

	}	
	

 }

echo "<script language='JavaScript'>alert('Pago Registrado Correctamente, en breve se confirmará el mismo y será notificado cuando se haya aprobado');</script>";
echo "<script language='JavaScript'>window.parent.window.location = 'panelprestador-pagos?c=1'; </script>";

?>