<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1 POO</title>
</head>
<body>
    <h1>Ejercicio 1 POO</h1>
    <?php 

        require "clase_fruta.php";

        $pera = new Fruta();
        $pera->setColor("verde"); // Tenemos que hacerlo con los setters porque no tenemos constructor
        $pera->setTamanio("mediano");

        echo "<h2>Información de mi fruta</h2>";
        echo "<p><strong>Color: </strong>".$pera->getColor()."</p>";
        echo "<p><strong>Tamaño: </strong>".$pera->getTamanio()."</p>";

    ?>
</body>
</html>