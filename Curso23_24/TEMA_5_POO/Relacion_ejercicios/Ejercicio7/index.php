<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7 POO</title>
</head>
<body>
    <h1>Ejercicio 7 POO</h1>
    <?php

        require "Pelicula.php";

        $pelicula1 = new Pelicula("Star wars", 1995, "George Lucas", false, 11.99, "8/11/2023");        

        
        echo "<h2>Datos de la película</h2>";
        echo "<p><strong>Nombre:</strong> ".$pelicula->getNombre()."</p>";
        echo "<p><strong>Año:</strong> ".$pelicula->getAnio()."</p>";
        echo "<p><strong>Director:</strong> ".$pelicula->getDirector()."</p>";
        echo "<p><strong>Precio:</strong> ".$pelicula->getPrecio()."</p>";
        echo "<p><strong>Está alquilada:</strong> ".($pelicula->getAlquilada() ? "Sí":"No")."</p>";
        echo "<p><strong>Fecha de devolución:</strong> ".$pelicula->getFechaDevolucion()."</p>";
        echo "<p><strong>Recargo por atraso:</strong> ".$pelicula->calcularRecargo()."€</p>";

    ?>
</body>
</html>