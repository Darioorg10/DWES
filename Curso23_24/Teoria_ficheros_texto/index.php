<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría ficheros de texto</title>
</head>
<body>
    <h1>Teoría ficheros de texto</h1>
    <?php
        // Si le hacemos chmod 777, en modo w o a te lo crea vacío si no está, en r te da error
        @$fd1 =  fopen("prueba.txt", "r+"); // Read. El @ es porque sabemos que puede fallar, y queremos controlar nosotros el error. R+ es para leer y escribir
        if (!$fd1) {
            die("No se ha podido ejecutar el fichero prueba.txt"); // Es lo mismo que hacer un exit
        }
        echo "<p>Por ahora todo en orden</p>";
        // fopen("ruta", "w"); // Write
        // fopen("ruta", "a"); // Append (te sigue escribiendo al final del archivo)

        $linea = fgets($fd1); // Coge la línea en la que esté el cursor (si no hemos hecho nada será la primera), una vez hecho un fgets pasa a la siguiente línea

        echo "<p>$linea</p>";

        $linea = fgets($fd1); // Aquí al haber hecho un fgets antes ha hecho un enter así que estaremos en la línea 2

        echo "<p>$linea</p>";

        $linea = fgets($fd1);

        echo "<p>$linea</p>";

        $linea = fgets($fd1);

        echo "<p>$linea</p>";

        $linea = fgets($fd1); // Aquí nos devuelve false (no hay nada más), así que nos crea una <p> vacía

        echo "<p>$linea</p>";

        // Con esto nos vamos al principio (al byte 0)
        fseek($fd1, 0);

        echo "<h2>Recorremos con un while:</h2>";                
        while($linea = fgets($fd1)){ // Mientras que haya algo en la línea vamos a recorrer el fichero
            echo "<p>$linea</p>";
        }


        fwrite($fd1, PHP_EOL."Texto puesto con fwrite"); // Es exactamente lo mismo que el fputs (nos pone el texto al final del documento)

        fclose($fd1); // Cuando terminemos de trabajar con el fichero debemos cerrarlo


        echo "<h3>Todo el fichero:</h3>";
        $todo_fichero = file_get_contents("prueba.txt");
        echo "<pre>$todo_fichero</pre>"; // Con el pre se nos va a mostrar tal cual esté en el documento

        // Podríamos coger todo el html de una página web
        $fichero_web = file_get_contents("https://www.google.com");
        echo $fichero_web;

    ?>
</body>
</html>