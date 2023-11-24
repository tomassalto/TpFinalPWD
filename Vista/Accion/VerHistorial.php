<?php
include_once("../../configuracion.php");

$datos = data_submitted();
$objCompraEstado = new CompraEstadoController();
$arrayCompraEstado = $objCompraEstado->buscar($datos);
if ($arrayCompraEstado != null) {
    $arrayJS = arrayArmadoJS($arrayCompraEstado);
    echo json_encode(array('success' => $arrayJS));
} else {
    echo json_encode(array('success' => 0));
}

function arrayArmadoJS($arrayCompraEstado)
{
    $arrayJS = [];
    foreach ($arrayCompraEstado as $compraEstado) {
        $param = [
            "idCompra" => $compraEstado->getIdCompraEstado(),
            "NombreUsuario" => $compraEstado->getCompra()->getObjUsuario()->getusuarioNombre(),
            "Estado" => $compraEstado->getCompraEstadoTipo()->getcompraEstadoTipoDescripcion(),
            "FechaInicio" => $compraEstado->getcompraEstadoFechaIni(),
            "FechaFin" => $compraEstado->getcompraEstadoFechaFin(),
        ];
        array_push($arrayJS, $param);
    }
    return $arrayJS;
}
