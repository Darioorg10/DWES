<?php // Control de errores
    if (isset($_POST["btnEnviar"])) {
        echo "<p>".$_FILES["fichero"]["size"]."</p>";
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>
<body>
    <h1>Ejercicio 2</h1>
    <form action="ej2.php" method="post" enctype="multipart/form-data">
        <label for="fichero">Selecciona un fichero .txt de menos de 1MB</label>
        <input type="file" name="fichero" id="fichero" accept=".txt"><br>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>