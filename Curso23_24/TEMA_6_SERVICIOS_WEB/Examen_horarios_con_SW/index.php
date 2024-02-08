<?php

    session_name("sesion-examen-horarios-sw-23-24");
    session_start();

    require "src/funciones_ctes.php";

    if (isset($_POST["btnLogin"])) {
        
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";

        $error_form = $error_usuario || $error_clave;

        // Si no hay error en el formulario intentamos iniciar sesión
        if (!$error_form) {
            $url = DIR_SERV."/login";
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = $_POST["clave"];

            $respuesta = consumir_servicios_REST($url, "GET", $datos);
            $obj = json_decode($respuesta);

            if (!$obj) {
                echo "Ha habido un error";
            }

            if (isset($obj->error)) {
                echo "Ha habido un error: ".$obj->error;
            }

            echo "Logueado";

        }

    }

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen2 PHP</title>
        <style>
            .error{color: red}
            .mensaje{font-size: 14px; color: blue;}
        </style>
    </head>
    <body>
        <h1>Examen2 PHP</h1>
        <h2>Horario de los Profesores</h2>

        <!-- Hacemos el formulario de login -->
        <form action="index.php" method="post">
            <p>
                <label for="usuario">Nombre de usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>"/>
                <?php
                    if (isset($_POST["btnLogin"]) && $_POST["usuario"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label>
                <input type="text" name="clave" id="clave" value=""/>
                <?php 
                    if (isset($_POST["btnLogin"]) && $_POST["clave"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                ?>
            </p>
            <p>
                <button type="submit" name="btnLogin">Iniciar sesión</button>
            </p>
        </form>
        <?php 
            if (isset($_SESSION["mensaje"])) {
                echo "<span class='mensaje'>".$_SESSION["mensaje"]."</span>";
                session_destroy();
            }
        ?>
    </body>
</html>