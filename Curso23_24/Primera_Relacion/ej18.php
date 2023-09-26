<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 18</title>
</head>
<body>
    
    <?php 
    
    echo "<h1>Ejercicio 18</h1>";

    $deportes = array("Fútbol", "Baloncesto", "Natación", "Tenis");

    echo "<p>El array tiene ".count($deportes)." valores</p>";
    reset($deportes);
    echo "<p>Ahora estamos en el valor ".current($deportes)."</p>";
    next($deportes);
    echo "<p>Ahora estamos en el valor ".current($deportes)."</p>";
    end($deportes);
    echo "<p>Ahora estamos en el valor ".current($deportes)."</p>";
    prev($deportes);
    echo "<p>Ahora estamos en el valor ".current($deportes)."</p>";
    
    
    ?>

</body>
</html>