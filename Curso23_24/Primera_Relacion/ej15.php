<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 15</title>
    <style>
        table, tr, th{border:1px solid black; border-collapse:collapse};
    </style>
</head>
<body>
    
    <?php 
    
        echo "<h1>Ejercicio 15</h1>";

        $numeros = array(3,2,8,123,5,1);

        sort($numeros);

        echo "<table>";
        foreach ($numeros as $key => $value) {
            echo "<tr><td>$value</td><tr>";
        }
        echo "</table>";
    
    ?>

</body>
</html>