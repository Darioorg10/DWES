<?php
if (isset($_POST["btnCambiarFoto"])) {
    var_dump($_POST);
    $error_form = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"]
        || !getimagesize($_FILES["archivo"]["tmp_name"]) || !explode('.', $_FILES['archivo']['name'])
        || $_FILES['archivo']['size'] > 500 * 1024;

    if (!$error_form) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("ERROR", "<p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }

        try {
            $array_nombre = explode('.', $_FILES['archivo']['name']);
            $ext = '.' . end($array_nombre); // El último sería la extensión
            $nombre_nuevo = "img_" . $datos_usuario_logueado["id_cliente"] . $ext;
            @$var = move_uploaded_file($_FILES['archivo']['tmp_name'], 'Images/' . $nombre_nuevo);
            if ($var) {
                if ($datos_usuario_logueado["foto"] != "no_imagen.jpg" && $datos_usuario_logueado["foto"] != $nombre_nuevo) {
                    unlink("Images/" . $datos_usuario_logueado["foto"]);
                }
                $consulta = "update clientes set foto='" . $nombre_nuevo . "' where id_cliente='" . $datos_usuario_logueado["id_cliente"] . "'";
                mysqli_query($conexion, $consulta);
            }
        } catch (Exception $e) {
            unlink("Images/" . $nombre_nuevo);

            mysqli_close($conexion);
            die(error_page("ERROR", "<p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>"));
        }
    }
}

if (isset($_POST["btnBorrarFoto"])) {
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("ERROR", "<p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }
    try {
        $consulta = "update clientes set foto='no_imagen.jpg' WHERE id_cliente='" . $datos_usuario_logueado["id_cliente"] . "'";
        mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }
    if (file_exists("Images/" . $datos_usuario_logueado["foto"]) && $datos_usuario_logueado["foto"] != "no_imagen.jpg") unlink("Images/" . $datos_usuario_logueado["foto"]);
    $datos_usuario_logueado["foto"] = "no_imagen.jpg";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Club</title>
    <style>
        .enlace {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: #CCC;
        }

        img {
            width: 100px;
        }
    </style>
</head>

<body>
    <h1>Video Club</h1>
    <p>
    <form action="index.php" method="post">
        Bienvenido <strong> <?php echo $datos_usuario_logueado["usuario"]  ?></strong> -
        <button type="submit" name="btnSalir" class="enlace">Salir</button>
    </form>
    </p>
    <p>
        <strong>Foto de perfil: </strong>
        <?php echo '<img src="Images/' . $datos_usuario_logueado["foto"] . '" alt="Imagen de perfil">' ?>
        <form action="index.php" method="post"><button type="submit" name="btnBorrarFoto">Eliminar Foto</button></form>
    </p>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="archivo">Seleccione nueva foto de perfil: </label>
            <input type="file" id="archivo" name="archivo" accept="image/*">
            <?php
            if (isset($_POST["btnCambiarFoto"]) && $error_form) {
                if ($_FILES["archivo"]["name"] == "")
                    echo "<span class='error'> *.</span>";
                else if ($_FILES["archivo"]["error"])
                    echo "<span class='error'> Ha habido un error al subir el archivo.</span>";
                else if (!getimagesize($_FILES["archivo"]["tmp_name"]))
                    echo "<span class='error'> El archivo subido no es una imagen.</span>";
                else if (!explode('.', $_FILES['archivo']['name']))
                    echo "<span class='error'> El archivo subido no tiene extensión.</span>";
                else 
                    echo "<span class='error'> El archivo subido supera los 500KB.</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnCambiarFoto">Cambiar Foto</button>
        </p>
    </form>
</body>

</html>