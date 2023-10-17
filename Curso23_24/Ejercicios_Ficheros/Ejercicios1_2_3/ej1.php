<?php 
    if (isset($_POST["btnEnviar"])) { // Control de errores
        $error_form = $_POST["num"] == "" ||  !is_numeric($_POST["num"]) || strlen($_POST["num"]) > 2 || $_POST["num"] < 1 || $_POST["num"] > 10; // Lo del strlen es para que no haya decimales
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <form action="ej1.php" method="post">
        <p>
            <label for="num">Introduzca un número entero entre 1 y 10 (ambos inclusive): </label>
            <input type="text" name="num" id="num" value="<?php if(isset($_POST["num"])) echo $_POST["num"];?>">
            <?php 
                if (isset($_POST["btnEnviar"]) && $error_form) { // Mensajes de error
                    if ($_POST["num"] == "") {
                        echo "<span class='error'>Campo vacío</span>";
                    } else if(!is_numeric($_POST["num"])){
                        echo "<span class='error'>No has introducido un número</span>";
                    } else {
                        echo "<span class='error'>Has introducido un número mayor a 10 o menor a 1, o has puesto decimales</span>";
                    }
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEnviar">Crear fichero</button>
        </p>
    </form>

    <?php
        if (isset($_POST["btnEnviar"]) && !$error_form) {
            $nombre_fichero ="tabla_".$_POST["num"].".txt";

            if (!file_exists("Tablas/".$nombre_fichero)) { // Si no existe lo creamos en modo escritura, si existe no lo hacemos porque lo sobreescribe
                @$fd = fopen("Tablas/$nombre_fichero", "w");
                if (!$fd) {
                    die("<p>No se ha podido crear el fichero Tablas/$nombre_fichero</p>");
                }

            for ($i=1; $i < 11; $i++) {
                fputs($fd, $i." x ".$_POST["num"]." = ".($i*$_POST["num"]).PHP_EOL);
            }
            echo "<p>Fichero creado con éxito";
            fclose($fd);
            }                                       
        }
    ?>
</body>
</html>