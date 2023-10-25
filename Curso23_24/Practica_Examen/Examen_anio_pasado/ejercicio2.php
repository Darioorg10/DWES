<?php
if (isset($_POST["btnContar"])) {
    $error_form = $_POST["texto"] == "";
}

function mi_explode($separador, $texto)
{
    $res = array();

    //No cuento los separadores que pudiera haber inicialmente
    $j = 0;
    $long_texto = strlen($texto);
    while ($j < $long_texto && $texto[$j] == $separador)
        $j++;

    if ($j < $long_texto) {
        $cont = 0;
        $res[$cont] = $texto[$j];
        $j++;
        while ($j < $long_texto) {
            if ($texto[$j] != $separador) {
                $res[$cont] .= $texto[$j];
                $j++;
            } else {
                $j++;
                while ($j < $long_texto && $texto[$j] == $separador)
                    $j++;

                if ($j < $long_texto) {
                    $cont++;
                    $res[$cont] = $texto[$j];
                    $j++;
                }
            }
        }
    }
    return $res;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Ejercicio 2. Longitud de las palabras extraídas</h1>
    <form action="ejercicio2.php" method="post">
        <p>
            <label for="texto">Introduzca un texto:</label>
            <input type="text" name="texto" id="texto">
            <?php
            if (isset($_POST["btnContar"]) && $error_form) {
                echo "<span class='error'>*Campo obligatorio*</span>";
            }
            ?>
        </p>
        <p>
            <label for="separadorSel">Elija el separador:</label>
            <select name="separadorSel" id="separadorSel">
                <option value=";" <?php if (isset($_POST["btnContar"]) && $_POST["separadorSel"] == ";") echo "selected"; ?>>;</option>
                <option value=":" <?php if (isset($_POST["btnContar"]) && $_POST["separadorSel"] == ":") echo "selected"; ?>>:</option>
                <option value="," <?php if (isset($_POST["btnContar"]) && $_POST["separadorSel"] == ",") echo "selected"; ?>>,</option>
                <option value=" " <?php if (isset($_POST["btnContar"]) && $_POST["separadorSel"] == " ") echo "selected"; ?>> (espacio)</option>
            </select>
        </p>
        <p>
            <button type="submit" name="btnContar" id="btnContar">Contar</button>
        </p>
    </form>
    <?php
    if (isset($_POST["btnContar"]) && !$error_form) {
        $palabras = mi_explode($_POST["separadorSel"], $_POST["texto"]);
        echo "<h2>Respuesta</h2>";
        echo "<ol>";
        // Que me cree un li por cada palabra que haya en el campo de texto
        for ($i=0; $i < count($palabras); $i++) { 
            echo "<li>".$palabras[$i]."</li>";
        }
        

        echo "</ol>";
    }
    ?>
</body>

</html>