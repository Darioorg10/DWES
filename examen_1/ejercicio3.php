<?php

// Control de errores

if (isset($_POST["btnEnviar"])) {

    $error_texto = $_POST["texto"] == "";

    $error_desplazamiento = $_POST["des"] == ""  || !is_numeric($_POST["des"])
        || $_POST["des"] < 1 || $_POST["des"] > 26;

    $error_fichero = $_FILES["archivo"]["tmp_name"] == "" || $_FILES["archivo"]["error"]
        || $_FILES["archivo"]["type"] != "text/plain" || $_FILES["archivo"]["size"] > 1025 * 1024;

    $error_form = $error_texto || $error_desplazamiento || $error_fichero;
}

function mi_explode($separador, $texto)
{
    $aux = array();
    $l_texto = strlen($texto);
    $i = 0;
    while ($i < $l_texto && $texto[$i] == $separador) { // Quitamos los separadores del principio
        $i++;
    }

    if ($i < $l_texto) { // Si quitando los separadores seguimos teniendo texto
        $j = 0;
        $aux[$j] = $texto[$i];
        for ($i = $i + 1; $i < $l_texto; $i++) {
            if ($texto[$i] != $separador) { // Si no es un separador le concatenamos el siguiente carácter
                $aux[$j] .= $texto[$i];
            } else {
                while ($i < $l_texto && $texto[$i] == $separador) { // Si estamos en un separador vamos avanzado hasta que no sea un separador o hasta el final
                    $i++;
                }

                if ($i < $l_texto) {
                    $j++;
                    $aux[$j] = $texto[$i];
                }
            }
        }
    }

    return $aux;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
    <style>
        .error{
            color:red
        }
    </style>
</head>

<body>
    <h1>Ejercicio 3. Codifica una frase</h1>
    <form action="ejercicio3.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="texto">Introduzca un texto: </label>
            <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["btnEnviar"]) && $_POST["texto"] != "") echo $_POST["texto"];?>">
            <?php
                if (isset($_POST["btnEnviar"]) && $error_texto) {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                }
            ?>
        </p>
        <p>
            <label for="des">Desplazamiento: </label>
            <input type="text" name="des" id="des" value="<?php if(isset($_POST["btnEnviar"]) && $_POST["des"] != "") echo $_POST["des"];?>">
            <?php
                if (isset($_POST["btnEnviar"]) && $error_desplazamiento) {
                    if ($_POST["des"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else if(!is_numeric($_POST["des"])){
                        echo "<span class='error'>*Debes introducir un número*</span>";
                    } else if($_POST["des"] < 1){
                        echo "<span class='error'>*El número tiene que ser mínimo 1*</span>";
                    } else {
                        echo "<span class='error'>*El número tiene que ser menor de 26*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="archivo">Seleccione el archivo de claves (.txt y menor 1,25MB)</label>
            <input type="file" name="archivo" id="archivo" accept=".txt">
            <?php
                if (isset($_POST["btnEnviar"]) && $error_fichero) {
                    if ($_FILES["archivo"]["tmp_name"] == "") {
                        echo "<span class='error'>*</span>";
                    } else if($_FILES["archivo"]["error"]) {
                        echo "<span class='error'>*No se ha podido subir el archivo*</span>";
                    } else if($_FILES["archivo"]["type"] != "text/plain") {
                        echo "<span class='error'>*El archivo debe ser .txt*</span>";
                    } else {
                        echo "<span class='error'>*El archivo no puede pesar más de 1,25MB*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEnviar" id="btnEnviar">Codificar</button>
        </p>
        <?php
        if (isset($_POST["btnEnviar"]) && !$error_form) {
            echo "<h1>Respuesta</h1>";
            echo "<p>El texto introducido codificado sería:</p>";
        }
        ?>
    </form>

</body>

</html>