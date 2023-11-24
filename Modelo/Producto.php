<?php
class Producto
{
    private $idProducto;
    private $productoNombre;    
    private $productoCantStock;
    private $productoPrecio;
    private $productoUrlImagen;
    private $mensajeFuncion;


    /**
     * Establece el valor de idProducto
     */
    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    /**
     * Establece el valor de nombre
     */
    public function setproductoNombre($productoNombre)
    {
        $this->productoNombre = $productoNombre;
    }   

    /**
     * Establece el valor de cantStock
     */
    public function setproductoCantStock($productoCantStock)
    {
        $this->productoCantStock = $productoCantStock;
    }


    /**
     * Establece el valor de mensajeFuncion
     */
    public function setMensajeFuncion($mensajeFuncion)
    {
        $this->mensajeFuncion = $mensajeFuncion;
    }

    /**
     * Establece el valor de productoUrlImagen
     */
    public function setproductoUrlImagen($productoUrlImagen)
    {
        $this->productoUrlImagen = $productoUrlImagen;
    }

    /**
     * Establece el valor de productoPrecio
     */
    public function setproductoPrecio($productoPrecio)
    {
        $this->productoPrecio = $productoPrecio;
    }

    /**
     * Obtiene el valor de idProducto
     */
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    /**
     * Obtiene el valor de nombre
     */
    public function getproductoNombre()
    {
        return $this->productoNombre;
    }
 

    /**
     * Obtiene el valor de cantStock
     */
    public function getproductoCantStock()
    {
        return $this->productoCantStock;
    }

    /**
     * Obtiene el valor de productoUrlImagen
     */
    public function getproductoUrlImagen()
    {
        return $this->productoUrlImagen;
    }

    /**
     * Obtiene el valor de mensajeFuncion
     */
    public function getMensajeFuncion()
    {
        return $this->mensajeFuncion;
    }

    /**
     * Obtiene el valor de productoPrecio
     */
    public function getproductoPrecio()
    {
        return $this->productoPrecio;
    }


    public function __construct()
    {
        $this->idProducto = "";
        $this->productoNombre = "";        
        $this->productoPrecio = "";
        $this->productoCantStock = "";
        $this->productoUrlImagen = "";
    }

    public function setear($idProducto, $nombre, $cantStock, $productoPrecio, $ulrImagen)
    {
        $this->setIdProducto($idProducto);
        $this->setproductoNombre($nombre);        
        $this->setproductoCantStock($cantStock);
        $this->setproductoPrecio($productoPrecio);
        $this->setproductoUrlImagen($ulrImagen);
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consulta = "INSERT INTO producto (productoNombre, productoCantStock, productoPrecio, productoUrlImagen) VALUES (
        '" . $this->getproductoNombre() . "',		
		'" . $this->getproductoCantStock() . "',
		'" . $this->getproductoPrecio() . "',
		'" . $this->getproductoUrlImagen() . "')";
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
        $sql = "UPDATE producto SET idproducto='" . $this->getIdProducto() . "', productoNombre='" . $this->getproductoNombre() . "', productoCantStock='" . $this->getproductoCantStock() . "', productoPrecio='" . $this->getproductoPrecio() . "', productoUrlImagen='" . $this->getproductoUrlImagen() . "' WHERE idproducto='" . $this->getIdProducto() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeFuncion("Producto->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeFuncion("Producto->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = null;
        if ($this->getIdProducto() != '') {
            $sql = "SELECT * FROM producto WHERE idProducto = " . $this->getIdProducto();
        }
        //echo $sql;
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idProducto'], $row['productoNombre'], $row['productoCantStock'], $row['productoPrecio'], $row['productoUrlImagen']);
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
        $arregloProductos = null;
        $base = new BaseDatos();
        $consultaPersona = "SELECT * FROM producto ";
        if ($condicion != "") {
            $consultaPersona = $consultaPersona . ' WHERE ' . $condicion;
        }
        $consultaPersona .= " ORDER BY idproducto ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                $arregloProductos = array();
                while ($Producto = $base->Registro()) {
                    $objProducto = new Producto();
                    $objProducto->setear($Producto['idProducto'], $Producto['productoNombre'], $Producto['productoCantStock'], $Producto['productoPrecio'], $Producto['productoUrlImagen']);
                    array_push($arregloProductos, $objProducto);
                }
            } else {
                $this->setMensajeFuncion($base->getError());
            }
        } else {
            $this->setMensajeFuncion($base->getError());
        }
        return $arregloProductos;
    }

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consulta = "DELETE FROM producto WHERE idProducto = '" . $this->getIdProducto() . "'";
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
