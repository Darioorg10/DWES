<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1  PHP</title>
</head>
<body>
    <h1>Ejercicio 1. Generador de "claves_polybios.txt"</h1>
    <button type="submit" id="btnGenerar" name="btnGenerar">Generar</button>
    <?php 
        if (isset($_POST["btnGenerar"])) { // Si se pulsa el botón
            echo "<h2>Respuesta</h2>";
            
        }
    ?>
</body>
</html>