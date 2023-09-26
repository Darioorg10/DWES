<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>
<body>
    
    <?php 
    
    echo "<h1>Ejercicio 3</h1>";


    $peliculas["Enero"] = 9;
    $peliculas["Febrero"] = 12;
    $peliculas["Marzo"] = 0;
    $peliculas["Abril"] = 17;

    foreach ($peliculas as $mes => $nPelis) {
        if ($nPelis != 0) {
            echo "<p>En el mes de $mes se han visto: $nPelis películas</p>";
        }
        
    }




    ?>

</body>
</html>