<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría Fechas</title>
</head>
<body>
    <h1>Teoría de fechas</h1>    
    <?php 
        echo "<p>".time()."</p>"; // Esto es el tiempo desde el 1 de enero de 1970
        echo "<p>".date("d/m/Y h:i:s")."</p>"; // Si pones la d, m o y mayúscula te la da en el formato largo

        if (checkdate(2,29,2023)) { // Esto te comprueba si una fecha existe o no
            echo "<p>La fecha existe</p>";
        } else {
            echo "<p>La fecha no existe</p>";
        }

        // mktime(hora,minuto,segundo,mes,día,año)
        echo "<p>".date('d/m/Y', mktime(0,0,0,3,11,2004))."</p>"; 
        echo mktime(0,0,0,3,11,2004); // Esto te dan los segundos que han pasado desde 1970  hasta la fecha que has puesto

        echo "<p>".strtotime("03/11/2004")."</p>"; // Hace lo mismo que el mktime pero le puedes poner directamente una fecha

        echo "<p>".floor(6.5)."</p>"; // Redondea hacia abajo
        echo "<p>".ceil(6.5)."</p>"; // Redondea hacia arriba
        echo "<p>".abs(-8)."</p>"; // Nos da el valor absoluto

        printf("<p>%.2f</p>", 5.6666*7.8888); // Para limitarlo a 2 decimales

        $resultado = sprintf("%.2f", 5.6666*7.8888); // Guardamos en una variable el string que generaría ese printf
        echo $resultado;
        
        for ($i=1; $i <= 20; $i++) {
            printf("<p>%02d</p>", $i); // Esto es para que nos lo haga con 2 dígitos y que el 0 sea el número que rellene a la izquierda si falta
        }

    ?>    
</body>
</html>