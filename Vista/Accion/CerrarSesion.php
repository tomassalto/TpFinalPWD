<?php
include_once('../../configuracion.php');

$objSession=new SesionController();
$sesionCerrada=$objSession->cerrar();
if($sesionCerrada){
    echo json_encode(array('success'=>1));
}else{
    echo json_encode(array('success'=>0));
}
