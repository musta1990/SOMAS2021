<?php
header("Content-disposition: attachment; filename=pdfs/seccion_SIMPOSIO.pdf");
header("Content-type: application/pdf");
readfile("seccion_SIMPOSIO.pdf");
?>