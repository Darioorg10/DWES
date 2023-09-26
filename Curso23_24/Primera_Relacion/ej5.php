<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>
</head>
<body>
    
    <?php 
    
    echo "<h1>Ejercicio 5</h1>";

    $informacion =  array("Nombre" => "Pedro Torres",
                    "Dirección" => "C/Mayor, 37",
                    "Teléfono" => 123456789
                    );

    foreach ($informacion as $key => $value) {
        echo "<p>$key: $value</p>";
    }
    
    
    
    
    ?>

</body>
</html>