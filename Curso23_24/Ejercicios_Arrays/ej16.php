<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 16</title>
</head>
<body>
    
    <?php 
    
        echo "<h1>Ejercicio 16</h1>";

        $a = array(5 => 1, 12 => 2, 13 => 56, "x" => 42);

        foreach ($a as $key => $value) {
            echo "La clave es: $key y el valor: $value<br/>";
        }

        echo "<br/>El array tiene ".count($a)." elementos<br/><br/>";        

        unset($a[5]);

        foreach ($a as $key => $value) {
            echo "La clave es: $key y el valor: $value<br/>";
        }
        
        unset($a); // Borramos el array


    ?>

</body>
</html>