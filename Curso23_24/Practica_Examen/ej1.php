<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
    <style>
        .error{color: red}
    </style>
</head>
<body>
    <h1>Ejercicio 1</h1>
    <form action="ej1.php" method="post">
        <label for="texto">Introduce un texto y te diré cuántos carácteres tiene: </label> 
        <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["btnEnviar"])) echo $_POST["texto"];?>">
        <button type="submit" name="btnEnviar" id="btnEnviar">Calcular</button>
    </form>
    <?php 
        if (isset($_POST["btnEnviar"])) {
            $contador = 0;
            while (isset($_POST["texto"][$contador])) {
                $contador++;
            }

            echo "El texto tiene $contador carácteres";
        }
    ?>

</body>
</html>