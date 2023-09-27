<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 14</title>
    <style>
        table, td, th{border:1px solid black; border-collapse:collapse};
    </style>
</head>
<body>
    
    
    <?php 
    
        echo "<h1>Ejercicio 14</h1>";

        $estadios_futbol = array("Barcelona" => "Camp Nou", "Real Madrid"
        => "Santiago Bernabeu", "Valencia" => "Mestalla", "Real Sociedad" => "Reale Arena");

        echo "<table><tr><th>Equipo</th><th>Estadio</th></tr>";
        foreach ($estadios_futbol as $key => $value) {
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }
        echo "</table><br/>";

        unset($estadios_futbol["Real Madrid"]); // Borramos al Real Madrid

        echo "Después de borrar al Real Madrid<br/>";

        echo "<table><tr><th>Equipo</th><th>Estadio</th></tr>";
        foreach ($estadios_futbol as $key => $value) {
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }
        echo "</table>";
    
    ?>

</body>
</html>