<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>
<body>
    <h1>Ejercicio 1</h1>
    <?php 
    
    // Aquí hecho con una función, pero se puede hacer más fácil

    function generar_pares($n){

        for ($i=0; $i < 2*$n; $i+=2) { // Vamos de 2 en 2 y llegamos hasta el doble del número que nos pasen 
            $pares[] = $i;
        }
            return $pares;
    }
    define('NPARES', 10);

    $pares = generar_pares(NPARES);
    echo "<p>";
    for ($i=0; $i < count($pares); $i++) { 
        echo $pares[$i]."<br/>";
    }
    echo "</p>";
    
    
    ?>
</body>
</html>