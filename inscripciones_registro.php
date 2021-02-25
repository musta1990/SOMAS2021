<?php 
include("header.php");
?>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading" style="background-color:green;">
            <h1 class="panel-title">PROCEDIMIENTO DE INSCRIPCIÓN</h1>
        </div>
        <div class="panel-body">
            <div id="orangePanel" class="row">
                <p style="color:#f2f2f2;">1. Llenar el formato proporcionado en el botón de REGISTRO de esta sección.</p>
                <p style="color:#f2f2f2;">2. Hacer los pagos de acuerdo con lo especificado en la información sobre cuotas de recuperación mediante depósitos o transferencias bancarias a nombre de:</p>
            </div>
            <div id="bluePanel" class="row">
                <p style="color:#f2f2f2; text-align:center; font-size:20px;">Sociedad Mexicana de Agricultura Sostenible, A.C.<br>
                BANCO: SANTANDER<br>
                Número de cuenta: 65505714232<br>
                Clabe Interbancaria: 014650655057142320</p>
            </div>
            <div id="greyPanel" class="row">
                <p>3. Enviar al correo electrónico <a href="mailto:tesorera@somas.org.mx" style="color:#4d94ff;">tesorera@somas.org.mx</a> y <a href="mailto:somaspresidencia@gmail.com" style="color:#4d94ff;">somaspresidencia@gmail.com</a> sus datos, y el desglose de los conceptos cubiertos por el depósito, adjuntando la captura del comprobante de pago o ficha de depósito. En el caso de inscripción de estudiantes, deberá anexarse también copia de su credencial de estudiante vigente, o de algún documento que lo acredite como tal. Si requiere factura debe solicitarse en este momento y proporcionar los datos fiscales correspondientes.</p>
                <p>4. Una vez que haya cubierto las cuotas correspondientes, recibirá vía correo electrónico, la confirmación de su inscripción, y su clave de usuario y palabra clave. Estos últimos serán necesarios para acceder a las distintas actividades del evento.</p>
            </div>
            <div class="section-content text-center">
                <div class="row">
                    <a id="myregister" class="btn btn-success" onclick="AbrirModalDatos(0)">REGISTRATE</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>

<style>

h1.panel-title {
  font-family:Arial, Helvetica, sans-serif;
  font-size:20px;
  font-weight:bold;
  text-align:center;
  color:#f2f2f2;
}

p {
  font-family:Arial, Helvetica, sans-serif;
  font-size:16px;
  font-weight:bold;
}

#orangePanel {
    border-radius:15px;
    border:1px solid #666666;
    margin-bottom: 2%;
    margin-right: 5%;
    margin-left: 5%;
    margin-top: 2%;
    background-color:#ff6600;
    padding-left:2%;
    padding-top:2%;
}

#bluePanel {
    border-radius:15px;
    border:1px solid #666666;
    margin-bottom: 2%;
    margin-right: 20%;
    margin-left: 20%;
    margin-top: 2%;
    background-color:#0088cc;
    padding-left:2%;
    padding-top:2%;
}

#greyPanel {
    border-radius:15px;
    border:1px solid #666666;
    margin-bottom: 2%;
    margin-right: 5%;
    margin-left: 5%;
    margin-top: 2%;
    background-color:#ffffcc;
    padding-left:2%;
    padding-top:2%;
}

#myregister {
      font-size:23px;
    }
  @media screen and (max-width: 430px) {
    #myregister {
      font-size:15px;
    }
  }
  @media screen and (max-width: 280px) {
    #myregister {
      font-size:12px;
    }
  }
</style>