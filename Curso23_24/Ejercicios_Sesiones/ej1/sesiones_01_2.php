<?php 
    session_name("ejer_01_ses_23_24");
    session_start();

    if (isset($_POST["nombre"])) {
        if ($_POST["nombre"] == "") {
            unset($_SESSION["nombre"]);
        } else {
            $_SESSION["nombre"] = $_POST["nombre"];
        }
    }

    if (isset($_POST["btnBorrar"])) {
        session_destroy();
        header("Location:sesiones_01_1.php");
        exit;
    }

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
    <h1>FORMULARIO NOMBRE 1 (RESULTADO)</h1>
    <?php 
        if (isset($_SESSION["nombre"])) {
            echo "<p>Su nombre es: <strong>".$_SESSION["nombre"]."</strong></p>";
        } else {
            echo "<p>No has escrito nada en la primera página</p>";            
        }
        echo "<a href='sesiones_01_1.php'>Volver a la primera página</a>";
    ?>
</body>
</html>