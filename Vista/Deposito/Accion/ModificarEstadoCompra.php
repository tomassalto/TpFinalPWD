<?php
include_once("../../../configuracion.php");

$datos = data_submitted();
if (modificarEstadoCompra($datos)) {
    echo json_encode(array('success' => 1));
} else {
    echo json_encode(array('success' => 0));
}

function modificarEstadoCompra($datos)
{
    $objCompraEstado = new CompraEstadoController();
    $resp = false;
    $paramCompraEstadoAnterior = null;
    $paramCompraEstadoNuevo = null;
    $fecha = new DateTime();
    $fechaHoy = $fecha->format('Y-m-d H:i:s');
    $paramCompraEstadoAnterior = [
        "idCompraEstado" => $datos["idCompraEstado"],
        "idCompra" => $datos["idCompra"],
        "idCompraEstadoTipo" => $datos["idCompraEstadoTipoAnterior"],
        "compraEstadoFechaIni" => $datos["compraEstadoFechaIni"],
        "compraEstadoFechaFin" => $fechaHoy,
    ];
    $paramCompraEstadoNuevo = [
        "idCompraEstado" => $datos["idCompraEstado"],
        "idCompra" => $datos["idCompra"],
        "idCompraEstadoTipo" => $datos["idCompraEstadoTipoActualizado"],
        "compraEstadoFechaIni" => $fechaHoy,
        "compraEstadoFechaFin" => null,
    ];
    if ($objCompraEstado->modificacion($paramCompraEstadoAnterior) && $objCompraEstado->alta($paramCompraEstadoNuevo)) {
        $resp = true;
    }
    if($datos["idCompraEstadoTipoActualizado"] == 5){
        $objCompraItem = new CompraItemController();
        $arrayCompraItem = $objCompraItem->buscar($datos);
        foreach($arrayCompraItem as $compraItem){
            $paramProducto = [
                "idProducto" =>$compraItem->getObjProducto()->getIdProducto(),
                "productoNombre" =>$compraItem->getObjProducto()->getNombre(),                
                "productoCantStock" =>$compraItem->getObjProducto()->getCantStock() + $compraItem->getcompraItemCantidad(),
                "productoPrecio" =>$compraItem->getObjProducto()->getproductoPrecio(),
                "productoUrlImagen" =>$compraItem->getObjProducto()->getproductoUrlImagen()
            ];
            $objProducto = new ProductoController();
            $objProducto->modificacion($paramProducto);
        }

    }
    return $resp;
}
