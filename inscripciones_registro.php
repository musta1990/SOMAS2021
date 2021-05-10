<?php 
include("header.php");
?>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">PROCEDIMIENTO DE INSCRIPCIÓN AL CONGRESO</h1>
        </div>
        <div class="panel-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <p>1. Identificar el TIPO DE INSCRIPCIÓN y cuotas que le correspondan. 
                    Si desea renovar su membresía o solicitar nuevo ingreso a la SOMAS, junto con su inscripción al Congreso, llenar la hoja correspondiente 
                    (<a href="#">Renovación de membresía</a>) (<a href="#">Nuevos Socios</a>) y adjuntarla al correo que se solicita en el No. 4.  (Los formatos también se pueden obtener en la página 
                    <a href="http://www.somas.org.mx/quieres-ser-socio/">http://www.somas.org.mx/quieres-ser-socio/</a>).</p>
                </li>
                <li class="list-group-item">
                    <p>2. Presionar el botón <a id="myregister" class="btn btn-success" onclick="AbrirModalDatos(0)">REGISTRATE</a> y llenar el formulario proporcionado.</p>
                </li>
                <li class="list-group-item">
                    <p>3. Realizar los pagos de acuerdo con lo especificado en la información sobre cuotas de recuperación mediante depósitos o transferencias bancarias a nombre de:</p>
                    <div class="row">
                        <div class="col-sm-6" style="margin-left: 10%;margin-top: 2%;">
                            <p>Sociedad Mexicana de Agricultura Sostenible A.C.</p>
                            <p>BANCO: SANTANDER</p>
                            <p>Número de cuenta: 6550571423 (si estás haciendo transferencia desde una cuenta Santander deberás añadir un 2 al final)</p>
                            <p>Clabe Interbancaria: 014650655057142320</p>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <p>4. Enviar al correo electrónico <a href="mailto:tesorera@somas.org.mx"> somaspresidencia@gmail.com</a> los siguientes datos:</p>
                    <ul class="list-group">
                        <li class="list-group-item"><p>&bull; Nombre apellidos de quien se inscribe</p></li>
                        <li class="list-group-item"><p>&bull; Tipo de inscripción por la que se está optando</p></li>
                        <li class="list-group-item"><p>&bull; Folio del depósito o transferencia y desglose de los conceptos cubiertos por el mismo</p></li>
                        <li class="list-group-item"><p>&bull; Adjuntar captura legible de la ficha o comprobante de depósito, y en el caso de estudiantes copia de su credencial vigente, o de algún documento oficial que lo acredite como tal</p></li>
                        <li class="list-group-item"><p>&bull; Si requiere factura indicarlo y proporcionar los datos fiscales correspondientes</p></li>
                    </ul>
                </li>
                <li class="list-group-item">
                    <p>5. Una vez realizado lo anterior, recibirá vía correo electrónico, la confirmación de su inscripción, y de su clave de usuario y palabra clave. Estos últimos serán necesarios para acceder a las distintas actividades del evento.</p>
                </li>
            </ul>
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
}
p {
    font-family:Arial, Helvetica, sans-serif;
    font-size:18px;
}
a {
    color:#4d94ff;
}
#myregister {
      font-size:20px;
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