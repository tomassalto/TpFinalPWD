<?php
include "../../configuracion.php";

$objSession = new SesionController();
$menues = [];
if ($objSession->activa()) {
    $idRoles = $objSession->getRol();
    $objMenuRol = new MenuRolController();
    $objRol = new RolController();
    $menues = $objMenuRol->menuesByIdRol($objSession->getVista());
    $objRoles = $objRol->obtenerObj($idRoles);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicTime</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/producto.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../alertas/dist/sweetalert2.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../alertas/dist/sweetalert2.all.min.js"></script>
    <script src="../jQuery/jquery-3.6.1.min.js"></script>
    <script src="../js/cerrarSesion.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="../js/cambiarVista.js"></script>
</head>

<body>

    <header class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a href="../../index.php" class="navbar-brand gamercompra text-white">
                MusicTime
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div>
                <div class="collapse navbar-collapse" id="navbarsExample03">
                    <ul class="navbar-nav me-auto mb-2 m-2 mb-sm-0">
                        <li><a href="../../index.php" role="button" style="color:white" class="px-2 mx-1 btn btn-lg">Home</a></li>
                        <?php
                        foreach ($menues as $objMenu) {
                            if ($objMenu->getmenuDeshabilitado() == NULL) {
                        ?>
                                <li><a href='<?php echo $objMenu->getmenuDescripcion() ?>' role="button" style="color:white" class="px-2 mx-1 btn btn-lg"><?php echo $objMenu->getmenuNombre() ?></a></li>
                        <?php
                            }
                        }
                        ?>
                    </ul>


                    <div class="text-end d-flex align-items-center">
                        <?php if ($objSession->activa()) {
                            if (count($objRoles) > 1) {
                        ?>
                                <select class="form-select form-select-lg me-2" id="cambiar_vista" aria-label=".form-select-lg example">
                                    <option selected disabled><?php echo $_SESSION['vista']->getRolDescripcion() ?></option>
                                    <?php
                                    foreach ($objRoles as $objRol) {
                                    ?>
                                        <option value="<?php echo $objRol->getIdRol() ?>"><?php echo $objRol->getRolDescripcion() ?></option>
                                <?php
                                    }
                                }
                                ?>
                                </select>
                                <button type='button' style="color:white" class='btn btn-lg me-2' onclick="cerrarSesion()">SALIR</button>
                            <?php
                        } else {
                            ?>
                                <a href='../sesion/IniciarSesion.php' style="color:white" class='btn btn-lg me-2'>INGRESAR</a>
                            <?php
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </header>