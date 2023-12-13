<?php
if (isset($_POST["btnContBorrar"])) {
    // Hacemos la conexión con la base de datos
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro2");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        session_destroy();
        die(error_page("Primer CRUD", "<p>No has podido conectarte a la base de datos: " . $e->getMessage() . " </p>"));
    }

    // Hacemos el delete para borrar los datos
    try {
        $consulta = "delete from usuarios where id_usuario=" . $_POST["btnContBorrar"] . "";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        die(error_page("Primer CRUD", "<p>No has podido hacer el delete: " . $e->getMessage() . " </p>"));
    }

    $_SESSION["mensaje"] = "Usuario borrado con éxito";
    session_destroy();
    mysqli_close($conexion);
}

if (isset($_POST["btnContInsertar"])) {
    $error_nombre = $_POST["nombreInsertado"] == "" || strlen($_POST["nombreInsertado"]) > 30;
    $error_usuario = $_POST["usuarioInsertado"] == "" || strlen($_POST["usuarioInsertado"]) > 50;

    if (!$error_usuario) {
        try {
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro2");
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {                
            die("<p>No has podido conectarte a la base de datos: ".$e->getMessage()." </p></body></html>");
        }

    $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuarioInsertado"]);

    }

    $error_clave = $_POST["claveInsertada"] == "" || strlen($_POST["claveInsertada"]) > 15;
    $error_email = $_POST["emailInsertado"] == "" || strlen($_POST["emailInsertado"]) > 50;

    if (!$error_email) {
        try {
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro2");
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {                
            die("<p>No has podido conectarte a la base de datos: ".$e->getMessage()." </p></body></html>");
        }

        $error_email = repetido($conexion, "usuarios", "email", $_POST["emailInsertado"]);
    }

    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

    if (!$error_form) {
        // Hacemos la inserción
        try {
            $consulta = "insert into usuarios (nombre, usuario, clave, email) values ('".$_POST["nombreInsertado"]."','".$_POST["usuarioInsertado"]."','".md5($_POST["claveInsertada"])."','".$_POST["emailInsertado"]."')";
            $resultado = mysqli_query($conexion, $consulta);                
        } catch (Exception $e) {
            session_destroy();
            die("<p>No has podido hacer el select: ".$e->getMessage()." </p></body></html>");
        }            
        header("Location:index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        table {
            border-collapse: collapse;
        }

        .error{
            color: red;
        }

        .txt_centrado{
            text-align: center;
        }

        .no_bordes{
            border: none;
        }

        table,
        td,
        th {
            border: 1px solid black;
            padding: 1rem;
        }
    </style>
</head>

<body>
    <h1>Primer Login - Vista Admin</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_logueado["nombre"]; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
            
            <?php
                // Hacemos la conexión con la base de datos
                try {
                    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro2");
                    mysqli_set_charset($conexion, "utf8");
                } catch (Exception $e) {
                    session_destroy();
                    die("<p>No has podido conectarte a la base de datos: " . $e->getMessage() . " </p></body></html>");
                }

                // Hacemos el select para sacar los datos
                try {
                    $consulta = "select * from usuarios where tipo<>'admin'";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    session_destroy();
                    die("<p>No has podido hacer el select: " . $e->getMessage() . " </p></body></html>");
                }

                echo "<h2 class='txt_centrado'>Listado de los usuarios</h2>";
                echo "<table id='tb_principal'>";
                echo "<tr></th>Nombre de usuario</th><th>Borrar</th><th>Editar</th><th>+</th></tr>";

                while ($tupla = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    // ¡¡¡¡¡¡¡¡¡¡¡ IMPORTANTE HACER UN FORM POR CADA BOTÓN !!!!!!!!!!!!
                    echo "<td><form action='index.php' method='post'><button class='enlace' name='btnDetalle' value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</button></form></td>";
                    echo "<td><form action='index.php' method='post'><input type='hidden' name='nombreOculto' value='" . $tupla["nombre"] . "'></input><button class='enlace' name='btnBorrar' value='" . $tupla["id_usuario"] . "'>X</button></form></td>";
                    echo "<td><form action='index.php' method='post'><button class='enlace' name='btnEditar' value='" . $tupla["id_usuario"] . "'>~</button></form></td>";
                    echo "<td class='no_bordes'></td>";
                    echo "</tr>";
                }


                ?>
            </table>
        </form>
    </div>
    <?php
    if (isset($_POST["btnDetalle"])) {
        if (!isset($conexion)) {
            // Hacemos la conexión con la base de datos
            try {
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro2");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                session_destroy();
                die("<p>No has podido conectarte a la base de datos: " . $e->getMessage() . " </p></body></html>");
            }
        }

        // Hacemos el select para sacar los datos
        try {
            $consulta = "select * from usuarios where id_usuario='" . $_POST["btnDetalle"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            die("<p>No has podido hacer el select: " . $e->getMessage() . " </p></body></html>");
        }

        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<p><strong>Nombre: </strong>" . $tupla["nombre"] . "</p>";
            echo "<p><strong>Usuario: </strong>" . $tupla["usuario"] . "</p>";
            echo "<p><strong>Email: </strong>" . $tupla["email"] . "</p>";
        }

        echo "<form action='index.php' method='post'><button name='btnVolver'>Volver</button></form>";

        // En cada select tenemos que mostrar el resultado
        mysqli_free_result($resultado);
        mysqli_close($conexion);
    } else if (isset($_POST["btnBorrar"])) {
        echo "<p>Se dispone a borrar al usuario " . $_POST["nombreOculto"] . " con id: " . $_POST["btnBorrar"] . "</p>";
        echo "<form action='index.php' method='post'><button name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button>";
        echo "<button name='btnAtras'>Atrás</button></form>";
    } else if (isset($_POST["btnInsertar"])) {
    ?>
        <form action="index.php" method="post">
            <p><label for="nombreInsertado">Nombre:</label>
                <input type="text" name="nombreInsertado" id="nombreInsertado"/>
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_nombre) {
                    if ($_POST["nombreInsertado"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*Máx. 30 carácteres*</span>";
                    }
                }
                ?>
            </p>

            <p><label for="usuarioInsertado">Usuario:</label>
                <input type="text" name="usuarioInsertado" id="usuarioInsertado"/>
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_usuario) {
                    if ($_POST["usuarioInsertado"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else if (strlen($_POST["usuarioInsertado"]) > 50) {
                        echo "<span class='error'>*Máx. 50 carácteres*</span>";
                    } else {
                        echo "<span class='error'>*Usuario repetido*</span>";
                    }
                }
                ?>
            </p>

            <p><label for="claveInsertada">Clave:</label>
                <input type="text" name="claveInsertada" id="claveInsertada" />
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_clave) {
                    if ($_POST["claveInsertada"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*Máx. 15 carácteres*</span>";
                    }
                }
                ?>
            </p>

            <p><label for="emailInsertado">Email:</label>
                <input type="text" name="emailInsertado" id="emailInsertado" />
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_email) {
                    if ($_POST["emailInsertado"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else if (strlen($_POST["emailInsertado"]) > 50) {
                        echo "<span class='error'>*Máx. 50 carácteres*</span>";
                    } else {
                        echo "<span class='error'>*Email repetido*</span>";
                    }
                }
                ?>
            </p>

            <p><button type="submit" name="btnContInsertar">Continuar</button><button type="submit" name="btnVolver">Volver</button></p>

        </form>
    <?php
    } else if(isset($_POST["btnEditar"])){
        if (isset($_POST["btnEditar"])) {
            $id_usuario = $_POST["btnEditar"];
        } else {
            $id_usuario = $_POST["btnContEditar"];
        }
    
        try {
            $consulta = "select * from usuarios where id_usuario='".$id_usuario."'";
            $resultado = mysqli_query($conexion, $consulta);            
        } catch (Exception $e) {
            session_destroy();
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
        <p>
            <input type="radio" name="privilegio" id="admin"><label for="admin">Admin</label>
            <input type="radio" name="privilegio" id="normal"><label for="normal">Normal</label>
        </p>
                
        <p><button type='submit' name='btnContEditar' value="<?php echo $id_usuario;?>">Continuar</button>
        <button type='submit'>Volver</button></p>
        </form>
    <?php
    }
}
    ?>
</body>

</html>