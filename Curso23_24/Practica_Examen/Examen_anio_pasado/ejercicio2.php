<?php 
    if (isset($_POST["btnContar"])) {
        $error_form = $_POST["texto"] == "";
    }
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
    <style>
        .error{
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
                <option value=";" <?php if(isset($_POST["btnContar"]) && $_POST["separadorSel"] == ";") echo "selected";?>>;</option>
                <option value=":" <?php if(isset($_POST["btnContar"]) && $_POST["separadorSel"] == ":") echo "selected";?>>:</option>
                <option value="," <?php if(isset($_POST["btnContar"]) && $_POST["separadorSel"] == ",") echo "selected";?> >,</option>
                <option value=" " <?php if(isset($_POST["btnContar"]) && $_POST["separadorSel"] == " ") echo "selected";?> > (espacio)</option>
            </select>
        </p>
        <p>
            <button type="submit" name="btnContar" id="btnContar">Contar</button>
        </p>
    </form>
    <?php 
        if (isset($_POST["btnContar"]) && !$error_form) {
            echo "<h2>Respuesta</h2>";            
            echo "<ol>";
            // Que me cree un li por cada palabra que haya en el campo de texto
            for ($i=0; $i < count(explode($_POST["separadorSel"], $_POST["texto"])); $i++) { 
                echo "<li></li>";
            }
            echo "</ol>";
        }
    ?>
</body>
</html>