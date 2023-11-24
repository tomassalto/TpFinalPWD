<?php
include_once("../../../configuracion.php");
// header('Content-Type: application/json');

$datos = data_submitted();
// print_r($datos);

$objCompraItem = new CompraItemController();
$arrayCompraItem = $objCompraItem->buscar($datos);

if ($arrayCompraItem[0]->getcompraItemCantidad() == $datos["ciCantidad"]) {
    if ($objCompraItem->baja($datos)) {
        echo json_encode(array('success' => 1));
        exit;
    } else {
        echo json_encode(array('success' => 0, 'error' => 'Error al eliminar el producto del carrito.'));
        exit;
    }
} else {
    $cantStockTot = $arrayCompraItem[0]->getcompraItemCantidad() - $datos["ciCantidad"];
    $datos["ciCantidad"] = $cantStockTot;
    $datos["idProducto"] = $arrayCompraItem[0]->getObjProducto()->getIdProducto();
    $datos["idCompra"] = $arrayCompraItem[0]->getObjCompra()->getIdCompra();

    if ($objCompraItem->modificacion($datos)) {
        echo json_encode(array('success' => 1));
        exit;
    } else {
        echo json_encode(array('success' => 0, 'error' => 'Error al actualizar la cantidad del producto en el carrito.'));
        exit;
    }
}
