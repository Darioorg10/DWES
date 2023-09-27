<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 17</title>
</head>
<body>
    
    <?php 
    
        echo "<h1>Ejercicio 17</h1>"
        // ESTE TIENE QUE SALIR COMO LA CAPTURA DE LA CARPETA

        $familias = array("Los Simpsons" => array("Padre" => "Homer",
        "Madre" => "Marge", "Hijos" => array("Hijo 1" => "Bart",
        "Hijo 2" => "Lisa", "Hijo 3" => "Maggie")),
        "Los Griffin" => array("Padre" => "Peter", "Madre" => "Louis",
        "Hijos" => array("Hijo 1" => "Chris", "Hijo 2" => "Meg",
        "Hijo 3" => "Stewie")));

        echo "<ul>";

        foreach ($familias as $familia => $parent) {
            
        }

        echo "</ul>";
    
    ?>

</body>
</html>