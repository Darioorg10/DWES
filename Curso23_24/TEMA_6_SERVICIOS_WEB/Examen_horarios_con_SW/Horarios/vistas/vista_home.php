<?php 

    if (isset($_POST["btnLogin"])) {
        
        // Control de errores        
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";

        $error_form = $error_usuario || $error_clave;

        // Si ningún campo está vacío vamos a intentar loguearnos
        if (!$error_form) {
            $url = DIR_SERV."/login";
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);
            $respuesta = consumir_servicios_REST($url, "GET", $datos);
            $obj = json_decode($respuesta);

            if (!$obj) {
                session_destroy();
                die(error_page("Examen2 23_24 SW", "<h1>Horarios</h1><p>Error consumiendo el servicio : $url</p>"));
            }

            if (isset($obj->error)) {
                session_destroy();
                die(error_page("Examen2 23_24 SW", "<h1>Horarios</h1><p>Error consumiendo el servicio : ".$obj->error."</p>"));
            }

            if (isset($obj->mensaje)) { // Cuando mandábamos un mensaje era que ese no estaba en la base de datos
                $error_usuario = true;
            } else { // Si es correcto el usuario y la contraseña
                $_SESSION["usuario"] = $obj->usuario->usuario;
                $_SESSION["clave"] = $obj->usuario->clave;
                $_SESSION["ult_accion"] = time();
                $_SESSION["api_session"] = $obj->api_session;
                
                // Si ya nos hemos logueado vamos al index
                header("Location:index.php");
                exit;

            }

        }

    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 2 SW 23_24</title>
    <style>
        .error{
            color: red;
        }

        .mensaje{
            color: blue;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Librería</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php 
                if (isset($_POST["btnLogin"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*Usuario/clave incorrectos*</span>";
                    }                    
                }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave">
            <?php 
                if (isset($_POST["btnLogin"]) && $error_clave) {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">Login</button>
        </p>
    </form>
    <?php

        if (isset($_SESSION["seguridad"])) {
            echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
            session_destroy();
        }
        
    ?>    
</body>
</html>