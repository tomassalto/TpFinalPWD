<?php
include_once("../../../configuracion.php");

$datos = data_submitted();
print_r($datos);
$objCompraEstadoBorrador = null;
$arrayCompras = null;
$objSesion = new SesionController();
$objCompraEstado = new CompraEstadoController();
$objUsuario = $objSesion->getUsuario();
$idUsuario["idUsuario"] = $objUsuario->getIdUsuario();
$arrayCompras = buscarComprasUsuario($idUsuario);
if ($arrayCompras != null) {
    $objCompraEstadoBorrador = $objCompraEstado->buscarCompraBorrador($arrayCompras);
    if ($objCompraEstadoBorrador != null) {
        cargarProducto($objCompraEstadoBorrador, $datos);
    }
}
if (($arrayCompras == null) || ($objCompraEstadoBorrador == null)) {
    $objCompraEstadoBorrador = crearCompra($idUsuario);
    cargarProducto($objCompraEstadoBorrador, $datos);
}

/* Busca con el id usuario todos las compras que realizo */
function buscarComprasUsuario($idUsuario)
{
    $objCompra = new CompraController();
    $arrayCompra = $objCompra->buscar($idUsuario);
    return $arrayCompra;
}

/* Lo que realiza es cargarle el producto deseado */
function cargarProducto($objCompraEstadoBorrador, $datos)
{
    $objCompraItem = new CompraItemController();
    $arrayCompraItem = $objCompraItem->buscar($datos);
    $datos["idCompra"] = $objCompraEstadoBorrador->getCompra()->getIdCompra();
    $objCompraItemRepetido = productoRepetido($arrayCompraItem, $datos["idCompra"]);
    if ($objCompraItemRepetido == null) {
        if ($objCompraItem->alta($datos)) {
            echo json_encode(array('success' => 1));
        } else {
            echo json_encode(array('success' => 0));
        }
    } else {
        $cantStockDisp = $objCompraItemRepetido->getObjProducto()->getproductoCantStock();
        $cantTot = $datos["ciCantidad"] + $objCompraItemRepetido->getcompraItemCantidad();
        if ($cantTot > $cantStockDisp) {
            echo json_encode(array('success' => 0));
        } else {
            $param = [
                "idCompraItem" => $objCompraItemRepetido->getIdCompraItem(),
                "idProducto" => $objCompraItemRepetido->getObjProducto()->getIdProducto(),
                "idCompra" => $objCompraItemRepetido->getObjCompra()->getIdCompra(),
                "ciCantidad" => $cantTot
            ];
            $objCompraItem->modificacion($param);
            echo json_encode(array('success' => 1));
        }
    }
}

/* Devuelve si el producto ya esta cargado en el carrito utilizado actualmente */
function productoRepetido($arrayCompraItem, $idCompra)
{
    $resp = null;
    if ($arrayCompraItem != null) {
        foreach ($arrayCompraItem as $compraItem) {
            if ($compraItem->getObjCompra()->getIdCompra() == $idCompra) {
                $resp = $compraItem;
            }
        }
    }
    return $resp;
}

/* Crea una compra y compraEstado con el idusuario */
function crearCompra($idUsuario)
{
    $objCompra = new CompraController();
    $objCompraEstado = new CompraEstadoController();
    $arrayObjCompraEstado = null;
    if ($objCompra->alta($idUsuario)) {
        $arrayCompra = $objCompra->buscar($idUsuario);
        $fecha = new DateTime();
        $fechaStamp = $fecha->format('Y-m-d H:i:s');
        $paramCompraEstado = [
            "idCompra" => end($arrayCompra)->getIdCompra(),
            "idCompraEstadoTipo" => 1,
            "compraEstadoFechaIni" => $fechaStamp,
            "compraEstadoFechaFin" => null
        ];
        if ($objCompraEstado->alta($paramCompraEstado)) {
            $idCompra["idCompra"] = end($arrayCompra)->getIdCompra();
            $arrayObjCompraEstado = $objCompraEstado->buscar($idCompra);
        }
    }
    return $arrayObjCompraEstado[0];
}
