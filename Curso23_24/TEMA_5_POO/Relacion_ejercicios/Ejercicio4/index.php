<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4 POO</title>
</head>
<body>
    <h1>Ejercicio 4 POO</h1>
    <?php 

        require "clase_uva.php";

        // Creamos una uva que tenga semilla
        $uva = new Uva("morada", "pequeña", true);

        echo "<h2>Información de mi uva</h2>";

        // Si tiene semilla imprimimos una cosa y si no otra
        if ($uva->tieneSemilla()) {
            echo "<p>La uva que es <strong>".$uva->getColor()."</strong> y <strong>".$uva->getTamanio()."</strong> tiene semilla</p>";
        } else {
            echo "<p>La uva que es <strong>".$uva->getColor()."</strong> y <strong>".$uva->getTamanio()."</strong> no tiene semilla</p>";
        }

    ?>
</body>
</html>