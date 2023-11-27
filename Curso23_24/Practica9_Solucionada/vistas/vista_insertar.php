<?php
if (isset($_POST["btnContInsertar"])) {
    $error_titulo = $_POST["titulo"] == "" || strlen($_POST["titulo"]) > 15;
    $error_director = $_POST["director"] == "" || strlen($_POST["director"]) > 20;
    $error_tematica = $_POST["tematica"] == "" || strlen($_POST["tematica"]) > 15;
    $error_sinopsis = $_POST["sinopsis"] == "";
    $error_caratula = $_FILES["caratula"]["name"] != "" && ($_FILES["caratula"]["error"] || !getimagesize($_FILES["caratula"]["tmp_name"]) || !explode(".",$_FILES["caratula"]["name"]));
    $error_form = $error_titulo || $error_director || $error_tematica || $error_sinopsis || $error_caratula;

    if (!$error_form) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
        }

        try {
            $consulta = "insert into peliculas (titulo, director, tematica, sinopsis) 
    values ('" . $_POST["titulo"] . "', '" . $_POST["director"] . "', '" . $_POST["tematica"] . "', '" . $_POST["sinopsis"] . "')";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
        }

        if ($_FILES["caratula"]["name"] != "") { // Si han insertado una carátula
            $last_id = mysqli_insert_id($conexion); // Sacamos la ultima id con el insert_id para ponersela al nombre de la foto
            $nombre_array = explode(".", $_FILES["caratula"]["name"]);
            $nombre_foto = "peli_".$last_id.".".end($nombre_array);
            @$var = move_uploaded_file($_FILES["caratula"]["tmp_name"],"Img/".$nombre_foto);
            if ($var) {
                try {
                    $consulta = "update peliculas set caratula='".$nombre_foto."' where idPelicula = '".$last_id."'";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    unlink("Img/".$nombre_foto);
                    mysqli_close($conexion);
                    die(error_page("ERROR", "<p>Ha habido un error: " . $e->getMessage() . "</p>"));
                }
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
    <title>Document</title>
</head>

<body>
    <h2>Insertar una película</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="titulo">Título de la película</label><br>
            <input type="text" name="titulo" id="titulo" maxlength="15" value="<?php if (isset($_POST["titulo"])) echo $_POST["titulo"] ?>">
            <?php
            if (isset($_POST["btnContInsertar"]) && $error_titulo) {
                if ($_POST["titulo"] == "")
                    echo "<span class='error'> Campo vacío. </span>";
                else
                    echo "<span class='error'> Mayor de 15 caracteres. </span>";
            }
            ?>
        </p>
        <p>
            <label for="director">Director de la película</label><br>
            <input type="text" name="director" id="director" maxlength="20" value="<?php if (isset($_POST["director"])) echo $_POST["director"] ?>">
            <?php
            if (isset($_POST["btnContInsertar"]) && $error_director) {
                if ($_POST["director"] == "")
                    echo "<span class='error'> Campo vacío. </span>";
                else
                    echo "<span class='error'> Mayor de 20 caracteres. </span>";
            }
            ?>
        </p>
        <p>
            <label for="tematica">Temática de la película</label><br>
            <input type="text" name="tematica" id="tematica" maxlength="15" value="<?php if (isset($_POST["tematica"])) echo $_POST["tematica"] ?>">
            <?php
            if (isset($_POST["btnContInsertar"]) && $error_tematica) {
                if ($_POST["tematica"] == "")
                    echo "<span class='error'> Campo vacío. </span>";
                else
                    echo "<span class='error'> Mayor de 15 caracteres. </span>";
            }
            ?>
        </p>
        <p>
            <label for="sinopsis">Sinopsis de la película</label><br>
            <textarea name="sinopsis" id="sinopsis" rows="10"><?php if (isset($_POST["textarea"])) echo $_POST["textarea"] ?></textarea>
            <?php
            if (isset($_POST["btnContInsertar"]) && $error_sinopsis) {
                echo "<span class='error'> Campo vacío. </span>";
            }
            ?>
        </p>
        <p>
            <label for="caratula">Añadir carátula de la película: </label>
            <input type="file" name="caratula" id="caratula" accept="image/*">
            <?php
            if (isset($_POST["btnContInsertar"]) && $error_caratula) {
                if ($_FILES['caratula']['name'] != '') {
                    if ($_FILES["caratula"]["error"])
                        echo "<span class='error'> Ha habido un error al subir el archivo. </span>";
                    else
                        echo "<span class='error'> El archivo no es una imagen. </span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnContInsertar">Insertar película</button>
            <button type="submit" name="btnAtras">Atrás</button>
        </p>
    </form>
</body>

</html>