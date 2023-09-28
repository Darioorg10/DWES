<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 12</title>
</head>
<body>
    
    <?php 

        echo "<h1>Ejercicio 12</h1>";

        $a = array("Lagartija", "Araña", "Perro", "Gato", "Ratón");
        $b = array("12", "34", "45", "52", "12");
        $c = array("Sauce", "Pino", "Naranjo", "Chopo", "Perro", "34");

        $final = [];

        foreach ($a as $key => $value) {
            array_push($final, $value);
        }

        foreach ($b as $key => $value) {
            array_push($final, $value);
        }

        foreach ($c as $key => $value) {
            array_push($final, $value);
        }

        foreach ($final as $key => $value) {
            echo "$value<br/>";
        }

        

    ?>

</body>
</html>