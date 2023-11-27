<?php
if (isset($_POST["btnEditar"]))
    $id_peli = $_POST["btnEditar"];
else
    $id_peli = $_POST["id_peli"];

try {
    $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    mysqli_set_charset($conexion, "utf8");
} catch (Exception $e) {
    die("<p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
}

try {
    $consulta = "select * from peliculas where idPelicula='" . $id_peli . "'";
    $resultado = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    mysqli_close($conexion);
    die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
}
if (mysqli_num_rows($resultado) > 0) {
    if (isset($_POST["btnEditar"]) || isset($_POST["btnNoBorrarFoto"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnContBorrarFoto"])) {    //Recojo datos obtenidos de la BD
        $datos_pelicula = mysqli_fetch_assoc($resultado);
        $titulo = $datos_pelicula["titulo"];
        $director = $datos_pelicula["director"];
        $tematica = $datos_pelicula["tematica"];
        $sinopsis = $datos_pelicula["sinopsis"];
        $foto = $datos_pelicula["caratula"];
    } else {
        $titulo = $_POST["titulo"];
        $director = $_POST["director"];
        $tematica = $_POST["tematica"];
        $sinopsis = $_POST["sinopsis"];
        $foto = $_POST["caratula_bd"];
    }
    mysqli_free_result($resultado);
} else {
    $mensaje_error_pelicula = "<p>La pelicula seleccionada ya no se encuentra registrada en la BD</p>";
}

if (isset($mensaje_error_pelicula))
    echo $mensaje_error_pelicula;
else {
    if (isset($_POST["btnBorrarFoto"])) {
        echo "<form action='index.php' method='post'>";
        echo "<p>Se dispone usted a borrar la caratula de la película con ID = " . $_POST["id_peli"] . "</p>";
        echo '<p>Cambiará esta carátula:  <img src="Img/' . $_POST["caratula_bd"] . '" alt="Imagen de caratula">por esta otra: <img src="Img/no_imagen.jpg" alt="Imagen de caratula"> </p>';
        echo '<p> <input type="hidden" name="caratula_bd" value="'.$_POST["caratula_bd"].'"><input type="hidden" name="id_peli" value="' . $_POST["id_peli"] . '"><button type="submit" name="btnContBorrarFoto">Continuar</button>
                <button type="submit" name="btnNoBorrarFoto">Atras</button></p>';
        echo "</form>";
    } else {
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar</title>
            <style>
                form#editar {
                    display: flex;
                }

                form#editar>div:nth-child(1) {
                    flex: 80%;
                }

                form#editar>div:nth-child(2)>img {
                    width: 50%;
                    flex: 0 20%;
                    height: auto;
                }
            </style>
        </head>

        <body>
            <h2>Editar una Película</h2>
            <form action="index.php" method="post" enctype="multipart/form-data" id="editar">
                <div>
                    <p>
                        <label for="titulo">Título de la película</label><br>
                        <input type="text" name="titulo" id="titulo" maxlength="15" value="<?php echo $titulo ?>">
                        <?php
                        if (isset($_POST["btnContEditar"]) && $error_titulo) {
                            if ($_POST["titulo"] == "")
                                echo "<span class='error'> Campo vacío. </span>";
                            else
                                echo "<span class='error'> Mayor de 15 caracteres. </span>";
                        }
                        ?>
                    </p>
                    <p>
                        <label for="director">Director de la película</label><br>
                        <input type="text" name="director" id="director" maxlength="20" value="<?php echo $director ?>">
                        <?php
                        if (isset($_POST["btnContEditar"]) && $error_director) {
                            if ($_POST["director"] == "")
                                echo "<span class='error'> Campo vacío. </span>";
                            else
                                echo "<span class='error'> Mayor de 20 caracteres. </span>";
                        }
                        ?>
                    </p>
                    <p>
                        <label for="tematica">Temática de la película</label><br>
                        <input type="text" name="tematica" id="tematica" maxlength="15" value="<?php echo $tematica ?>">
                        <?php
                        if (isset($_POST["btnContEditar"]) && $error_tematica) {
                            if ($_POST["tematica"] == "")
                                echo "<span class='error'> Campo vacío. </span>";
                            else
                                echo "<span class='error'> Mayor de 15 caracteres. </span>";
                        }
                        ?>
                    </p>
                    <p>
                        <label for="sinopsis">Sinopsis de la película</label><br>
                        <textarea name="sinopsis" id="sinopsis" rows="10"><?php echo $sinopsis ?></textarea>
                        <?php
                        if (isset($_POST["btnContEditar"]) && $error_sinopsis) {
                            echo "<span class='error'> Campo vacío. </span>";
                        }
                        ?>
                    </p>
                    <p>
                        <label for="caratula">Cambiar carátula de la película: </label>
                        <input type="file" name="caratula" id="caratula" accept="image/*">
                        <?php
                        if (isset($_POST["btnContEditar"]) && $error_caratula) {
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
                        <input type="hidden" name="caratula_bd" value="<?php echo $foto ?>">
                        <input type="hidden" name="id_peli" value="<?php echo $id_peli ?>">
                        <button type="submit" name="btnContEditar">Editar película</button>
                        <button type="submit" name="btnAtras">Atrás</button>
                    </p>
                </div>
                <div>
                    <p>Carátula actual</p>
                    <img src="Img/<?php echo $foto ?>" alt="Imagen de caratula"> <br>
                    <?php
                    if ($foto != "no_imagen.jpg") {
                        echo '<button type="submit" name="btnBorrarFoto">Eliminar Carátula</button>';
                    }
                    ?>
                </div>
            </form>
        </body>

        </html>
<?php
    }
}
?>