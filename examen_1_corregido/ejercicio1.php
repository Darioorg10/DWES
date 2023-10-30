<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1. Examen PHP</title>
</head>
<body>
    <h1>Ejercicio 1. Generador de "claves_cesar.txt"</h1>
    <form action="ejercicio1.php" method="post">
        <p>
            <button type="submit" name="btnGenerar">Generar</button>
        </p>
    </form>
    <?php 
        if (isset($_POST["btnGenerar"])) {
            echo "<h1>Respuesta</h1>";
            @$fd = fopen("claves_cesar.txt", "w");
            if (!$fd) {
                die("<p>No tiene permisos para crear o abrir el fichero 'claves_cesar.txt'</p>");
           }

           $primera_linea = "Letra/Desplazamiento";
           for ($i=1; $i <= 26; $i++) { // se podría for($i = ord("A"; $i <= ord("Z")) o for($i=1; $i<=ord("Z")-ord("A")+1)
            $primera_linea.=";".$i;
           }

           fwrite($fd, $primera_linea.PHP_EOL);
           for ($i=ord("A"); $i <= ord("Z"); $i++) {
            $linea = chr($i);
            for ($j=1; $j <= ord("Z")-ord("A")+1; $j++) {
                if ($i+$j <= ord("Z")) { // Si no nos hemos pasado de la z
                    $linea.=";".chr($i+$j);
                } else {
                    $me_paso = ($i+$j) - ord("Z");
                    $posicion = ord("A") + $me_paso-1;

                    $linea.=";".chr($posicion);
                }
                
            }
            fwrite($fd, $linea.PHP_EOL);
           }
           fclose($fd);

           echo "<textarea cols='90' rows='28'>".file_get_contents('claves_cesar.txt')."</textarea>";
        }
    ?>
</body>
</html>