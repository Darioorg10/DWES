<?php
session_start();
require "src/ctes_funciones.php";

if (isset($_POST["btnContBorrar"])) {

    try {
        $conexion = mysqli_connect(HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    } catch (Exception $e) {
        die(error_page("Videoclub", "<p>No se ha podido realizar la conexión con la base de datos: ".$e->getMessage()."</p>"));
    }    

    try {
        $consulta = "delete from peliculas where idPelicula='" . $_POST['btnContBorrar'] . "'";
        $resultado = mysqli_query($conexion, $consulta);
        // unlink() hay que borrar la imagen
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("Videoclub", "<p>No se ha podido borrar la consulta: " . $e->getMessage() . "</p>"));
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 0 auto;
            width: 80%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 0.5rem 2rem;
            text-align: center;
        }

        th {
            background-color: #CCC;
        }

        .enlace {
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        img {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Video Club</h1>
    <h2>Películas</h2>
    <h3>Listado de películas</h3>
    <?php
    // Nos conectamos con la base de datos
    try {
        $conexion = mysqli_connect(HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("Videoclub", "<p>No se ha podido realizar la conexión con la base de datos: " . $e->getMessage() . " </p>"));
    }

    // Hacemos la consulta para mostrar la tabla
    require "vistas/vista_tabla.php";

    // Listamos los datos
    if (isset($_POST["btnDetalle"])) {
        require "vistas/vista_detalle.php";
    } else if (isset($_POST["btnBorrar"])) { // Borramos los datos                      
        require "vistas/vista_borrar.php";
    }

    ?>
    </table>
</body>

</html>