<?php
include_once("../../../configuracion.php");

$datos=data_submitted();
$objMenu=new MenuController();
$menuHabilitado=$objMenu->habilitar($datos);
if($menuHabilitado){
    echo json_encode(array('success'=>1));
}else{
    echo json_encode(array('success'=>0));
}
?>