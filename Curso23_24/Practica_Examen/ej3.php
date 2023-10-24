<?php 
    if (isset($_POST["btnEnviar"])) {
        $error_vacio = $_POST["texto"] == "";

        $error_form = $error_vacio;
    }

    function mi_strlen($texto){
        $contador = 0;
        while (isset($texto[$contador])) {
            $contador++;
        }
        return $contador;
    }

    function mi_explode($separador, $texto){
        // $aux = array(); Esto es lo mismo que $aux = [];
        $aux = [];        
        $longitud_texto = mi_strlen($texto);
        $i = 0;
        while ($i < $longitud_texto && $texto[$i] == $separador) { // Esto sirve para quitar los separadores si hay en el principio
            $i++;
        }

        if ($i < $longitud_texto) { // Si ya viendo los separadores del principio no hemos terminado todavía
            $j = 0;
            $aux[$j] = $texto[$i];
            for ($i=$i+1; $i < $longitud_texto; $i++) {
                if ($texto[$i] != $separador) { // Si no es un separador le concatenamos la siguiente letra/carácter
                    $aux[$j].=$texto[$i];
                } else {
                    while ($i < $longitud_texto && $texto[$i] == $separador) { // Si estamos en un separador vamos avanzado hasta que no sea un separador o hasta el final
                        $i++;                        
                    }

                    if ($i < $longitud_texto) {
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
    <h1>Ejercicio 3</h1>
    <form action="ej3.php" method="post">
        <label for="texto">Introduzca un texto:</label>
        <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"];?>">
        <?php 
            if (isset($_POST["btnEnviar"]) && $error_form) {
                if ($error_vacio) {
                    echo "<span class='error'>*Debes de introducir texto*</span>";
                }
            }
        ?>
        <br><br>
        <label for="separadorSel">Elige el separador:</label>
        <select name="separadorSel" id="separadorSel">
            <option <?php if(isset($_POST["btnEnviar"]) && $_POST["separadorSel"] == ":") echo "selected";?> value=":">:</option>
            <option <?php if(isset($_POST["btnEnviar"]) && $_POST["separadorSel"] == ";") echo "selected";?> value=";">;</option>
            <option <?php if(isset($_POST["btnEnviar"]) && $_POST["separadorSel"] == ",") echo "selected";?> >,</option>
            <option <?php if(isset($_POST["btnEnviar"]) && $_POST["separadorSel"] == " ") echo "selected";?> value=" "> (espacio)</option>                        
        </select><br><br>
        <button type="submit" name="btnEnviar" id="btnEnviar">Enviar</button>
    </form>
</body>
<?php 
    if (isset($_POST["btnEnviar"]) && !$error_form) {
        echo "<h2>Respuesta</h2>";
        echo "<p>El número de palabras separadas por el separador seleccionado es de: ".count(mi_explode($_POST["separadorSel"], $_POST["texto"]))."</p>";
    }
?>
</html>