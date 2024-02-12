<?php
    
    // Si le da al botón de loguearse
    if (isset($_POST["btnLogin"])) {
        
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";

        $error_form = $error_usuario || $error_clave;

        if (!$error_form) {
            // Si no hay error en el formulario vamos a intentar loguearnos
            $url = DIR_SERV . "/login";
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);
            $respuesta = consumir_servicios_REST($url, "POST", $datos);
            $obj = json_decode($respuesta);

            if (!$obj) {
                session_destroy();
                die(error_page("Examen SW 22_23", "<h1>Librería</h1><p>Error consumiendo el servicio : $url</p>"));
            }

            if (isset($obj->error)) {
                session_destroy();
                die(error_page("Examen SW 22_23", "<h1>Librería</h1><p>Error consumiendo el servicio : ".$obj->error."</p>"));
            }

            if (isset($obj->mensaje)) {
                $error_usuario = true; // Cuando no está registrado
            } else { // Si el usuario existe y me he logueado correctamente                
                // Guardamos las sesiones y le redirigimos donde sea
                $_SESSION["usuario"] = $obj->usuario->lector;
                $_SESSION["clave"] = $obj->usuario->clave;
                $_SESSION["ult_accion"] = time();
                $_SESSION["api_session"] = $obj->api_session;

                if ($obj->usuario->tipo == "admin") {                    
                    header("Location:admin/gest_libros.php");
                } else {
                    header("Location:index.php");
                }

        }

    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página inicio</title>
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
        
        #libros{
            display: flex;
            justify-content: space-between;
            flex-flow: row wrap;
            width: 90%;
            margin: 0 auto;
        }

        #libros div{
            flex: 0 33%;
            text-align: center;
        }

        img{
            width: 100%;
            height: auto;
        }

        .error{
            color: red;
        }    

        .mensaje{
            font-size: 16px;
            color: blue;
        }


    </style>
</head>
<body>
    <h1>Librería</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Nombre de usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["btnLogin"])) echo $_POST["usuario"]; ?>">
            <?php 
                if (isset($_POST["btnLogin"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*Usuario y/o contraseña incorrectos*</span>";
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
        <button type="submit" name="btnLogin">Entrar</button>
    </form>
    <?php 
        if (isset($_SESSION["seguridad"])) {
            echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
            session_destroy();
        }
    ?>
    <h2>Listado de los libros</h2>
    <?php 

        require "vista_libros.php";

    ?>
</body>
</html>