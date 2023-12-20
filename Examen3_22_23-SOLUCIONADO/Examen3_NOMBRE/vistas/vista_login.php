<?php

if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 20;
    $error_clave = $_POST["clave"] == "" || strlen($_POST["clave"]) > 15;
    $error_form =  $error_usuario || $error_clave;

    if (!$error_form) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
        }

        try {
            $consulta = "select * from clientes where usuario = '" . $_POST["usuario"] . "' and clave = '" . md5($_POST["clave"]) . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
        }

        if (mysqli_num_rows($resultado) > 0) {
            $_SESSION["usuario"] = $_POST["usuario"];
            $_SESSION["clave"] = md5($_POST["clave"]);
            $_SESSION["ultima_accion"] = time();
            mysqli_free_result($resultado);
            mysqli_close($conexion);
            header("Location: index.php");
            exit();
        } else {
            $error_usuario = true;
        }

        mysqli_free_result($resultado);
        mysqli_close($conexion);
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Club</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Video Club</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Nombre de usuario: </label>
            <input type="text" id="usuario" name="usuario" maxlength="20" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php
            if (isset($_POST["btnLogin"]) && $error_usuario) {
                if ($_POST["usuario"] == "")
                    echo "<span class='error'> Campo vacío.</span>";
                else
                    echo "<span class='error'> Has superado los 20 caracteres.</span>";
            }
            ?>
        </p>

        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" id="clave" name="clave" maxlength="15">
            <?php
            if (isset($_POST["btnLogin"]) && $error_clave) {
                if ($_POST["clave"] == "")
                    echo "<span class='error'> Campo vacío.</span>";
                else
                    echo "<span class='error'> Has superado los 15 caracteres.</span>";
            }
            ?>

        </p>
        <p>
            <button type="submit" name="btnLogin">Entrar</button>
            <button type="submit" name="btnRegistro">Registrarse</button>
        </p>
    </form>
</body>
</html>
<?php
if (isset($_SESSION["seguridad"])) {
    echo "<p class='error'>".$_SESSION["seguridad"]."</p>";
    session_destroy();
} 
?>