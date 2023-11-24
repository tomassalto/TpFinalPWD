<?php
class Usuario
{
    private $idUsuario;
    private $usuarioNombre;
    private $usuarioPass;
    private $usuarioMail;
    private $usuarioDeshabilitado;
    private $mensajeOperacion;


    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function setUsuarioNombre($usuarioNombre)
    {
        $this->usuarioNombre = $usuarioNombre;
    }

    public function setUsuarioPass($usuarioPass)
    {
        $this->usuarioPass = $usuarioPass;
    }

    public function setUsuarioMail($usuarioMail)
    {
        $this->usuarioMail = $usuarioMail;
    }

    public function setUsuarioDeshabilitado($usuarioDeshabilitado)
    {
        $this->usuarioDeshabilitado = $usuarioDeshabilitado;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }


    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function getUsuarioNombre()
    {
        return $this->usuarioNombre;
    }

    public function getUsuarioPass()
    {
        return $this->usuarioPass;
    }

    public function getUsuarioMail()
    {
        return $this->usuarioMail;
    }

    public function getUsuarioDeshabilitado()
    {
        return $this->usuarioDeshabilitado;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }



    public function __construct()
    {
        $this->idUsuario = "";
        $this->usuarioNombre = "";
        $this->usuarioPass = "";
        $this->usuarioMail = "";
        $this->usuarioDeshabilitado = "";
        $this->mensajeOperacion = "";
    }

    public function setear($idUsuario, $usuarioNombre, $usuarioPass, $usuarioMail, $usuarioDeshabilitado)
    {
        $this->setIdUsuario($idUsuario);
        $this->setUsuarioNombre($usuarioNombre);
        $this->setUsuarioPass($usuarioPass);
        $this->setUsuarioMail($usuarioMail);
        $this->setUsuarioDeshabilitado($usuarioDeshabilitado);
    }

    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        if ($this->getIdUsuario() != '') {
            $sql = "SELECT * FROM usuario WHERE idUsuario = " . $this->getIdUsuario();
        }
        //echo $sql;
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear($row['idUsuario'], $row['usuarioNombre'], $row['usuarioPass'], $row['usuarioMail'], $row['usuarioDeshabilitado']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("usuario->listar: " . $base->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "INSERT INTO usuario(usuarioNombre,usuarioPass,usuarioMail) 
                VALUES('" . $this->getUsuarioNombre() . "','"
            . $this->getUsuarioPass() . "','"
            . $this->getUsuarioMail() . "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdUsuario($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->insertar: " . $base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $deshabilitado = $this->getUsuarioDeshabilitado();
        if ($deshabilitado == null) {
            //PARA EL CASO QUE QUIERA MODIFICAR OBJETO SIN TOCAR usuarioDeshabilitado
            $deshabilitado == '';
        } else if ($deshabilitado == 'habilitar') {
            //PARA EL CASO QUE QUIERA HABILITARLO
            $deshabilitado = ",usuarioDeshabilitado=NULL";
        } else {
            //PARA EL CASO QUE QUIERA DESHABILITARLO
            $deshabilitado = ",usuarioDeshabilitado='" . $this->getUsuarioDeshabilitado() . "' ";
        }
        $sql = "UPDATE usuario SET usuarioNombre='" . $this->getUsuarioNombre() . "',
        usuarioPass='" . $this->getUsuarioPass() . "',
        usuarioMail='" . $this->getUsuarioMail() . "' $deshabilitado
        WHERE idUsuario=" . $this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("usuario->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM usuario WHERE idUsuario=" . $this->getIdUsuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setMensajeOperacion("usuario->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("usuario->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static function listar($parametro = "")
    {
        $arreglo = null;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                $arreglo = array();
                while ($row = $base->Registro()) {
                    $obj = new Usuario();
                    $obj->setear($row['idUsuario'], $row['usuarioNombre'], $row['usuarioPass'], $row['usuarioMail'], $row['usuarioDeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("Usuario->listar: " . $base->getError());
        }
        return $arreglo;
    }
}
