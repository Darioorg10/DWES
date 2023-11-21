<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría de string</title>
</head>
<body>
    
    <?php
    
        $str1="Hola qué tal";
        $str2="Juan";

        echo "<h1>".$str1. " ".$str2."</h1>"; // Así se concatena (como ya hemos visto)

        $longitud1=strlen($str1); // Para calcular el length de un string
        echo "<p>La longitud del string: $str1 es: $longitud1</p>";

        $a=$str1[3];
        echo "<p>La posición 3 del string $str1 es $a</p>"; // Estamos accediendo a la posición 3 (como si fuera un array) es decir se empieza por 0

        echo "<p>".strtoupper($str2)."</p>"; // Para poner un string en mayúsculas
        echo "<p>".$str2."</p>"; // Para que veamos que el string no se modifica con el toupper, sino que solo nos lo devuelve

        $str3="      Array espaciado       ";
        echo "<p>La longitud de $str3 es: ".strlen($str3)."</p>";
        $str3=trim($str3); // Para quitarle los espacios tanto por delante como por detrás
        echo "<p>La longitud una vez hecho el trim de $str3 es: ".strlen($str3)."</p>";

        $prueba = "Hola mi nombre es Darío Rico García";
        $sep_arr=explode(" ", $prueba); // Separamos el array por el carácter de espacio
        print_r($sep_arr);

        $csv = "esto;es;un;csv";
        $csv_sep = explode(";", $csv);
        echo "<p>";
        print_r($csv_sep);
        echo "</p>";

        $archivo = "archivo.jpg";
        $extension = explode(".", $archivo);
        echo "<p> La extensión es: ".end($extension)."</p>"; // Nos coge lo último que hay separado por lo que sea



        $arr_prueba = array("hola", "Juan", "Antonio", 12, "María");
        print_r($arr_prueba);
        $str4 = implode(":::", $arr_prueba); // Esto sirve para los elementos de un array juntarlos y separarlos por el delimitador que le hayamos puesto
        echo "<p>El string obtenido es: $str4</p>";


        echo "<p>".substr("hola que tal, Juan", 0, 5)."</p>"; // El 0 es por donde empieza (hay que tener en cuenta que empiezan desde 0) y 5 la cantidad de carácteres que queremos, con un 5, teniendo en cuenta el espacio nos devuelve el hola con el espacio
        echo "<p>".substr("hola que tal, Juan", 14, 4)."</p>";
        echo "<p>".substr("hola que tal, Juan", 6)."</p>"; // Si le ponemos solo un valor va a empezar desde ese hasta el final
        echo "<p>".substr("hola que tal, Juan", -3)."</p>"; // Si le ponemos solo un valor negativo nos lo está contando desde el final del todo

    ?>

</body>
</html>