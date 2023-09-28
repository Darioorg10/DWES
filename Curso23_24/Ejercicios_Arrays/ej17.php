<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 17</title>
</head>
<body>
    
    <?php 
    
        echo "<h1>Ejercicio 17</h1>";
        // ESTE TIENE QUE SALIR COMO LA CAPTURA DE LA CARPETA

        $familias = array("Los Simpsons" => array("Padre" => "Homer",
        "Madre" => "Marge", "Hijos" => array("Hijo 1" => "Bart",
        "Hijo 2" => "Lisa", "Hijo 3" => "Maggie")),
        "Los Griffin" => array("Padre" => "Peter", "Madre" => "Louis",
        "Hijos" => array("Hijo 1" => "Chris", "Hijo 2" => "Meg",
        "Hijo 3" => "Stewie")));

        /* 
            Eso es lo mismo que
            $familias["Los Simpsons"]["Padre"]="Homer";
            $familias["Los Simpsons"]["Madre"]="Marge";
            $familias["Los Simpsons"]["Hijos"]["Hijo1"]="Bart";
            $familias["Los Simpsons"]["Hijos"]["Hijo2"]="Lisa";
            ...
        */

        echo "<ul>";

        foreach ($familias as $familia => $valores) {
            echo "<li>".$familia;
                echo "<ul>";
                    foreach ($valores as $parentesco => $nombres) {
                        if ($parentesco == "Hijos") { // Como los hijos es un array tenemos que hacer otra cosa
                            echo "<li>".$parentesco.":";
                            echo "<ul>";                            
                                foreach ($nombres as $n_hijo => $nombre) {
                                    echo "<li>$n_hijo: $nombre</li>";
                                }                            
                            echo "</ul>";
                            echo "</li>";
                        } else {
                            echo "<li>$parentesco: $nombres</li>";
                        }                       
                        
                        
                    }
                echo "</ul>";
            echo "</li>";
        }

        echo "</ul>";
    
    ?>

</body>
</html>