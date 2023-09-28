<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 13</title>
</head>
<body>
    
    <?php 

        echo "<h1>Ejercicio 13</h1>";

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

        for ($i=count($final)-1; $i >= 0; $i--) { 
            echo $final[$i]."<br/>";
        }

        

    ?>

</body>
</html>