<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 11</title>
</head>
<body>
    
    <?php 

        echo "<h1>Ejercicio 11</h1>";

        $a = array("Lagartija", "Araña", "Perro", "Gato", "Ratón");
        $b = array("12", "34", "45", "52", "12");
        $c = array("Sauce", "Pino", "Naranjo", "Chopo", "Perro", "34");

        $mezclado = array_merge($a, $b, $c);

        foreach ($mezclado as $key => $value) {
            echo "$value<br/>";
        }

    ?>

</body>
</html>