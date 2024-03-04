<?php 

    if (isset($_POST["btnLogin"])) {

        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";

        $error_form = $error_usuario || $error_clave;

        if (!$error_form) {            
            
            $url = DIR_SERV."/login";
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);
            $respuesta = consumir_servicios_REST($url, "POST", $datos);
            $obj = json_decode($respuesta);

            if (!$obj) {
                session_destroy();
                die(error_page("Examen SW 21_22", "Ha habido un error al consumir el servicio: $url"));
            }

            if (isset($obj->error)) {
                session_destroy();
                die(error_page("Examen SW 21_22", "Ha habido un error al consumir el servicio: ".$obj->error));
            }

            if (isset($obj->mensaje)) {
                $error_usuario = true;
            } else {

                $_SESSION["usuario"] = $obj->usuario->usuario;
                $_SESSION["clave"] = $obj->usuario->clave;
                $_SESSION["tipo"] = $obj->usuario->tipo;
                $_SESSION["api_session"] = $obj->api_session;
                $_SESSION["ult_accion"] = time();

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
    <title>Examen horarios</title>
    <style>

        .error{
            color: red;
        }

        .mensaje{
            font-size: 1.25em;
            color: blue;
        }

    </style>
</head>
<body>
    <h1>Login</h1>

    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php 
                if (isset($_POST["btnLogin"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*Usuario y/o clave incorrectos*</span>";
                    }
                }
            ?>
        </p>        

        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php 
                if (isset($_POST["btnLogin"]) && $error_clave) {
                    if ($_POST["clave"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>        

        <p><button type="submit" name="btnLogin">Login</button></p>

    </form>

    <?php 
        
        if (isset($_SESSION["seguridad"])) {
            echo "<span class='mensaje'>".$_SESSION["seguridad"]."</span>";
            session_destroy();
        }

    ?>

</body>
</html>