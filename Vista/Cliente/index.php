<?php
include_once('../estructura/header.php');
if($objSession->getVista()!=NULL){
    if ($objSession->getVista()->getIdRol() == 2) {
        header('Location: productos.php');
    } else {
        header('Location: ../paginas/home.php');
    }
}else{
    header('Location: ../paginas/home.php');
}
?>