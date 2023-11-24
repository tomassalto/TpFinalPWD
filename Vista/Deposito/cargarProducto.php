<?php
include_once("../estructura/header.php");
if ($objSession->getVista() != NULL) {
    if ($objSession->getVista()->getIdRol() == 3) {
?>

        <div class="container-fluid">
            <div class="container-md w-50">
                <form method="post" action="/TpFinalPwd/Vista/Deposito/Accion/accionActualizarProductos.php" class="needs-validation row text-white my-4 justify-content-center" novalidate>
                    <div class="col-lg-7 col-12 mt-2">
                        <label>Nombre: </label><input type="text" pattern="[a-zA-Z]+\s?[a-zA-Z]*\s?[a-zA-Z]*\s?[a-zA-Z]*\s?[a-zA-Z]*" name="productoNombre" minlength="3" id="input_nombre" class="form-control text" required>
                        <div class="invalid-feedback">
                            Por favor ingrese un nombre valido! No se aceptan numeros y tiene que ser mayor a 3 letras.
                        </div>
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                    </div>
                    <div class="col-lg-7 col-12 mt-2">
                        <label>Stock del Producto: </label><input type="number" min='0' name="productoCantStock" id="input_stock" class="form-control" required>
                        <div class="invalid-feedback">
                            Ingrese una cantidad válida!
                        </div>
                        <div class="valid-feedback password-correcta">
                            Correcto!
                        </div>
                    </div>
                    <div class="col-lg-7 col-12 mt-2">
                        <label>Precio del Producto: </label><input type="number" min='0' name="productoPrecio" id="input_precio" class="form-control" required>
                        <div class="invalid-feedback">
                            Ingrese un precio valido válida!
                        </div>
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                    </div>
                    <div class="col-lg-7 col-12 mt-2">
                        <label>Ingrese url de la imagen: </label><input type="url" name="productoUrlImagen" id="input_productoUrlImagen" class="form-control" required>
                        <div class="invalid-feedback">
                            Ingrese un url válido!
                        </div>
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                    </div>

                    <input class="btn btn-dark mt-4 col-7" type="submit" name="boton_enviar" id="boton_enviar" value="SUBIR PRODUCTO">
            </div>
            </form>

        </div>
        </div>
        <script src="js/cargarProducto.js"></script>
<?php
    } else {
        header('Location: ../paginas/home.php');
    }
} else {
    header('Location: ../paginas/home.php');
}
include_once("../estructura/footer.php");
?>