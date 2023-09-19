<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primera página</title>
</head>
<body>
    <h1>Teoría elemental de PHP. Día: <?php echo date("d-m-Y")?></h1> <!-- Se puede meter php dentro de una etiqueta de html --> 
    <?php
        echo "<h1>Mi primera página web curso 23-24</h1>";

        // Para declarar constantes
        define("PI", 3.1415);

        // Para declarar variables
        $a = 8;
        $b = 9;
        $c = $a + $b;
        echo "<p>El resultado de la suma de ".$a." + ".$b." es: ".$c." </p>"; // Los puntos son como el + en java, sirve para concatenar

        // If y else if
        if ($c<3) // Para meter un y en la condición &&, un o || y una negación ! 
        {
            echo "<p>3 es mayor que ".$c."</p>";

        } else if($c==3){
            echo "<p>3 es igual que ".$c."</p>";
        }
        else
        {
            echo "<p>3 es menor que ".$c."</p>";
        }

        // Switch
        $d=3;
        switch ($d) {
            case 1:
                $c = $a-$b;    
            break;
            case 2:
                $c = $a/$b;    
            break;
            case 3:
                $c = $a*PI; // Para poner la constante no se pone el $
            break;
            
            default:
                $c = $a+$b;                    
            break;
        }

        echo "<p>El resultado del switch es: ".$c."</p>";

        // For
        for ($i=0; $i <= 8; $i++) { 
            echo "<p>Hola ".($i+1)."</p>";
        }

        // Lo mismo que en el for con el while
        $i = 0;
        while ($i<=8) {
            echo "<p>Hola ".($i+1)."</p>";
            $i++;
        }


    ?>
</body>
</html>