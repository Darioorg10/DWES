<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 9</title>
</head>
<body>

    <style>
        table, td, th{border:1px solid black; border-collapse: collapse}        
    </style>
    
    <?php 

    echo "<h1>Ejercicio 9</h1>";

    $lenguaje_cliente = array("LC1"=>"Lenguaje_Cliente1", "LC2"=>"Lenguaje_Cliente2", "LC3"=>"Lenguaje_Cliente3", "LC4"=>"Lenguaje_Cliente4");
    $lenguaje_servidor = array("LS1"=>"Lenguaje_Servidor1", "LS2"=>"Lenguaje_Servidor2", "LC3"=>"Lenguaje_Servidor3");

    /* Otra forma de hacerlo (mejor)

        $lenguajes = $lenguaje_cliente;
        foreach ($lenguaje_servidor as $leng => $de){
            $lenguajes[$leng]=$de;
        }

    */

    $lenguajes = $lenguaje_cliente + $lenguaje_servidor;
    echo "<table>";
    echo "<tr><th>Lenguajes</th></tr>";
        foreach ($lenguajes as $leng => $de) {
            echo "<tr><td>$de</td></tr>";
        }
    echo "</table>";
    ?>

</body>
</html>