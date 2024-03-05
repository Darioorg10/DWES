<?php 

    if (isset($_POST["btnEntrar"])) {
        
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";

        $error_form = $error_usuario || $error_clave;

        if (!$error_form) {
            
            // Si no hay error en el formulario intentamos loguearnos
            $url = DIR_SERV."/login";
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);
            $respuesta = consumir_servicios_REST($url, "POST", $datos);
            $obj = json_decode($respuesta);

            if (!$obj) {
                session_destroy();
                die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: $url"));
            }

            if (isset($obj->error)) {
                session_destroy();
                die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: ".$obj->error));
            }

            if (isset($obj->mensaje)) {
                $error_usuario = true;
            } else {
                $_SESSION["usuario"] = $obj->usuario->usuario;
                $_SESSION["clave"] = $obj->usuario->clave;
                $_SESSION["ult_accion"] = time();
                $_SESSION["api_session"] = $obj->api_session;

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
    <title>Gestión de guardias</title>
    <style>

        .error{
            color:red;
        }

    </style>
</head>
<body>
    <h1>Gestión de guardias</h1>

    <form action="index.php" method="post">

    <p>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
        <?php 
            if (isset($_POST["btnEntrar"]) && $error_usuario) {
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
            if (isset($_POST["btnEntrar"]) && $error_clave) {
                if ($_POST["clave"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                }
            }
        ?>
    </p>
    <p>
        <button type="submit" name="btnEntrar">Entrar</button>
    </p>

    </form>

</body>
</html>