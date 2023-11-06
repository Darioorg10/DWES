<?php

function error_page($title, $body){
    $page='<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>
    </head>
    <body>
        '.$body.'
    </body>
    </html>';
    return $page;
}

function repetido($conexion, $tabla, $columna, $valor){
    try {
        $consulta = "select * from $tabla where $columna='$valor'";
        $resultado = mysqli_query($conexion, $consulta);
        $respuesta = mysqli_num_rows($resultado) > 0; // Si el número de columnas obtenidas es mayor de 0 es que está repetido
        mysqli_free_result($resultado);
    } catch (Exception $e) {   
        mysqli_close($conexion);
        $respuesta = error_page("Práctica 1ºCRUD", "<h1>Práctica 1ºCRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>");
    }
    return $respuesta;
}

if(isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContInsertar"]))
{
    if (isset($_POST["btnContInsertar"])) { // Compruebo errores

        $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30;
        $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 20;
        if (!$error_usuario) {
            try {
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die(error_page("Práctica 1ºCRUD", "<h1>Práctica 1ºCRUD</h1><p>No se ha podido conectarse a la base de datos: ".$e->getMessage()."</p>"));
            }

            $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

            if (is_string($error_usuario)) {                
                die($error_usuario);
            }            
        }

        $error_clave = $_POST["clave"] == "" || strlen($_POST["clave"]) > 15;
        $error_email = $_POST["email"] == "" || strlen($_POST["email"]) > 50 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        if (!$error_email) {
            if (!isset($conexion)) { // Si no se ha abierto la conexión la abrimos
                try {
                    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
                    mysqli_set_charset($conexion, "utf8");
                } catch (Exception $e) {
                    die(error_page("Práctica 1ºCRUD", "<h1>Práctica 1ºCRUD</h1><p>No se ha podido conectarse a la base de datos: ".$e->getMessage()."</p>"));
                }
            }

            $error_email = repetido($conexion, "usuarios", "email", $_POST["email"]);

            if (is_string($error_email)) {                
                die($error_email);
            }            
        }

        $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

        if (!$error_form) { // HACEMOS AQUÍ SI NO HAY ERRORES PORQUE LOS HEADER LOCATION SE TIENEN QUE HACER ANTES DE PONER CÓDIGO HTML
            // Inserto en la BD y salto a index.php

            try {
                $consulta = "insert into usuarios (nombre, usuario, clave, email) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["email"]."')";
                mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion); // Cerramos la conexión
                die(error_page("Práctica 1ºCRUD", "<h1>Práctica 1ºCRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>"));
            }            

            // Cerramos la conexión
            mysqli_close($conexion);

            // Y vamos a index.php
            header("Location:index.php");
            exit;
        }

        // Por aquí continuo solo si hay errores en el formulario
        if (isset($conexion)) {
            mysqli_close($conexion);
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1ºCRUD</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <h1>Nuevo Usuario</h1>
    <form action="usuario_nuevo.php" method="post">
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["btnContInsertar"])) echo $_POST["nombre"];?>" maxlength="30">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_nombre) {
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
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["btnContInsertar"])) echo $_POST["usuario"];?>" maxlength="20">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_usuario) {
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
            <input type="password" name="clave" id="clave" maxlength="15"> <!-- Le damos solo 15 porque luego se le hace el md5 -->
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_clave) {
                    if ($_POST["clave"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*Has puesto más de 15 carácteres*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="email">Email: </label>
            <input type="text" name="email" id="email" value="<?php if(isset($_POST["btnContInsertar"])) echo $_POST["email"];?>" maxlength="50">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_email) {
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
            <button type="submit" name="btnContInsertar">Continuar</button>
            <button type="submit" name="btnVolver">Volver</button>
        </p>
    </form>    
</body>
</html>
<?php 
}
else { // Si se intenta acceder a esta página sin haber accedido antes al index, o se da al botón volver
    header("Location: index.php");
    exit;
}
?>