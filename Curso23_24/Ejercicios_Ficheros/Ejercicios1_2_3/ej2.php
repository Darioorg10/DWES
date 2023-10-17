<?php 
    if (isset($_POST["btnEnviar"])) { // Control de errores
        $error_form = $_POST["num"] == "" ||  !is_numeric($_POST["num"]) || strlen($_POST["num"]) > 2 || $_POST["num"] < 1 || $_POST["num"] > 10;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <form action="ej2.php" method="post">
        <p>
            <label for="num">Introduzca un número entre 1 y 10 (ambos inclusive): </label>
            <input type="text" name="num" id="num" value="<?php if(isset($_POST["num"])) echo $_POST["num"];?>">
            <?php 
                if (isset($_POST["btnEnviar"]) && $error_form) { // Mensajes de error
                    if ($_POST["num"] == "") {
                        echo "<span class='error'>Campo vacío</span>";
                    } else if(!is_numeric($_POST["num"])){
                        echo "<span class='error'>No has introducido un número</span>";
                    } else {
                        echo "<span class='error'>Has introducido un número mayor a 10 o menor a 1</span>";
                    }
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEnviar">Leer fichero</button>
        </p>
    </form>

    <?php
        if (isset($_POST["btnEnviar"]) && !$error_form) {
            $nombre_fichero ="tabla_".$_POST["num"].".txt";
            @$fd = fopen("Tablas/$nombre_fichero", "r");
                if (!$fd) {
                    die("<p>El fichero Tablas/$nombre_fichero no existe</p>");
                }

            echo "<h2>Tabla del ".$_POST["num"]."</h2>";

            while($linea = fgets($fd)){ // Esto no es una comparación, es una asignación, es decir va a hacernos lo del while mientras exista algo en $fd
                echo "<p>$linea</p>";
            }
            
            fclose($fd);
        }                                               
    ?>
</body>
</html>