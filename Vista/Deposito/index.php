<?php
include_once('../estructura/header.php');
if($objSession->getVista()!=NULL){
    if ($objSession->getVista()->getIdRol() == 3) {
        header('Location: listaProductos.php');
    } else {
        header('Location: ../paginas/home.php');
    }
}else {
    header('Location: ../paginas/home.php');
}
?>