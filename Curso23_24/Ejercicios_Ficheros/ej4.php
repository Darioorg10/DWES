<?php // Control de errores
    if (isset($_POST["btnEnviar"])) {
        $error_tipo = strlen($_POST["fichero"], -4) != ".txt";
        $error_tamanio = filesize($_POST["fichero"]) > ;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
</head>
<body>
    <form action="ej4.php" method="post" enctype="multipart/form-data">
        <label for="fichero">Seleccione un fichero de texto (.txt):</label>
        <input type="file" name="fichero" id="fichero" accept="text/*"><br>
        <input type="submit" name="btnEnviar" id="btnEnviar">
    </form>
</body>
</html>