<?php 

    if (isset($_POST["btnLogin"])) {

        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";

        $error_form = $error_usuario || $error_clave;

        // Si no hay error vamos a intentar iniciar sesión
        if (!$error_form) {
            
            $url = DIR_SERV."/login";
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);

            $respuesta = consumir_servicios_REST($url, "POST", $datos);
            $obj = json_decode($respuesta);

            if (!$obj) {
                session_destroy();
                die(error_page("Examen4", "Ha habido un error en $url"));
            }

            if (isset($obj->error)) {
                session_destroy();
                die(error_page("Examen4", "Ha habido un error al consumir el servicio: ".$obj->error.""));
            }

            if (isset($obj->mensaje)) {
                $error_usuario = true;
            } else {                
                $_SESSION["usuario"] = $obj->usuario->usuario;
                $_SESSION["clave"] = $obj->usuario->clave;
                $_SESSION["ult_accion"] = time();
                $_SESSION["api_session"] = $obj->api_session;

                if ($obj->usuario->tipo == "tutor") {
                    header("Location:admin/index.php");
                } else {
                    header("Location:index.php");
                }                

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
    <title>Examen4 práctica</title>
    <style>

        .error{
            color:red;
        }

        .mensaje{
            font-size: 1.5em;
            color: blue;
        }

    </style>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <form action="index.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
        <?php 
            if (isset($_POST["btnLogin"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else {
                    echo "<span class='error'>*Usuario y/o contraseña incorrectos*</span>";
                }
            }
        ?>
        
        <br><br>

        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave">
        <?php 
            if (isset($_POST["btnLogin"]) && $error_clave) {
                if ($_POST["clave"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                }
            }
        ?>
        
        <br><br>

        <button type="submit" name="btnLogin">Login</button>
        <br><br>

        <?php 
            if (isset($_SESSION["mensaje"])) {
                echo "<span class='mensaje'>".$_SESSION["mensaje"]."</span>";
                session_destroy();
            }
        ?>

    </form>
</body>
</html>