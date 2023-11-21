<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 0 auto;
        }
    </style>
</head>

<body>  
    <h3>Ejercicio 5</h3>
    <?php
    @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
    if (!$fd) {
        die("<h3>No se ha podido abrir el fichero</h3>");
    }
    echo "<table>";
    echo "<caption>PIB per cápita de los países de la Unión Europea</caption>";

    $linea = fgets($fd);
    $datos_linea = explode("\t", $linea);
    $n_col = count($datos_linea);
    echo "<tr>";
        for ($i=0; $i < $n_col; $i++) { 
            echo "<th>".$datos_linea[$i]."</th>";
        }
    echo "</tr>";

    while ($linea = fgets($fd)) {
        $datos_linea = explode("\t", $linea);        
        echo "<tr>";
        echo "<th>".$datos_linea[0]."</th>";
        for ($i=1; $i < $n_col; $i++) {
            if (isset($datos_linea[$i])) { // Si tiene contenido la escribimos
                echo "<td>".$datos_linea[$i]."</td>";
            } else {
                echo "<td>X</td>";
            }
        }
        echo "</tr>";
    }

    echo "</table>";
    ?>
</body>

</html>