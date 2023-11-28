<?php
session_name("Practica9_Crud");
session_start();
require "src/ctes_funciones.php";

if (isset($_POST["btnContBorrar"])) {

    try {
        $conexion = mysqli_connect(HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    } catch (Exception $e) {
        session_destroy();
        die(error_page("Videoclub", "<p>No se ha podido realizar la conexión con la base de datos: ".$e->getMessage()."</p>"));
    }    

    try {
        $consulta = "delete from peliculas where idPelicula='" . $_POST['btnContBorrar'] . "'";
        $resultado = mysqli_query($conexion, $consulta);
        // unlink() hay que borrar la imagen
    } catch (Exception $e) {
        mysqli_close($conexion);
        session_destroy();
        die(error_page("Videoclub", "<p>No se ha podido realizar el borrado: " . $e->getMessage() . "</p>"));
    }

}

if (isset($_POST["btnContInsertar"])) {
    
    $error_titulo = strlen($_POST["titulo"]) > 15 || $_POST["titulo"] == "";
    $error_director = strlen($_POST["director"]) > 20 || $_POST["director"] == "";
    $error_sinopsis = $_POST["sinopsis"] == "";
    $error_tematica = strlen($_POST["tematica"]) > 15 || $_POST["tematica"] == "";    
    $error_foto = !getimagesize($_FILES["caratula"]["tmp_name"]) || $_FILES["caratula"]["error"] || !explode(".", $_FILES["caratula"]["name"]);    

    $error_form = $error_titulo || $error_director || $error_sinopsis || $error_tematica || $error_foto;

    if (!isset($conexion)) {
        try {
            $conexion = mysqli_connect(HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();            
            die(error_page("Videoclub", "<p>No se ha podido realizar la conexión: " . $e->getMessage() . "</p>"));
        }            
    }

    if (!$error_form) {
        try {
            // No insertamos la carátula del tirón, primero insertamos los datos y luego actualizamos con la foto
            $consulta = "insert into `peliculas`(`titulo`, `director`, `sinopsis`, `tematica`) values ('".$_POST["titulo"]."','".$_POST["director"]."','".$_POST["sinopsis"]."','".$_POST["tematica"]."')";
            $resultado = mysqli_query($conexion, $consulta);
            header("Location:index.php");
            exit;
        } catch (Exception $e) {
            session_destroy();            
            die(error_page("Videoclub", "<p>No se ha podido realizar la inserción: " . $e->getMessage() . "</p>"));
        }

        // Sacamos así la última id
        $ultima_id = mysqli_insert_id($conexion);
        $array_nombre = explode(".", $_FILES["caratula"]["name"]);
        $nombre = "imagen$ultima_id".end($array_nombre)."";

        try {
            $consulta = "update `peliculas` set `caratula`='".$nombre."' where idPelicula=".$ultima_id."";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            unlink("Img/".$nombre);
            session_destroy();            
            die(error_page("Videoclub", "<p>No se ha podido realizar el update: " . $e->getMessage() . "</p>"));
        }
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

        .error{
            color:red;
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
    } else if(isset($_POST["btnBorrar"])) { // Borramos los datos                      
        require "vistas/vista_borrar.php";
    } else if(isset($_POST["btnInsertar"]) || isset($_POST["btnContInsertar"])){
        ?>
        <h2>Inserción de película</h2>
        <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="titulo"><strong>Título:</strong></label>
            <input type="text" name="titulo" id="titulo" maxlength="15" value="<?php if(isset($_POST["btnContInsertar"]) && $_POST["titulo"] != "") echo $_POST["titulo"]; ?>">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_titulo) {
                    if (strlen($_POST["titulo"]) > 15) {
                        echo "<span class='error'>*El título no puede tener más de 15 carácteres*</span>";
                    } else {
                        echo "<span class='error'>*El título no puede estar vacío*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="director"><strong>Director:</strong></label>
            <input type="text" name="director" id="director" maxlength="20" value="<?php if(isset($_POST["btnContInsertar"]) && $_POST["director"] != "") echo $_POST["director"]; ?>">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_director) {
                    if (strlen($_POST["director"]) > 20) {
                        echo "<span class='error'>*El director no puede tener más de 20 carácteres*</span>";
                    } else {
                        echo "<span class='error'>*El director no puede estar vacío*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="sinopsis"><strong>Sinopsis:</strong></label>
            <textarea name="sinopsis" id="sinopsis" cols="30" rows="10"><?php if(isset($_POST["btnContInsertar"]) && $_POST["sinopsis"] != "") echo $_POST["sinopsis"]; ?></textarea>
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_sinopsis) {
                    echo "<span class='error'>*La sinopsis no puede estar vacía*</span>";                    
                }
            ?>
        </p>
        <p>
            <label for="tematica"><strong>Tematica:</strong></label>
            <input type="text" name="tematica" id="tematica" maxlength="15" value="<?php if(isset($_POST["btnContInsertar"]) && $_POST["tematica"] != "") echo $_POST["tematica"]; ?>">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_tematica) {
                    if (strlen($_POST["tematica"]) > 15) {
                        echo "<span class='error'>*La temática no puede tener más de 15 carácteres*</span>";
                    } else {
                        echo "<span class='error'>*La temática no puede estar vacía*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="foto">Seleccione una imagen</label>
            <input type="file" name="foto" id="foto" accept="image/*">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_foto) {                    
                    echo "<span class='error'>*</span>";
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnContInsertar">Insertar</button>
            <button type="submit" name="btnAtras">Atrás</button>
        </p>
    </form>
        <?php
        


    }

    ?>
    </table>
</body>

</html>