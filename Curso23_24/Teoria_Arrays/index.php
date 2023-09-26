<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría arrays</title>
</head>
<body>
    <?php 

    /*
    $nota[0]=5;
    $nota[1]=9;
    $nota[2]=8;
    $nota[3]=5;
    $nota[4]=6;
    $nota[5]=7;
    */

    // También se puede declarar eso mismo así

    $nota = array(5,9,8,5,6,7);

    // $nota = array(5,99 => 9,8,5,6,7); (si quieres asociar un indice a un valor tienes que usar el =>, por ejemplo ahí le hemos dado la posición 99 al 9)

    
    echo "<h1>Recorrido de un array escalar con sus indices correlativos</h1>";
    for ($i=0; $i < count($nota); $i++) { 
        echo "<p>En la posición: ".$i." tiene el valor: ".$nota[$i]."</p>";
    }
    

    /*
    print_r($nota); // print_r es solo para arrays    
    echo "<br>";
    var_dump($nota); // este con cualquier tipo de variable
    */

    /* 
    php permite arrays multitipos
    $valor[0] = 18;
    $valor[1] = "Hola";
    $valor[2] = true;
    $valor[3] = 3.4;
    */

    $valor[] = 18; // Sin especificar el valor también vale (te los pone en orden)
    $valor[99] = "Hola"; // Si aquí ponemos el 3, el siguiente (el true) será el 4
    $valor[] = true; // Al hacer el echo de un true te sale un 1, pero si es false no escribe nada
    $valor[200] = 3.4;

    // Eso se podría haber hecho así;
    // $valor = array(18, 99 => "Hola", false, 200 => 3.4);

    echo "<h1>Recorrido de un array escalar con sus indices NO correlativos</h1>";

    foreach ($valor as $indice => $contenido) {
        echo "<p>En la posición: $indice tiene el valor: $contenido </p>";
    }

    /*
    $notas["Antonio"] = 5;
    $notas["Luis"] = 9;
    $notas["Ana"] = 8;
    $notas["Eloy"] = 5;
    $notas["Gabriela"] = 6;
    $notas["Berta"] = 7;

    echo "<h1>Notas de DWESE</h1>";
    foreach ($notas as $nombre => $nota) {
        echo "<p>$nombre ha sacado un: $nota</p>";
    }
    */

    $notas["Antonio"]["DWESE"] = 5;
    $notas["Antonio"]["DWEC"] = 7;
    $notas["Luis"]["DWESE"] = 9;
    $notas["Luis"]["DWEC"] = 7;
    $notas["Ana"]["DWESE"] = 8;
    $notas["Ana"]["DWEC"] = 9;
    $notas["Eloy"]["DWESE"] = 5;
    $notas["Eloy"]["DWEC"] = 6;

    echo "<h1>Notas de los alumnos</h1>";    

    foreach ($notas as $nombre => $asignaturas) {
        
        echo "<p>" .$nombre."<ul>";

        foreach ($asignaturas as $nombre_asig => $valor) {
            echo "<li><strong>$nombre_asig</strong>: $valor</li>";
        }

        echo "</ul></p>";

    }


    echo "<h1>Recorrido y funciones con un array asociativo</h1>";
    
    $capital = array("Castilla y León"=>"Valladolid","Asturias"=>"Oviedo","Aragón"=>"Zaragoza");

    echo "<p>Último valor de un array: " .end($capital). "</p>"; // Aqui hemos puesto el "puntero" al final del array, por eso en el current se queda ahí el puntero
    echo "<p>Actual valor de un array: " .current($capital). "</p>";
    echo "<p>Key del puntero del array: " .key($capital). "</p>";
    reset($capital); // Con esto volvemos al principio del puntero
    echo "<p>Actual valor de un array: " .current($capital). "</p>";
    echo "<p>Key del puntero de un array: " .key($capital). "</p>";
    next($capital); // Para ir al siguiente
    prev($capital); // Para ir al anterior    



    ?>
</body>
</html>