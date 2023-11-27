<?php
require "src/ctes_funciones.php";

if (isset($_POST["btnContBorrarFoto"])) {
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("Error", "<p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }
    try {
        $consulta = "update peliculas set caratula='no_imagen.jpg' WHERE idPelicula='" . $_POST["id_peli"] . "'";
        mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }
    if (file_exists("Img/" . $_POST["caratula_bd"])) unlink("Img/" . $_POST["caratula_bd"]);
    $_POST["caratula_bd"] = "no_imagen.jpg";
}

if (isset($_POST["btnContBorrar"])) {
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("Error", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
    }

    try {
        $consulta = "delete from peliculas where idPelicula='" . $_POST["btnContBorrar"] . "'";
        mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        die(error_page("Error", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
    }

    // Si la foto no es la predterminada la unlinkeamos
    if ($_POST["caratula_bd"] != "no_imagen.jpg") {
        unlink("Img/" . $_POST["caratula_bd"]);
    }

    mysqli_close($conexion);
    header("Location:index.php");
    exit();
}

if (isset($_POST["btnContEditar"])) {
    $error_titulo = $_POST["titulo"] == "" || strlen($_POST["titulo"]) > 15;
    $error_director = $_POST["director"] == "" || strlen($_POST["director"]) > 20;
    $error_tematica = $_POST["tematica"] == "" || strlen($_POST["tematica"]) > 15;
    $error_sinopsis = $_POST["sinopsis"] == "";
    $error_caratula = $_FILES["caratula"]["name"] != "" && ($_FILES["caratula"]["error"] || !getimagesize($_FILES["caratula"]["tmp_name"]) || !explode(".", $_FILES["caratula"]["name"]));
    $error_form = $error_titulo || $error_director || $error_tematica || $error_sinopsis || $error_caratula;

    if (!$error_form) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
        }

        // Si se pone algo en la carátula
        if ($_FILES["caratula"]["name"] != "") {
            $nombre_array = explode(".", $_FILES["caratula"]["name"]);
            $nombre_foto = "peli_" . $_POST["id_peli"] . "." . end($nombre_array);
            @$var = move_uploaded_file($_FILES["caratula"]["tmp_name"], "Img/" . $nombre_foto);
            if ($var) {
                try {
                    if ($_POST["caratula_bd"] != $nombre_foto && $_POST["caratula_bd"] != "no_imagen.jpg") {
                        unlink("Img/" . $_POST["caratula_bd"]);
                    }
                    $consulta = "update peliculas set titulo='" . $_POST["titulo"] . "', director='" . $_POST["director"] . "', tematica='" . $_POST["tematica"] . "', caratula='" . $nombre_foto . "' where idPelicula = '" . $_POST["id_peli"] . "'";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    unlink("Img/" . $nombre_foto);
                    mysqli_close($conexion);
                    die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
                }
            }
        } else {
            try {
                $consulta = "update peliculas set titulo='" . $_POST["titulo"] . "', director='" . $_POST["director"] . "', tematica='" . $_POST["tematica"] . "', sinopsis='" . $_POST["sinopsis"] . "', caratula='".$_POST["caratula_bd"]."' where idPelicula = '" . $_POST["id_peli"] . "'";
                mysqli_query($conexion, $consulta); 
            } catch (Exception $e) {
                mysqli_close($conexion);
                die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
            }
        }

        mysqli_close($conexion);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Club</title>
    <style>
        table {
            width: 100%;
            text-align: center;
        }

        table,
        tr,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            background-color: #CCC;
        }

        img {
            height: 100px;
        }

        .enlace {
            background: none;
            color: blue;
            text-decoration: underline;
            border: none;
            cursor: pointer;
        }

        .negrita {
            font-weight: bold;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Video Club</h1>
    <h2>Películas</h2>
    <h3>Listado de películas</h3>
    <table>
        <tr>
            <th>id</th>
            <th>Título</th>
            <th>Carátula</th>
            <th>
                <form action="index.php" method="post"><button class="enlace negrita" type="submit" name="btnInsertar">Películas+</button></form>
            </th>
        </tr>
        <?php
        // Nos conectamos a la base de datos
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("Error", "<p>No se ha podido acceder a la base de datos: " . $e->getMessage() . "</p>"));
        }

        // Gogemos los datos
        try {
            $consulta = "select * from peliculas";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("Error", "<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }

        // Si hay películas
        if (mysqli_num_rows($resultado) > 0) {
            // Una vez recogido los datos, mostramos por pantalla
            while($tupla = mysqli_fetch_assoc($resultado)) {                
                echo "<tr><td>" . $tupla["idPelicula"] . "</td>
                <td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla["idPelicula"]."' name='btnDetalle' title='Detalles de la pelicula'>" . $tupla["titulo"] . "</button></form></td>
                <td><img src='Img/" . $tupla["caratula"] . "' alt='Caratula de pelicula'></td>
                <td><form action='index.php' method='post'><input type='hidden' name='foto' value='" . $tupla["caratula"] . "' /><button class='enlace' type='submit' name='btnBorrar' value='" . $tupla["idPelicula"] . "'>Borrar</button> - <button class='enlace' type='submit' name='btnEditar' value='" . $tupla["idPelicula"] . "'>Editar</button></form></td>
                </tr>";
            }
        }
        mysqli_free_result($resultado);
        mysqli_close($conexion);
        ?>
    </table>

    <?php
    if (isset($_POST["btnInsertar"]) || isset($_POST["btnContInsertar"])) {
        require "vistas/vista_insertar.php";
    }
    if (isset($_POST["btnBorrar"])) {
        require "vistas/vista_conf_borrar.php";
    }
    if (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarFoto"])
    || isset($_POST["btnContBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"])) {
        require "vistas/vista_editar.php";
    }
    if (isset($_POST["btnDetalle"])) {
        require "vistas/vista_detalles.php";
    }
    ?>
</body>

</html>