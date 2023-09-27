<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7</title>
</head>
<body>
    
    <?php 
    
    echo "<h1>Ejercicio 7</h1>";

    $ciudades = array("MD" => "Madrid", "BAR" => "Barcelona", "LON" => "Londres", "NY" => "New York", "LA" => "Los Ángeles", "CHI" => "Chicago");

    foreach ($ciudades as $key => $value) {
        echo "El índice del array que contiene como valor $value es $key. <br/>";
    }
    
    
    ?>

</body>
</html>