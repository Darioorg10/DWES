<?php
if (isset($_POST["btnVolver"])) {
    header("Location: index.php");
    exit();
}
if (isset($_POST["btnContRegistro"])) {
    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 20;
    if (!$error_usuario) {
        if (!isset($conexion)) {
            try {
                $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
            }
        }

        $error_usuario = repetido($conexion, "clientes", "usuario", $_POST["usuario"]);
        if (is_string($error_usuario)) {
            mysqli_close($conexion);
            die(error_page("ERROR", "<p>Ha habido un error: " . $error_usuario . "</p>"));
        }
    }
    $error_clave = $_POST["clave"] == "" || strlen($_POST["clave"]) > 15 || $_POST["clave"] != $_POST["clave2"];
    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"]
        || !getimagesize($_FILES["foto"]["tmp_name"]) || !explode('.', $_FILES['foto']['name'])
        || $_FILES['foto']['size'] > 500 * 1024);

    $error_form = $error_usuario || $error_clave || $error_foto;

    if (!$error_form) {
        if (!isset($conexion)) {
            try {
                $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
            }
        }

        try {
            $consulta = "insert into clientes (usuario, clave) values ('" . $_POST["usuario"] . "', '" . md5($_POST["clave"]) . "')";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
        }

        if ($_FILES["foto"]["name"] != "") {
            $last_id = mysqli_insert_id($conexion);
            $nombre_array = explode(".", $_FILES["foto"]["name"]);
            $nombre_foto = "img" . $last_id . "." . end($nombre_array);
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Images/" . $nombre_foto);
            if ($var) {
                try {
                    $consulta = "update clientes set foto='" . $nombre_foto . "' where id_cliente = '" . $last_id . "'";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    unlink("Images/" . $nombre_foto);
                    mysqli_close($conexion);
                    die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
                }
            }
        }
        
        $_SESSION["usuario"] = $_POST["usuario"];
        $_SESSION["clave"] = md5($_POST["clave"]);
        $_SESSION["ultima_accion"] = time();
        mysqli_free_result($resultado);
        mysqli_close($conexion);
        header("Location: index.php");
        exit();
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
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Nombre de usuario: </label>
            <input type="text" id="usuario" name="usuario" maxlength="20" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php
            if (isset($_POST["btnContRegistro"]) && $error_usuario) {
                if ($_POST["usuario"] == "")
                    echo "<span class='error'> Campo vacío.</span>";
                else if (strlen($_POST["usuario"]) > 20)
                    echo "<span class='error'> Has superado los 20 caracteres.</span>";
                else
                    echo "<span class='error'> Usuario repetido.</span>";
            }
            ?>
        </p>

        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" id="clave" name="clave" maxlength="15">
            <?php
            if (isset($_POST["btnContRegistro"]) && $error_clave) {
                if ($_POST["clave"] == "")
                    echo "<span class='error'> Campo vacío.</span>";
                else if (strlen($_POST["clave"]) > 15)
                    echo "<span class='error'> Has superado los 15 caracteres.</span>";
                else
                    echo "<span class='error'> Las contraseñas no coinciden.</span>";
            }
            ?>

        </p>
        <p>
            <label for="clave2">Contraseña: </label>
            <input type="password" id="clave2" name="clave2" maxlength="15">
        </p>
        <p>
            <label for="foto">Foto: </label>
            <input type="file" id="foto" name="foto" accept="image/*">
            <?php
            if (isset($_POST["btnContRegistro"]) && $error_foto) {
                if ($_FILES["foto"]["error"])
                    echo "<span class='error'> Ha habido un error al subir el archivo.</span>";
                else if (!getimagesize($_FILES["foto"]["tmp_name"]))
                    echo "<span class='error'> El archivo subido no es una imagen.</span>";
                else if (!explode('.', $_FILES['foto']['name']))
                    echo "<span class='error'> El archivo subido no tiene extensión.</span>";
                else
                    echo "<span class='error'> El archivo subido supera los 500KB.</span>";
            }
            ?>

        </p>
        <p>
            <button type="submit" name="btnVolver">Volver</button>
            <button type="submit" name="btnContRegistro">Continuar</button>
        </p>
    </form>
</body>

</html>