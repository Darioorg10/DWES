<?php
if (isset($_POST["btnEditar"])) {
    $_SESSION["mensaje"] = "El cliente con ID ".$_POST["id_cliente"]." fue editado con éxito.";
    header("Location: gest_clientes.php");
    exit();
}
if (isset($_POST["btnBorrar"])) {
    $_SESSION["mensaje"] = "El cliente con ID ".$_POST["id_cliente"]." fue borrado con éxito.";
    header("Location: gest_clientes.php");
    exit();
}
if (isset($_POST["btnContInsertar"])) {
    $_SESSION["mensaje"] = "El cliente con ID ".$_POST["id_cliente"]." fue insertado con éxito.";
    header("Location: gest_clientes.php");
    exit();
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
    <form action="../index.php" method="post">
        Bienvenido <strong> <?php echo $datos_usuario_logueado["usuario"]  ?></strong> -
        <button type="submit" name="btnSalir" class="enlace">Salir</button>
    </form>
    </p>
    <h3>Clientes</h3>
    <?php
if (isset($_SESSION["mensaje"])) {
    echo "<p>".$_SESSION["mensaje"]."</p>";
    unset($_SESSION["mensaje"]);
} 
?>
    <h4>Listado de los clientes (no 'admin')</h4>
    <?php
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        session_destroy();
        die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
    }

    try {
        $consulta = "select * from clientes";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
    }

    echo "<table>";
    echo "<tr><th>Usuario</th><th>Foto</th><th></th></tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>
        <td>" . $tupla["usuario"] . "</td>
        <td><img src='../Images/" . $tupla["foto"] . "' alt='Imagen del cliente '" . $tupla["usuario"] . "></td>
        <td><form action='../admin/gest_clientes.php' method='post'>
            <input type='hidden' name='id_cliente' value='".$tupla["id_cliente"]."'>
            <button type='submit' name='btnEditar'>Editar</button> - <br>
            <button type='submit' name='btnBorrar'>Borrar</button>
        </form></td>
        </tr>";
    }
    echo "</table>";
    mysqli_free_result($resultado);
    ?>
    <br>
    <?php
    if (isset($_POST["btnInsertar"])) {
    ?>
    <h1>Video Club</h1>
    <form action="gest_clientes.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="usuario">Nombre del usuario: </label> <br>
            <input type="text" id="usuario" name="usuario" maxlength="20" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
        </p>

        <p>
            <label for="clave">Clave del usuario: </label> <br>
            <input type="password" id="clave" name="clave" maxlength="15">
        </p>
        <p>
            <label for="foto">Foto: </label>
            <input type="file" id="foto" name="foto" accept="image/*">
        </p>
        <p>
        <button type='submit' name='btnContInsertar'>Agregar cliente</button>
        </p>
    </form>
    <?php
    } else {
    ?>
    <form action='gest_clientes.php' method='post'>
        <button type='submit' name='btnInsertar'>Agregar cliente</button>
    </form>
    <?php
    }
    ?>

</body>

</html>