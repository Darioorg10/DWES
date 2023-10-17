<?php 
    if (isset($_POST["btnEnviar"])) { // Control de errores

        $err_num_1 = $_POST["num"] == "" ||  !is_numeric($_POST["num"]) || strlen($_POST["num"]) > 2 || $_POST["num"] < 1 || $_POST["num"] > 10;
        $err_num_2 = $_POST["num2"] == "" ||  !is_numeric($_POST["num2"]) || strlen($_POST["num2"]) > 2 || $_POST["num2"] < 1 || $_POST["num2"] > 10;  

        $error_form = $err_num_1 || $err_num_2;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <form action="ej3.php" method="post">
        <p>
            <p>
                <label for="num">Introduzca un número entre 1 y 10 (ambos inclusive): </label>
                <input type="text" name="num" id="num" value="<?php if(isset($_POST["num"])) echo $_POST["num"];?>">
                <?php 
                    if (isset($_POST["btnEnviar"]) && $err_num_1) { // Mensajes de error
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
                <label for="num2">Introduzca un número entre 1 y 10 (ambos inclusive): </label>
                <input type="text" name="num2" id="num2" value="<?php if(isset($_POST["num"])) echo $_POST["num2"];?>">
                <?php 
                    if (isset($_POST["btnEnviar"]) && $err_num_2) { // Mensajes de error
                        if ($_POST["num2"] == "") {
                            echo "<span class='error'>Campo vacío</span>";
                        } else if(!is_numeric($_POST["num2"])){
                            echo "<span class='error'>No has introducido un número</span>";
                        } else {
                            echo "<span class='error'>Has introducido un número mayor a 10 o menor a 1</span>";
                        }
                    }
                ?>
            </p>
            
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

            echo "<h2>Fila ".$_POST['num2']." de la tabla ".$_POST["num"].":</h2>";

            $cont=1;
            while($cont <= $_POST["num2"]){
                $linea = fgets($fd);
                $cont++;
            }

            echo "<p>$linea</p>";
            
            fclose($fd);
        }                                               
    ?>
</body>
</html>