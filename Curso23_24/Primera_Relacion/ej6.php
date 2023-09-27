<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
</head>
<body>
    
    <?php 
    
    echo "<h1>Ejercicio 6</h1>";

    $ciudades = array("Madrid", "Barcelona", "Londres", "New York", "Los Ángeles", "Chicago");

    foreach ($ciudades as $key => $value) {
        echo "La ciudad con el índice $key tiene el nombre $value. <br/>";
    }
    
    
    ?>

</body>
</html>