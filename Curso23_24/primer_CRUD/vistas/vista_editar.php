<?php 
    if (isset($_POST["btnEditar"])) {
        $id_usuario = $_POST["btnEditar"];
    } else {
        $id_usuario = $_POST["btnContEditar"];
    }

    try {
        $consulta = "select * from usuarios where id_usuario='".$id_usuario."'";
        $resultado = mysqli_query($conexion, $consulta);            
    } catch (Exception $e) {
        mysqli_close($conexion); // Cerramos la conexión
        die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");                            
    }

    // Comprobamos que exista
    if (mysqli_num_rows($resultado) > 0) { // Si hemos obtenido alguna tupla

        if (isset($_POST["btnEditar"])){
            $datos_usuario = mysqli_fetch_assoc($resultado);                
            $nombre = $datos_usuario["nombre"];
            $usuario = $datos_usuario["usuario"];
            // $clave = $datos_usuario["clave"];
            $email = $datos_usuario["email"];
        } else {
            $nombre = $_POST["nombre"];
            $usuario = $_POST["usuario"];
            // $clave = $_POST["clave"];
            $email = $_POST["email"];
        }
        mysqli_free_result($resultado);
    } else {
        $mensaje_error_usuario = "<p>El usuario seleccionado ya no está registrado en la BD</p>";
    }     

    if (isset($mensaje_error_usuario)) {
        echo $mensaje_error_usuario;
    } else {
    ?>
    <p>                
        <h2>Editando el usuario <?php echo $id_usuario;?></h2>
        <form action='index.php' method='post'>
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php echo $nombre;?>">
        <?php 
        if (isset($_POST["btnContEditar"]) && $error_nombre) {
            if ($_POST["nombre"] == "") {
                echo "<span class='error'>*Campo obligatorio*</span>";
            } else {
                echo "<span class='error'>*Has puesto más de 30 carácteres*</span>";
            }
        }
    ?>
    </p>
    <p>                
        <label for="usuario">Usuario: </label>
        <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php echo $usuario;?>">
        <?php 
        if (isset($_POST["btnContEditar"]) && $error_usuario) {
            if ($_POST["usuario"] == "") {
                echo "<span class='error'>*Campo obligatorio*</span>";
            } else if(strlen($_POST["usuario"]) > 20){
                echo "<span class='error'>*Has puesto más de 20 carácteres*</span>";
            } else {
                echo "<span class='error'>*El usuario está repetido*</span>";
            }
        }
        ?>
    </p>
    <p>                
        <label for="clave">Contraseña: </label>
        <input type="text" name="clave" id="clave" maxlength="15" placeholder="Editar contraseña">
        <?php 
            if (isset($_POST["btnContEditar"]) && $error_clave) {
                echo "<span class='error'>*La contraseña tiene más de 15 carácteres*</span>";
            }
        ?>
    </p>
    <p>                
        <label for="email">Email: </label>
        <input type="text" name="email" id="email" maxlength="50" value="<?php echo $email;?>">
        <?php 
        if (isset($_POST["btnContEditar"]) && $error_email) {
            if ($_POST["email"] == "") {
                echo "<span class='error'>*Campo obligatorio*</span>";
            } else if(strlen($_POST["email"]) > 50) {
                echo "<span class='error'>*Has puesto más de 50 carácteres*</span>";
            } else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                echo "<span class='error'>*Email sintácticamente incorrecto*</span>";
            } else {
                echo "<span class='error'>*El email está repetido*</span>";
            }
        }
    ?>
    </p>
            
    <p><button type='submit' name='btnContEditar' value="<?php echo $id_usuario;?>">Continuar</button>
    <button type='submit'>Volver</button></p>
    </form>
<?php
    }                
?>