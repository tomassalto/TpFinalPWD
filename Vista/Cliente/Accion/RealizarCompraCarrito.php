<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$objCompraEstado = new CompraEstadoController();
$arrayCompraEstado = $objCompraEstado->buscar($datos);
$idCompra["idCompra"] = $arrayCompraEstado[0]->getCompra()->getIdCompra();
$arrayObjProductoCarrito = obtenerProductos($idCompra);
if ($arrayObjProductoCarrito != null) {
    if (modificarEstadoCompra($datos, $arrayCompraEstado[0])) {
        foreach ($arrayObjProductoCarrito as $objProductoCarrito) {
            modificarStockProducto($objProductoCarrito);
        }
        echo json_encode(array('success' => 1));
    } else {
        echo json_encode(array('success' => 0));
    }
}else{
    echo json_encode(array('success' => 2));
}


/* Devuelve todos los productos del idCompra */
function obtenerProductos($idCompra)
{
    $objCompraItem = new CompraItemController;
    $arrayCompraItem = $objCompraItem->buscar($idCompra);
    return $arrayCompraItem;
}

/* Modifica el estado de la compra a "iniciada" */
function modificarEstadoCompra($datos, $compraEstado){
    $objCompraEstado = new CompraEstadoController();
    $resp = false;
    $paramCompraEstado = null;
    $fecha = new DateTime();
    $fechaStamp = $fecha->format('Y-m-d H:i:s');
    $paramCompraEstado = [
        "idCompraEstado" => $datos["idCompraEstado"],
        "idCompra" => $compraEstado->getCompra()->getIdCompra(),
        "idCompraEstadoTipo" => 2,
        "compraEstadoFechaIni" => $fechaStamp,
        "compraEstadoFechaFin" => null,
    ];
    if($objCompraEstado->modificacion($paramCompraEstado)){
        $resp = true;
    }
    return $resp;
}

/* Modifica el es stock del producto */
function modificarStockProducto($objProductoCarrito)
{
    $objProducto = new ProductoController();
    $idProducto["idProducto"] = $objProductoCarrito->getObjProducto()->getIdProducto();
    $arrayProducto = $objProducto->buscar($idProducto);
    $resp = false;
    $stockTot = $arrayProducto[0]->getproductoCantStock() - $objProductoCarrito->getcompraItemCantidad();
    $paramProducto = [
        "idProducto" => $arrayProducto[0]->getIdProducto(),
        "productoNombre" => $arrayProducto[0]->getproductoNombre(),        
        "productoPrecio" => $arrayProducto[0]->getproductoPrecio(),
        "productoUrlImagen" => $arrayProducto[0]->getproductoUrlImagen(),
        "productoCantStock" => $stockTot
    ];
    if ($objProducto->modificacion($paramProducto)) {
        $resp = true;
    }
    return $resp;
}
