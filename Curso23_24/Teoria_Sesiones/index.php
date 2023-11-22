<?php 
    session_start(); // El permiso para las sesiones tiene que ir arriba de todo
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
    <?php
        /* Este session nos guarda los datos que queramos en un array
        asociativo, en este caso vamos a poner por ejemplo un nombre
        y una clave, pero podríamos poner una fecha o cualquier otra cosa */
        if (!isset($_SESSION["nombre"])) {
            $_SESSION["nombre"] = "Darío Rico";
            $_SESSION["clave"] = md5("12345");
        }
        
    ?>
    <p>
        <a href="recibido.php">Ver datos</a>
    </p>
    <form action="recibido.php" method="post">
        <button type="submit" name="btnBorrarSesion">Borrar datos sesión</button>
    </form>
</body>
</html>