<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$objSesion = new SesionController();

    if ($objSesion->valida($datos)) {
        echo json_encode(array('success'=>1));
    } else {
        echo json_encode(array('success'=>0));
    }
