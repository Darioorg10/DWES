<?php

    if (isset($_POST["btnContar"])) {
        $error_form = $_POST["texto"] == "";
    }

    function mi_explode($sep, $texto){    
        $respuesta = [];
        $l_texto = strlen($texto);
        $i = 0;
        while ($i < $l_texto && $texto[$i] == $sep) { // Quitamos los separadores del principio
            $i++;
        }

        if ($i < $l_texto) { // Si quitando los separadores seguimos teniendo texto
            $j = 0;
            $respuesta[$j] = $texto[$i];
            for ($i = $i + 1; $i < $l_texto; $i++) {
                if ($texto[$i] != $sep) { // Si no es un separador le concatenamos el siguiente carácter
                    $respuesta[$j] .= $texto[$i];
                } else {
                    while ($i < $l_texto && $texto[$i] == $sep) { // Si estamos en un separador vamos avanzado hasta que no sea un separador o hasta el final
                        $i++;
                    }

                    if ($i < $l_texto) {
                        $j++;
                        $respuesta[$j] = $texto[$i];
                    }
                }
            }
        }

        return $respuesta;
    }

    function tiene_vocales($texto){
        $tiene = false;        
        for ($i=0; $i < strlen($texto); $i++) {
            if ($texto[$i] == "a" || $texto[$i] == "e" || $texto[$i] == "i" || $texto[$i] == "o" || $texto[$i] == "u"
            ||  $texto[$i] == "A" || $texto[$i] == "E" || $texto[$i] == "I" || $texto[$i] == "O" || $texto[$i] == "U") {
                $tiene = true;
                break;
            }            
        }    
        return $tiene;    
    }

    function filtrar_sin_vocales($arr_palabras){
        $respuesta = [];
        for ($i=0; $i < count($arr_palabras); $i++) { 
            if (!tiene_vocales($arr_palabras[$i])) {
                $respuesta[] = $arr_palabras[$i];
            }            
        }
        return $respuesta;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2. Contar palabras sin vocales</title>
    <style>
        .error{
            color:red
        }
    </style>
</head>
<body>
    <h1>Contar palabras sin vocales (a, e, i, o, u, A, E, I, O, U)</h1>
    <form action="ejercicio2.php" method="post">
        <p>
            <label for="texto">Introduzca un texto: </label>
            <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["btnContar"]) && $_POST["texto"] != "") echo $_POST["texto"]; ?>">
            <?php
            if (isset($_POST["btnContar"]) && $error_form) {
                echo "<span class='error'>*Campo obligatorio*</span>";
            }

            ?>
        </p>
        <p>
            <label for="separadorSel">Elija un separador: </label>
            <select name="separadorSel" id="separadorSel">
                <option value=";" <?php if (isset($_POST["texto"]) && $_POST["separadorSel"] == ";") echo "selected"; ?>>;</option>
                <option value=":" <?php if (isset($_POST["texto"]) && $_POST["separadorSel"] == ":") echo "selected"; ?>>:</option>
                <option value="," <?php if (isset($_POST["texto"]) && $_POST["separadorSel"] == ",") echo "selected"; ?>>,</option>
                <option value=" " <?php if (isset($_POST["texto"]) && $_POST["separadorSel"] == " ") echo "selected"; ?>> (espacio)</option>
            </select>
        </p>
        <p>
            <button type="submit" id="btnContar" name="btnContar">Contar</button>
        </p>
    </form>
    <?php 
        if (isset($_POST["btnContar"]) && !$error_form) {
            echo "<h2>Respuesta</h2>";
            $palabras_por_separador = mi_explode($_POST["separadorSel"], $_POST["texto"]);
            $palabras_sin_vocales = filtrar_sin_vocales($palabras_por_separador);
            echo "<p>La palabra tiene ".count($palabras_sin_vocales)." palabras sin vocales</p>";
        }
    ?>
</body>
</html>