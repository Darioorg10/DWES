<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 8</title>
</head>
<body>
    
    <?php 
    
    echo "<h1>Ejercicio 8</h1>";

    $a = array("Pedro", "Ismael", "Sonia", "Clara", "Susana",
    "Alfonso", "Teresa");

    echo "El array contiene ".count($a)." elementos.";

    echo "<ul>";
    foreach ($a as $key => $value) {
        echo "<li>$value</li>";
    }
    echo "</ul>";
    
    ?>

</body>
</html>