<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 10</title>
</head>
<body>
    
    <?php

    echo "<h1>Ejercicio 10</h1>";    

    for ($i=1; $i < 11; $i++) { 
        $a[] = $i; // Creamos el array en el que los valores van de 1 a 10
    }
    
    $contador = 0;
    $total = 0;

    foreach ($a as $key => $value) {
        if ($value % 2 == 0 ) {                        
            $total += $value;
            $contador++;
        } else {
            echo "Impar: $value <br/>";
        }
    }    

    echo "La media es ".$total/$contador;
        
    ?>

</body>
</html>