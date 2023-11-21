<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1 PHP</title>
</head>

<body>
    <form action="ejercicio1.php" method="post">        
    <h1>Ejercicio 1. Generador de "claves_polybios.txt"</h1>
    <button type="submit" id="btnGenerar" name="btnGenerar">Generar</button>
    <?php
    if (isset($_POST["btnGenerar"])) { // Si se pulsa el botón
        echo "<h2>Respuesta</h2>";
        @$fd = fopen("claves_polybios.txt", "w");
        if (!$fd) {
            die("no se ha podido crear el archivo");
        }

        fputs($fd, "111\n222");
        fgets($fd, 0);
        echo file_get_contents("claves_polybios.txt");
        }    
    ?>
    </form>
    
</body>

</html>