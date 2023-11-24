<?php
include_once('../estructura/header.php');
if($objSession->getVista()!=NULL){
    if ($objSession->getVista()->getIdRol() == 2) {
        $datos['usuarioNombre'] = $objSession->getUsuario()->getusuarioNombre();

        $usuario = new UsuarioController;
        $usuario = $usuario->buscar($datos)[0];
?>

<div class="container-fluid" style="margin-bottom: 15%">
<div class="container col-md-5 text-white mt-5 ">
        <h2>Mis Datos:</h2>
        <div class="mb-3">
                
                <table class="table table-striped table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>

                <?php
               
                    echo '<tr>';
                    echo '<td>' . $usuario->getIdUsuario() . '</td>';
                    echo '<td>' . $usuario->getusuarioNombre() . '</td>';
                    echo '<td>' . $usuario->getusuarioMail() . '</td>';
                    
                    echo '</tr>';
        
                ?>
                </table>

                <input class="btn btn-secondary mt-2 col-3" type="button" name="boton_editarDatos"  id="boton_editarDatos" value="EDITAR EMAIL">
                <input class="btn btn-secondary mt-2 mx-3 col-5" type="button" name="boton_contra"  id="boton_contra" value="CAMBIAR MI CONTRASEÑA">
        </div>
    </div>
    <div class="container-fluid col-md-5 text-white mt-5 d-none" id='editarDatos'>
        <h2>Editar Datos:</h2>
        <div class="mb-3">
            
        <form  id='form-editar' method="post" action="../Accion/ActualizarPerfil.php"class="needs-validation row text-white justify-content-center col-12" novalidate>
                <table class="table table-striped table-dark">
                    <tr>
                         
                        <th>Username:</th>
                        <th>Email:</th>
                    
                    </tr>
 
                    <tr>

                    <td><div class="col-lg-7 col-12"><?php echo $usuario->getusuarioNombre()?></div><div class="col-lg-7 col-12 d-none"><input value = '<?php echo $usuario->getusuarioNombre()?>' type="text" style="width: 150px;" pattern="[a-zA-Z]+\s?[0-9]*" name="usuarioNombre"></input>
                    </div><div class="col-lg-7 col-12 d-none"><input value = '<?php echo $usuario->getusuarioPass()?>' type="text" name="usuarioPass"></input></div></td>

                    <td><div class="col-lg-7 col-12 "><input value = '<?php echo $usuario->getusuarioMail()?>' type="email" style="width: 250px;" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.([a-z]{3})(\.[a-z]{2})*$" name="usuarioMail" required></input><div class="invalid-feedback">
                    Ingrese un email valido!</div>
                    <div class="valid-feedback">
                    Correcto!</div></div><div class="col-lg-7 col-12 d-none"><input value = '<?php echo $usuario->getIdUsuario()?>' type="number"  name="idUsuario" required></input></div></td>
                    
                    </tr>
            

                </table>

                <input class="btn btn-success mt-2 col-3" type="submit" name="boton_enviar"  id="boton_enviar" value="GUARDAR">
                <input class="btn btn-danger mx-4 mt-2 col-3" name="boton_cancelar" type="button" id="boton_cancelar" value="CANCELAR">
            </form>
        </div>
    </div>

    <div class="container-fluid col-md-9 text-white mt-5 d-none" id='editarContraseña'>
        <h2>Cambiar Contraseña:</h2>
        <div class="mb-3">
            
        <form  id='form-contraseña' method="post" action="../Accion/ActualizarPerfil.php"class="needs-validation row text-white justify-content-center col-12" novalidate>
                <table class="table table-striped table-dark">
                    <tr>
                         
                        <th>Username:</th>
                        <th>Ingrese contraseña actual:</th>
                        <th>Ingrese contraseña nueva:</th>
                        <th>Confirmar contraseña:</th>
                    
                    </tr>
 
                    <tr>

                    <td><div class="col-lg-7 col-12"><?php echo $usuario->getusuarioNombre()?></div>
                        <div class="col-lg-7 col-12 d-none "><input  value = '<?php echo $usuario->getusuarioNombre()?>' type="text" name="usuarioNombre"></input></div>
                        <div class="col-lg-7 col-12 d-none"><input value = '<?php echo $usuario->getusuarioPass()?>' type="text" name="usuarioPass"></input></div>
                    </td>

                    <td>
                        <div class="col-lg-8 col-12"><input type="password" class="form-control" id="usuarioPassVieja" name="usuarioPassVieja" required>
                        <div class="invalid-feedback">
                                Ingrese una contraseña!
                            </div>
                            <div class="valid-feedback password-correcta">
                            Correcto!
                            </div>
                    </div>

                        <div class="col-lg-7 col-12 d-none"><input value = '<?php echo $usuario->getusuarioMail()?>' type="email" name="usuarioMail" ></input></div>
                        <div class="col-lg-7 col-12 d-none"><input value = '<?php echo $usuario->getIdUsuario()?>' type="number"  name="idUsuario"></input></div>
                    </td>

                    <td>
                        <div class="col-lg-8 col-12"><input type="password" class="form-control" name="usuarioPassNueva" id="usuarioPassNueva" required>
                            <div class="invalid-feedback">
                                Ingrese una contraseña!
                            </div>
                            <div class="invalid-password" style="display: none; color: red;">
                            Las contraseñas no coinciden
                            </div>
                            <div class="valid-feedback password-correcta">
                            Correcto!
                            </div>
                        </div>
                        <div class="col-10 col-lg-7 d-none"><input type="password" class="form-control" name="usuarioPass" id="usuarioPass">
                        <div class="col-10 col-lg-7 d-none"><input type="text" id="usuarioPassSesion" disabled value='<?php echo $usuario->getusuarioPass()?>' class="form-control" name="usuarioPassSesion" >
                        </div>
                    </td>
                    
                    <td>
                        <div class="col-lg-8 col-12"><input type="password" id="usuarioPassRep" class="form-control" name="usuarioPassRep" requierd> 
                            <div class="invalid-feedback">
                                Ingrese una contraseña!
                            </div>
                            <div class="invalid-password" style="display: none; color: red;">
                                Las contraseñas no coinciden
                            </div>
                            </div>
                    </td>

                    
                    </tr>
            

                </table>

                <input class="btn btn-success mt-2 col-3" type="submit" name="boton_enviar"  id="boton_enviar" value="GUARDAR">
                <input class="btn btn-danger mx-4 mt-2 col-3" name="boton_cancelar" type="button" id="boton_cancelar" value="CANCELAR">
            </form>
        </div>
    </div>
</div>

<script src="js/perfil.js"></script>
<script src="../js/validarContraseñaIguales.js"></script>
<script src="../js/md5.js"></script>
<?php
    }else{
        header('Location: ../paginas/home.php');
    }
}else{
    header('Location: ../paginas/home.php');
}
include_once("../estructura/footer.php")
?>