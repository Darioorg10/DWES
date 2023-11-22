<?php 
    session_start(); // Hay que poner esto también donde se reciban los datos
    if (isset($_POST["btnBorrarSesion"])) {
        session_unset();
        // Se podría poner un session_destroy() pero si recargas la página
        // siguen apareciendo.
        // Con unset($_SESSION["lo que sea"]) nos cargamos una variable en concreto
    }    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría sesiones</title>
</head>
<body>
    <h1>Teoría de sesiones</h1>
    <h2>Se han recibido los siguientes datos: </h2>
    <p>
        <?php
        if (isset($_SESSION["nombre"])) {
            echo "<strong>Nombre: </strong>".$_SESSION['nombre']."<br>";
            echo "<strong>Clave: </strong>".$_SESSION['clave'];
        } else {
            echo "<p>Se han borrado los valores de sesión</p>";
        }
        ?>
        <p>
            <a href="index.php">Volver</a>
        </p>
    </p> 
</body>
</html>