<?php

include_once('conector/BaseDatos.php');

class Menu
{
    private $idMenu;
    private $menuNombre;
    private $padre;
    private $menuDescripcion;
    private $menuDeshabilitado;
    private $mensajeOperacion;


    public function setIdMenu($idMenu)
    {
        $this->idMenu = $idMenu;
    }

    public function setmenuNombre($menuNombre)
    {
        $this->menuNombre = $menuNombre;
    }

    public function setmenuDeshabilitado($menuDeshabilitado)
    {
        $this->menuDeshabilitado = $menuDeshabilitado;
    }

    public function setPadre($padre)
    {
        $this->padre = $padre;
    }

    public function setmenuDescripcion($menuDescripcion)
    {
        $this->menuDescripcion = $menuDescripcion;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }


    public function getIdMenu()
    {
        return $this->idMenu;
    }

    public function getmenuNombre()
    {
        return $this->menuNombre;
    }

    public function getmenuDeshabilitado()
    {
        return $this->menuDeshabilitado;
    }

    public function getPadre()
    {
        return $this->padre;
    }

    public function getmenuDescripcion()
    {
        return $this->menuDescripcion;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }


    public function __construct()
    {
        $this->idMenu = "";
        $this->menuNombre = "";
        $this->padre = null;
        $this->menuDeshabilitado = null;
        $this->mensajeOperacion = "";
    }

    public function setear($id, $nombre, $descripcion, $padre, $deshabilitado)
    {
        $this->setIdMenu($id);
        $this->setmenuNombre($nombre);
        $this->setmenuDeshabilitado($deshabilitado);
        $this->setPadre($padre);
        $this->setmenuDescripcion($descripcion);
    }


    //carga info de bd a objeto php
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu WHERE idMenu = " . $this->getIdMenu();

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();

                    $objPadre = null;
                    if ($row['idPadre'] != null) {
                        $objPadre = new Menu();
                        $objPadre->setIdMenu($row['idPadre']);
                        $objPadre->cargar();
                    }

                    $resp =  true;
                    $this->setear($row['idMenu'], $row['menuNombre'], $row['menuDescripcion'], $objPadre, $row['menuDeshabilitado']);
                }
            }
        } else {
            $this->setMensajeOperacion("menu->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();

        $idPadre = $this->getPadre();
        if ($idPadre != null) {
            $idPadre = "'" . $idPadre->getIdMenu() . "'";
        } else {
            $idPadre = 'NULL';
        }

        $deshabilitado = $this->getmenuDeshabilitado();
        if ($deshabilitado != null) {
            $deshabilitado = "'" . $deshabilitado . "'";
        } else {
            $deshabilitado = 'NULL';
        }

        $sql = "INSERT INTO menu (menuNombre, menuDescripcion, idPadre, menuDeshabilitado)  VALUES (
                '" . $this->getmenuNombre() . "',
                '" . $this->getmenuDescripcion() . "',
                " . $idPadre . ",
                " . $deshabilitado . "
                )";

        if ($base->Iniciar()) {
            if ($id = $base->Ejecutar($sql)) {
                $this->setIdMenu($id);
                $resp = true;
            } else {
                $this->setMensajeOperacion("menu->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menu->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $deshabilitado = $this->getmenuDeshabilitado();
        if ($deshabilitado == null) {
            //PARA EL CASO QUE QUIERA MODIFICAR OBJETO SIN TOCAR usuarioDeshabilitado
            $deshabilitado == '';
        } else if ($deshabilitado == 'habilitar') {
            //PARA EL CASO QUE QUIERA HABILITARLO
            $deshabilitado = ",menuDeshabilitado=NULL";
        } else {
            //PARA EL CASO QUE QUIERA DESHABILITARLO
            $deshabilitado = ",menuDeshabilitado='" . $this->getmenuDeshabilitado() . "' ";
        }

        $idPadre = $this->getPadre();
        $idPadre != null ? $idPadre = ",idPadre=" . $idPadre->getIdMenu() : $idPadre = '';

        $sql = "UPDATE menu SET menuNombre='" . $this->getmenuNombre() . "',
              menuDescripcion='" . $this->getmenuDescripcion() . "'"
            . $idPadre . $deshabilitado;
        $sql .= " WHERE idMenu = " . $this->getIdMenu();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("menu->modificar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("menu->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();

        $sql = "DELETE FROM menu WHERE idMenu = " . $this->getIdMenu();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("menu->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("menu->eliminar: " . $base->getError());
        }
        return $resp;
    }


    public function listar($parametro = "")
    {
        $arreglo = null;
        $base = new BaseDatos();
        $sql = "SELECT * FROM menu ";

        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }

        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                $arreglo = array();
                while ($row = $base->Registro()) {

                    $objMenu = new Menu();
                    $objPadre = null;

                    if ($row['idPadre'] != null) {
                        $objPadre = new Menu();
                        $objPadre->setIdMenu($row['idPadre']);
                        $objPadre->cargar();
                    }

                    $objMenu->setear($row['idMenu'], $row['menuNombre'], $row['menuDescripcion'], $objPadre, $row['menuDeshabilitado']);
                    array_push($arreglo, $objMenu);
                }
            }
        }
        return $arreglo;
    }
}
