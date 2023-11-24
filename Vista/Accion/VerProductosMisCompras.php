<?php
include_once("../../configuracion.php");

$datos = data_submitted();
$objCompraItem = new CompraItemController();
$arrayCompraItem = $objCompraItem->buscar($datos);
if ($arrayCompraItem != null) {
    $arrayJS = arrayArmadoJS($arrayCompraItem);
    echo json_encode(array('success' => $arrayJS));
} else {
    echo json_encode(array('success' => 0));
}

function arrayArmadoJS($arrayCompraItem)
{
    $arrayJS = [];
    foreach ($arrayCompraItem as $compraItem) {
        $param = [
            "Nombre" => $compraItem->getObjProducto()->getNombre(),
            "Descripcion" => $compraItem->getObjProducto()->getDetalle(),
            "Precio" => $compraItem->getObjProducto()->getproductoPrecio(),
            "Cantidad" => $compraItem->getcompraItemCantidad(),
            "productoUrlImagen" => $compraItem->getObjProducto()->getproductoUrlImagen(),
        ];
        array_push($arrayJS, $param);
    }
    return $arrayJS;
}
