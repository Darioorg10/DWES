<?php // Control de errores
    if (isset($_POST["btnContar"])) {                        
        $error_form = $_FILES["fichero"]["name"] == "" || $_FILES["fichero"]["error"] || $_FILES["fichero"]["type"] != "text/plain" || $_FILES["fichero"]["size"] > 2500*1024;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
    <style>
        .error{color: red}
    </style>
</head>
<body>
    <h1>Ejercicio 4</h1>
    <form action="ej4.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="fichero">Seleccione un fichero de texto (.txt) para contar sus palabras (máx 2,5MB):</label>
            <input type="file" name="fichero" id="fichero" accept=".txt">
            <?php 
                if (isset($_POST["btnContar"]) && $error_form) {
                    if ($_FILES["fichero"]["name"] == "") {
                        echo "<span class='error'>*</span>";
                    } else if($_FILES["fichero"]["error"]){
                        echo "<span class='error'>No se ha podido subir el fichero al servidor</span>";
                    } else if($_FILES["fichero"]["type"] != "text/plain"){
                        echo "<span class='error'>No has introducido un archivo de tipo .txt</span>";
                    } else {
                        echo "<span class='error'>El tamaño del archivo es mayor a 2,5MB</span>";
                    }
                }
            ?>
        </p>                
        <p>
            <button type="submit" name="btnContar">Contar palabras</button>
        </p>
    </form>
    <?php 
        if (isset($_POST["btnContar"]) && !$error_form) {
            $contenido_fichero = file_get_contents($_FILES["fichero"]["tmp_name"]);
            echo "<h3>El número de palabras que contiene el archivo seleccionado es de: ".str_word_count($contenido_fichero)." palabras</h3>";
            fclose($fd);
            /* Así también se puede hacer, pero ninguno de los dos cuenta bien
            @$fd = fopen($_FILES["fichero"]["tmp_name"], "r");
            if (!$fd) {
                die("<h3>No se puede abrir el fichero subido al servidor</h3>");
            }

            $n_palabras = 0;
            while ($linea = fgets($fd)) { // Mientras que haya algo en la linea
                if ($linea!=PHP_EOL) {
                    $n_palabras += str_word_count($linea);
                }                
            }

            echo "<h3>El número de palabras que contiene el archivo seleccionado es de: ".$n_palabras." palabras</h3>";
            */
        }
    ?>
</body>
</html>