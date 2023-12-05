<?php
    session_name("ej3_ses_23_24");
    session_start();

    if (!isset($_SESSION["contador"])) {
        $_SESSION["contador"] = 0;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
    <style>
        h1 {
            text-align: center;
        }

        .grande {
            font-size: 3rem;
        }
    </style>
</head>
<body>
    <form action="sesiones_03_2.php" method="post">
        <h1>SUBIR Y BAJAR NÚMERO</h1>
        <p>Haga click en los botones para modificar el valor:</p>
        <p>
            <button class="grande" name="btnContador" type="submit" value="menos">-</button>
            <span class="grande"><?php echo $_SESSION["contador"]; ?></span>
            <button class="grande" name="btnContador" type="submit" value="mas">+</button>
        </p>
        <p>
            <button name="btnContador" type="submit" value="cero">Poner a cero</button>
        </p>
    </form>
</body>
</html>