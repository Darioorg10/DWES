<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3 POO</title>
</head>
<body>
    <h1>Ejercicio 3 POO</h1>
    <?php 

        require "clase_fruta.php";

        echo "<h2>Información de mis frutas</h2>";
        echo "<p>Frutas creadas hasta el momento: ".Fruta::cuantaFruta()."</p>";        
        echo "<p><strong>Creando la pera...</strong></p>";
        $pera = new Fruta("verde", "mediano");
        echo "<p>Frutas creadas hasta el momento: ".Fruta::cuantaFruta()."</p>";
        echo "<p><strong>Creando un melón...</strong></p>";
        $melon = new Fruta("amarillo", "grande");
        echo "<p>Frutas creadas hasta el momento: ".Fruta::cuantaFruta()."</p>";
        echo "<p><strong>Destruyendo el melón...</strong></p>";
        unset($melon); // Así o poniendo $melon=null
        echo "<p>Frutas creadas hasta el momento: ".Fruta::cuantaFruta()."</p>";


    ?>
</body>
</html>