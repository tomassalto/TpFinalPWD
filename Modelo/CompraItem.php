<?php
class CompraItem
{
    private $idCompraItem;
    private $objProducto;
    private $objCompra;
    private $compraItemCantidad;
    private $mensajeFuncion;

    /**
     * Establece el valor de idCompraItem
     */
    public function setIdCompraItem($idCompraItem)
    {
        $this->idCompraItem = $idCompraItem;
    }

    /**
     * Establece el valor de objProducto
     */
    public function setObjProducto($objProducto)
    {
        $this->objProducto = $objProducto;
    }

    /**
     * Establece el valor de objCompra
     */
    public function setObjCompra($objCompra)
    {
        $this->objCompra = $objCompra;
    }


    /**
     * Establece el valor de cantidad
     */
    public function setcompraItemCantidad($compraItemCantidad)
    {
        $this->compraItemCantidad = $compraItemCantidad;
    }

    /**
     * Establece el valor de mensajeFuncion
     */
    public function setMensajeFuncion($mensajeFuncion)
    {
        $this->mensajeFuncion = $mensajeFuncion;
    }

    /**
     * Obtiene el valor de idCompraItem
     */
    public function getIdCompraItem()
    {
        return $this->idCompraItem;
    }

    /**
     * Obtiene el valor de objProducto
     */
    public function getObjProducto()
    {
        return $this->objProducto;
    }

    /**
     * Obtiene el valor de idCompra
     */
    public function getObjCompra()
    {
        return $this->objCompra;
    }

    /**
     * Obtiene el valor de cantidad
     */
    public function getcompraItemCantidad()
    {
        return $this->compraItemCantidad;
    }

    /**
     * Obtiene el valor de mensajeFuncion
     */
    public function getMensajeFuncion()
    {
        return $this->mensajeFuncion;
    }


    public function __construct()
    {
        $this->idCompraItem = "";
        $this->objProducto = new Producto;
        $this->objCompra = new Compra;
        $this->compraItemCantidad = "";
    }

    public function setear($idCompraItem, $idProducto, $idCompra, $compraItemCantidad)
    {
        $this->objProducto->setIdProducto($idProducto);
        $this->objCompra->setIdCompra($idCompra);
        $this->setIdCompraItem($idCompraItem);
        $this->setcompraItemCantidad($compraItemCantidad);
        $this->objProducto->cargar();
        $this->objCompra->cargar();
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consulta = "INSERT INTO compraitem (idCompraItem, idProducto, idCompra, compraItemCantidad) VALUES (
		'" . $this->getIdCompraItem() . "',
		'" . $this->getObjProducto()->getIdProducto() . "',
		'" . $this->getObjCompra()->getIdCompra() . "',
		'" . $this->getcompraItemCantidad() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $resp =  true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consulta = "UPDATE compraitem
SET idCompraItem = {$this->getIdCompraItem()},
idProducto = {$this->getObjProducto()->getIdProducto()},
idCompra = {$this->getObjCompra()->getIdCompra()},
compraItemCantidad = '{$this->getcompraItemCantidad()}'
WHERE idCompraItem = {$this->getIdCompraItem()}";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $resp =  true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        if ($this->getIdCompraItem() != '') {
            $sql = "SELECT * FROM compraitem WHERE idCompraItem = " . $this->getIdCompraItem();
        }
        //echo $sql;
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idCompraItem'], $row['idProducto'], $row['idCompra'], $row['compraItemCantidad']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }

    public function listar($condicion = "")
    {
        $arregloCompraitem = null;
        $base = new BaseDatos();
        $consultaCompraItem = "SELECT * FROM compraitem ";
        if ($condicion != "") {
            $consultaCompraItem = $consultaCompraItem . ' WHERE ' . $condicion;
        }
        $consultaCompraItem .= " ORDER BY idCompraItem ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaCompraItem)) {
                $arregloCompraitem = array();
                while ($compraItem = $base->Registro()) {
                    $objCompraItem = new CompraItem();
                    $objCompraItem->setear($compraItem["idCompraItem"], $compraItem["idProducto"], $compraItem["idCompra"], $compraItem["compraItemCantidad"],);
                    array_push($arregloCompraitem, $objCompraItem);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $arregloCompraitem;
    }

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM compraitem WHERE idCompraItem = " . $this->getIdCompraItem();
            if ($base->Ejecutar($consulta)) {
                $resp =  true;
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $resp;
    }
}
