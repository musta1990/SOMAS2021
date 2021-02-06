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
$headeriniuser = $_COOKIE["iniuser"];
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

    $urlcompaniaimg = $UrlFiles."admin/arch/$compania_img";
    $urlcompaniaimgicono = $UrlFiles."admin/arch/$compania_imgicono";

}


if ($iniuser==""){
	$header_menunav = "
		<ul class='navbar-nav ml-auto main-nav '>				
			<li class='nav-item'>
				<a class='nav-link' href='como-funciona'>¿Cómo Funciona? </a>
			</li>
			<li class='nav-item'>
				<a class='nav-link' href='solicitar'>Servicios</a>
			</li>
			<li class='nav-item'>
				<a class='nav-link' href='planes'>Planes</a>
			</li>
			
			<li class='nav-item'>
				<a class='nav-link' href='blog'>Consejos</a>
			</li>			      
			<li class='nav-item'>
				<a class='nav-link' href='contacto'>Contacto</a>
			</li>
			<li class='nav-item'>
				<a class='nav-link' href='registro'>Registro</a>
			</li>	
		</ul>
		<ul class='navbar-nav ml-auto mt-10'>							
			<li class='nav-item'>
				<a class='nav-link text-white add-button' href='iniciar-sesion'><i class='fa fa-user'></i> Ingresar</a>
			</li>
		</ul>
	";
}else{



	$arrresultado = $conexion->doSelect("usuario.usuario_id, usuario_nombre, 
	    usuario_img,DATE_FORMAT(usuario_fechareg,'%d/%m/%Y') as usuario_fechareg, 
	     l_tipousuarioserv_id, tipousuarioservicio.lista_nombre as tipousuario

	    ",
		"usuario
	        left join lista tipousuarioservicio on tipousuarioservicio.lista_id = usuario.l_tipousuarioserv_id 
	    ",
		"usuario_activo = '1' and usuario.usuario_id = '$iniuser'");
	foreach($arrresultado as $i=>$valor){
		$header_usuario_id = utf8_encode($valor["usuario_id"]);	
		$header_usuario_nombre = utf8_encode($valor["usuario_nombre"]);
		$header_usuario_fechareg = utf8_encode($valor["usuario_fechareg"]);	
	    $header_usuario_img = utf8_encode($valor["usuario_img"]);
	    $header_tipousuario = utf8_encode($valor["tipousuario"]);
	    $header_l_tipousuarioserv_id = utf8_encode($valor["l_tipousuarioserv_id"]);

	    if ($header_l_tipousuarioserv_id=="143"){
	        $_COOKIE["tipousuarioserv"] = "2";     
	        $header_tipousuarioserv = $_COOKIE["tipousuarioserv"];
	    }else{
	        $_COOKIE["tipousuarioserv"] = "1";     
	        $header_tipousuarioserv = $_COOKIE["tipousuarioserv"];
	    }
	}


	if ($header_tipousuarioserv=="2"){ // Prestador		
	    $header_menudrop = "
				<a class='dropdown-item' href='admin/panel'><i class='fa fa-list'></i> Panel</a>				
				<a class='dropdown-item' href='./?s=1'><i class='fa fa-power-off'></i> Salir</a>
	        ";

	    $header_menunav = "
			<ul class='navbar-nav ml-auto main-nav '>
								
				<li class='nav-item'>
					<a class='nav-link' href='como-funciona'>¿Cómo Funciona? </a>
				</li>		
				<li class='nav-item'>
					<a class='nav-link' href='solicitar'>Buscar Servicio</a>
				</li>
				<li class='nav-item'>
					<a class='nav-link' href='planes'>Planes</a>
				</li> 				                        
				<li class='nav-item'>
					<a class='nav-link' href='contacto'>Contacto</a>
				</li>  
				<li class='nav-item dropdown dropdown-slide' style='background: #0C3DA8'>
					<a class='nav-link dropdown-toggle' data-toggle='dropdown' href='#' style='color: #fff'><i class='fa fa-user'></i> Mi Cuenta<span><i class='fa fa-angle-down'></i></span>
					</a>								
					<div class='dropdown-menu '>
						$header_menudrop		
					</div>
				</li>    
			</ul>
		";

	}else{		
	    $header_menudrop = "
				<a class='dropdown-item' href='admin/panel'><i class='fa fa-list'></i> Panel</a>				
				<a class='dropdown-item' href='./?s=1'><i class='fa fa-power-off'></i> Salir</a>			
	        ";

	    $header_menunav = "
			<ul class='navbar-nav ml-auto main-nav '>
							
				<li class='nav-item'>
					<a class='nav-link' href='como-funciona'>¿Cómo Funciona?</a>
				</li>		
				<li class='nav-item'>
					<a class='nav-link' href='solicitar'>Buscar Servicio</a>
				</li>	
				<li class='nav-item'>
					<a class='nav-link' href='blog'>Consejos</a>
				</li>			                        
				<li class='nav-item'>
					<a class='nav-link' href='contacto'>Contacto</a>
				</li> 
				<li class='nav-item dropdown dropdown-slide' style='background: #0C3DA8'>
					<a class='nav-link dropdown-toggle' data-toggle='dropdown' href='#' style='color: #fff'><i class='fa fa-user'></i> Mi Cuenta<span><i class='fa fa-angle-down'></i></span>
					</a>								
					<div class='dropdown-menu '>
						$header_menudrop		
					</div>
				</li>	     
			</ul>
		";

	}


	

}


?>

<section class="sectionheader">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar navbar-expand-lg navbar-light navigation">
					<a class="navbar-brand" href="./">
						<img src="<?php echo $urlcompaniaimg;?>" alt="<?php echo $compania_nombre;?>" class="img-responsive">
					</a>					
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<?php echo $header_menunav;?>
					</div>
				</nav>
			</div>
		</div>
	</div>
</section>