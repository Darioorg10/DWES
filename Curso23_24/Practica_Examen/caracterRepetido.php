<!-- Formulario con un campo de texto, en el que tengas que teclear una palabra, y debajo tiene que poner si se ha repetido algún caracter o si no -->
<?php
if (isset($_POST["btnEnviar"])) {
    $palabra = strtolower(trim($_POST["palabra"]));
    $error_form = $palabra == "";
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario carácter repetido</title>
    <style>
        .error{color:red}
    </style>
</head>

<body>
    <h1>Formulario - carácter repetido</h1>
    <form action="caracterRepetido.php" method="post">
        <label for="palabra">Introduzca una palabra:</label>
        <input type="text" name="palabra" id="palabra" value="<?php if (isset($_POST["btnEnviar"])) echo $_POST["palabra"];?>">        
        <button type="submit" name="btnEnviar" id="btnEnviar">Comprobar</button>        
        <?php 
            if (isset($_POST["btnEnviar"]) && $error_form) {
                echo "<span class='error'>*Campo obligatorio*</span>";
            }
        ?>
    </form>
    <?php
        if (isset($_POST["btnEnviar"]) && !$error_form) {
            $repite = false;
            for ($i=1; $i < strlen($palabra); $i++) {
                for ($j=0; $j < $i; $j++) {
                    if ($palabra[$i] == $palabra[$j]) {
                        $repite = true;
                        break;
                    }
                }
            }

            if ($repite) {
                echo "<p>Hay algún caracter repetido</p>";
            } else {
                echo "<p>No hay ningún caracter repetido</p>";
            }            
        }        
        ?>
</body>

</html>