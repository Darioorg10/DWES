<?php 
    session_name("ejer_01_ses_23_24");
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio sesiones 1</title>
    <style>
        h1{
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>FORMULARIO NOMBRE 1 (FORMULARIO)</h1>
    <?php 
        if (isset($_SESSION["nombre"])) {
            echo "<p>Su nombre es: <strong>".$_SESSION["nombre"]."</strong></p>";
        }
    ?>
    <form action="sesiones_01_2.php" method="post">
        <p>Escriba su nombre:</p>
        <p>
            <label for="nombre"><strong>Nombre:</strong></label>
            <input type="text" name="nombre" id="nombre">
        </p>
        <p>
            <button type="submit" name="btnSig">Siguiente</button>
            <button type="submit" name="btnBorrar">Borrar</button>
        </p>
    </form>
</body>
</html>