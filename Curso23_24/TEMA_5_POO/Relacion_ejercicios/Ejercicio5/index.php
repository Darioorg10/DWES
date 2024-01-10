<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5 POO</title>
</head>
<body>
    <h1>Ejercicio 5 POO</h1>
    <?php 
        require "Empleado.php";

        $empleado1 = new Empleado("Darío", "10000");
        $empleado2 = new Empleado("Jorge", "10");

        $empleado1->impuestos();
        $empleado2->impuestos();

    ?>
</body>
</html>