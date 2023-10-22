<?php 
    if (isset($_POST["btnEnviar"])) {
        $error_vacio = $_POST["texto"] == "";

        $error_form = $error_vacio;
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
        <input type="text" name="texto" id="texto">
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
            <option value=":">:</option>
            <option value=";">;</option>
            <option value=",">,</option>
        </select><br><br>
        <button type="submit" name="btnEnviar" id="btnEnviar">Enviar</button>
    </form>
</body>
<?php 
    if (isset($_POST["btnEnviar"]) && !$error_form) {
        if ($_POST["separadorSel"] == ":") {            
            
        }
    }
?>
</html>