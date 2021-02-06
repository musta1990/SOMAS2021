<?php 
    include_once 'lib/config.php';
    include_once 'lib/funciones.php';

    $SistemaCuentaId = SistemaCuentaId;
    $SistemaCompaniaId = SistemaCompaniaId;
    $UrlFiles = UrlFiles;

  $nombre = $categ_nombre;

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

?>
<section class="call-to-action overly bg-3 section-sm">
    <!-- Container Start -->
    <div class="container">
        <div class="row justify-content-md-center text-center">
            <div class="col-md-8">
                <div class="content-holder">
                    <h2>Puedes ver los planes que tenemos para ti</h2>
                    <ul class="list-inline mt-30">
                        <li class="list-inline-item"><a class="btn btn-main" href="https://api.whatsapp.com/send?phone=<?php echo $compania_whatsapp;?>"> <img src="images/whatsapp.png" style="height: 40px" /> Contactar WhatsApp</a></li>
                        <li class="list-inline-item"><a class="btn btn-primary" href="planes">Ver Planes</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Container End -->
</section>