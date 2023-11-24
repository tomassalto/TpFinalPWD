<?php
include_once 'conector/BaseDatos.php';

class CompraEstado{
    private $idCompraEstado;
    private $compra;
    private $compraEstadoTipo;
    private $compraEstadoFechaIni;
    private $compraEstadoFechaFin;
    private $mensajeOperacion;

    public function __construct(){
        $this->idCompraEstado = "";
        $this->compra = new Compra();
        $this->comoEstadoTipo = new CompraEstadoTipo();
        $this->compraEstadoFechaIni = null;
        $this->compraEstadoFechaFin = null;
    }

    public function setear($id, $compra, $compraEstadoTipo, $compraEstadoFechaIni, $compraEstadoFechaFin){
        $this->setIdCompraEstado($id);
        $this->setCompra($compra);
        $this->setCompraEstadoTipo($compraEstadoTipo);
        $this->setcompraEstadoFechaIni($compraEstadoFechaIni);
        $this->setcompraEstadoFechaFin($compraEstadoFechaFin);
    }

    public function getIdCompraEstado(){
        return $this->idCompraEstado;
    }
    public function setIdCompraEstado($idCompraEstado){
        $this->idCompraEstado = $idCompraEstado;
    }
    
    public function getcompraEstadoFechaIni(){
        return $this->compraEstadoFechaIni;
    }
    public function setcompraEstadoFechaIni($compraEstadoFechaIni){
        $this->compraEstadoFechaIni = $compraEstadoFechaIni;
    }
    
    public function getcompraEstadoFechaFin(){
        return $this->compraEstadoFechaFin;
    } 
    public function setcompraEstadoFechaFin($compraEstadoFechaFin){
        $this->compraEstadoFechaFin = $compraEstadoFechaFin;
    }

    public function getCompra(){
        return $this->compra;
    }
    public function setCompra($compra){
        $this->compra = $compra;
    }

    public function getCompraEstadoTipo(){
        return $this->compraEstadoTipo;
    }
    public function setCompraEstadoTipo($compraEstadoTipo){
        $this->compraEstadoTipo = $compraEstadoTipo;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado WHERE idCompraEstado = " .$this->getIdCompraEstado();
        
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            
            if ($res > -1) {
                if ($res > 0){
                    $row = $base->Registro();
                    
                    $compra = null;
                    if ($row['idCompra'] != null) {
                        $compra = new Compra();
                        $compra->setIdCompra($row['idCompra']);
                        $compra->cargar();
                    }

                    $compraEstadoTipo = null;
                    if ($row['idCompraEstadoTipo'] != null) {
                        $compraEstadoTipo = new CompraEstadoTipo();
                        $compraEstadoTipo->setIdCompraEstadoTipo($row['idCompraEstadoTipo']);
                        $compraEstadoTipo->cargar();
                    }
                
                    $resp =  true;
                    $this->setear($row['idCompraEstado'],$compra,$compraEstadoTipo,$row['compraEstadoFechaIni'],$row['compraEstadoFechaFin']);
                }
            }
        } else {
            $this->setMensajeOperacion("menu->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO compraestado (idCompra,idCompraEstadoTipo,compraEstadoFechaIni,compraEstadoFechaFin)  VALUES (
                ".$this->getCompra()->getIdCompra().",
                ".$this->getCompraEstadoTipo()->getIdCompraEstadoTipo().",
                '".$this->getcompraEstadoFechaIni()."',
                '".$this->getcompraEstadoFechaFin()."'
                )";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("compraestado->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("compraestado->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE compraestado SET 
                idCompraEstado=".$this->getIdCompraEstado().", 
                idCompra=".$this->getCompra()->getIdCompra().", 
                idCompraEstadoTipo=".$this->getCompraEstadoTipo()->getIdCompraEstadoTipo().", 
                compraEstadoFechaFin='".$this->getcompraEstadoFechaFin()."', 
                compraEstadoFechaIni='".$this->getcompraEstadoFechaIni()."'
                WHERE idCompraEstado=".$this->getIdCompraEstado();
        
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("CompraEstado->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstado->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compraEstado WHERE idCompraEstado=" . $this->getIdCompraEstado();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("CompraEstado->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstado->eliminar: " . $base->getError());
        }
        return $resp;
    }
    
    public function listar($parametro = ""){
        $arreglo = null;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraEstado ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                $arreglo = array();
                while ($row = $base->Registro()) {
                    $obj = new CompraEstado();

                    $objCompra = null;
                    if ($row['idCompra'] != null) {
                        $objCompra = new Compra();
                        $objCompra->setIdCompra($row['idCompra']);
                        $objCompra->cargar();
                    }
                    $objCompraEstadoTipo = null;
                    if ($row['idCompraEstadoTipo'] != null) {
                        $objCompraEstadoTipo = new CompraEstadoTipo();
                        $objCompraEstadoTipo->setIdCompraEstadoTipo($row['idCompraEstadoTipo']);
                        $objCompraEstadoTipo->cargar();
                    }

                    $obj->setear($row['idCompraEstado'], $objCompra, $objCompraEstadoTipo, $row['compraEstadoFechaIni'], $row['compraEstadoFechaFin']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("CompraEstado->listar: " . $base->getError());
        }
        return $arreglo;
    }
}
