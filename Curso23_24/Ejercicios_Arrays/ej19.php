<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 19</title>
</head>
<body>

    <?php 
    
        echo "<h1>Ejercicio 19</h1>";        

        // $amigos = array("Madrid" => array("Pedro" => array("Edad" => "32"), array("Tlf" => "91-9999999"), "Antonio" => array("Edad" => "32"), array("Tlf" => "1234"));        
        
        $amigos["Madrid"]["Pedro"]["Edad"]="32";
        $amigos["Madrid"]["Pedro"]["Tlf"]="91-999999";
        $amigos["Madrid"]["Antonio"]["Edad"]="32";
        $amigos["Madrid"]["Antonio"]["Tlf"]="00-9900999";
        $amigos["Madrid"]["Alguien"]["Edad"]="32";
        $amigos["Madrid"]["Alguien"]["Tlf"]="00-9875684";
        $amigos["Barcelona"]["Susana"]["Edad"]="32";
        $amigos["Barcelona"]["Susana"]["Tlf"]="445-5842";
        $amigos["Toledo"]["Nombre"]["Edad"]="32";
        $amigos["Toledo"]["Nombre"]["Tlf"]="778-98547";
        $amigos["Toledo"]["Nombre2"]["Edad"]="32";
        $amigos["Toledo"]["Nombre2"]["Tlf"]="445-5684";
        $amigos["Toledo"]["Nombre3"]["Edad"]="32";
        $amigos["Toledo"]["Nombre3"]["Tlf"]="578-9685";

        foreach ($amigos as $ciudad => $personas) {
            echo "<p>Amigos en $ciudad:</p>";
            echo "<ol>";
                foreach ($personas as $nombre => $datos) {
                    echo "<li><strong>Nombre</strong>: $nombre. <strong>Edad:</strong> ".$datos['Edad']." <strong>Teléfono</strong>: ".$datos['Tlf']."</li>";
                }
            echo "</ol>";
        }
    
    ?>
    
</body>
</html>