<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>

<body>

    <h1>Ejercicio 1. Generador de "claves_cesar.txt"</h1>

    <form action="ejercicio1.php" method="post" enctype="multipart/form-data">
        <button type="submit" name="btnGenerar" id="btnGenerar">Generar</button>
        <?php
        if (isset($_POST["btnGenerar"])) {
            echo "<h1>Respuesta</h1>";
            @$fd = fopen("claves_cesar.txt", "w");
            if (!$fd) { // Si no se puede generar el fichero
                die("El fichero no se ha podido generar");
            }

            for ($i = 0; $i < 27; $i++) { // Creamos la primera línea
                if ($i == 0) {
                    fputs($fd, "Letra/Desplazamiento");
                    for ($j = $i; $j < 27; $j++) {
                        fputs($fd, ";" . $j);
                    }
                }
            }

            $linea = "";
            fputs($fd, $linea . PHP_EOL); // Empezamos a escribir el resto
            $k = ord("A");

            for ($i = 1; $i <= 26; $i++) {
                for ($j = 1; $j <= 27; $j++) {
                    if ($j == 27) {
                        $k = ord("A");                
                        $linea .= chr($k).";";
                        $k++;
                    }
                    $linea .= chr($k).";";
                    $k++;
                }

                fputs($fd, $linea.PHP_EOL);
            }

            echo "<textarea name='respuesta' id='respuesta' cols='95' rows='10'>" . file_get_contents("claves_cesar.txt") . "</textarea><br>";
            echo "Fichero creado con éxito";
            fclose($fd);
        }
        ?>
    </form>
</body>

</html>