<?php
include_once("../../../configuracion.php");
header('Content-Type: application/json');
$datos=data_submitted();
$objUsuario=new UsuarioController();
$usuarioDeshabilitado=$objUsuario->deshabilitar($datos);
if($usuarioDeshabilitado){
    echo json_encode(array('success'=>1));
}else{
    echo json_encode(array('success'=>0));
}
?>