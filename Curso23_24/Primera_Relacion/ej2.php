<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>
<body>
    
    <?php 

    echo "<h1>Ejercicio 2</h1>";
    
    $v[1] = 90;
    $v[30] = 7;
    $v['e'] = 99;
    $v['hola'] = 43;

    foreach ($v as $key => $value) {
        if (is_string($key)) { // También se puede hacer con is_numeric y cambiar el if y el else
            echo "<p>El valor de '$key' es: $value </p>";
        } else {
            echo "<p>El valor de $key es: $value </p>";
        }
        
    }
    
    
    
    ?>

</body>
</html>