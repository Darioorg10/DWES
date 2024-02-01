<?php

require "src/constantes_funciones.php"; // Nos traemos las funciones

if(isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContInsertar"]))
{
    if (isset($_POST["btnContInsertar"])) { // Compruebo errores

        $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30;
        $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 20;
        if (!$error_usuario) {
            // Miramos la conexión y vemos si está repetido
            $url = DIR_SERV."/repetido/usuarios/usuario/".urlencode($_POST["usuario"]); // Como lo van a teclear tenemos que poner el urlencode
            $respuesta = consumir_servicios_REST($url, "GET");
            $obj = json_decode($respuesta);
            
            if (!$obj) {
                die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
            }

            if (isset($obj->error)) {
                die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error: ".$obj->error."</p>"));
            }

            $error_usuario = $obj->repetido;
            
        }

        $error_clave = $_POST["clave"] == "" || strlen($_POST["clave"]) > 15;
        $error_email = $_POST["email"] == "" || strlen($_POST["email"]) > 50 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        if (!$error_email) {
            // Miramos la conexión y vemos si está repetido  
            $url = DIR_SERV."/repetido/usuarios/email/".$_POST["email"]; // Aquí no hay que poner el urlencode (ya ha pasado varios filtros el email), pero lo mejor es ponerlo siempre
            $respuesta = consumir_servicios_REST($url, "GET");
            $obj = json_decode($respuesta);
            
            if (!$obj) {
                die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
            }

            if (isset($obj->error)) {
                die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error: ".$obj->error."</p>"));
            }

            $error_email = $obj->repetido;
        }

        $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

        if (!$error_form) {
            // Inserto en la BD y salto a index.php
            $url = DIR_SERV."/crearUsuario";
            $datos["nombre"] = $_POST["nombre"];
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);
            $datos["email"] = $_POST["email"];
            $respuesta = consumir_servicios_REST($url, "POST", $datos);
            $obj = json_decode($respuesta);
            
            if (!$obj) {
                die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
            }

            if (isset($obj->error)) {
                die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error: ".$obj->error."</p>"));
            }            
            
            session_name("primer_CRUD_con_SW");
            session_start();
            $_SESSION["mensaje"] = "El usuario ha sido creado con éxito";
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
    <title>Práctica 1ºCRUD SW</title>
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