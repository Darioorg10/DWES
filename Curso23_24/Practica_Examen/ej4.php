<?php // Control de errores
if (isset($_POST["btnEnviar"])) {
    $error_vacio = $_FILES["fichero"]["name"] == "";
    $error_subida = $_FILES["fichero"]["error"];
    $error_tipo = $_FILES["fichero"]["type"] != "text/plain";
    $error_tamanio = $_FILES["fichero"]["size"] > 1000 * 1024;


    $error_form = $error_vacio || $error_subida || $error_tipo || $error_tamanio;
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
    <h1>Ejercicio 4</h1>
    <?php
    if (!file_exists("horario/horarios.txt")) { // Si el archivo no existe
        echo "<h2>No se encuentra el archivo horario/horarios.txt</h2>";
    ?>
        <form action="ej4.php" method="post" enctype="multipart/form-data">
            <label for="fichero">Selecciona un fichero .txt de menos de 1MB</label>
            <input type="file" name="fichero" id="fichero" accept=".txt">
            <?php
            if (isset($_POST["btnEnviar"]) && $error_form) {
                if ($error_vacio) {
                    echo "<span class='error'>*</span>";
                } else if ($error_subida) {
                    echo "<span class='error'>No se ha podido subir el archivo al servidor</span>";
                } else if ($error_tipo) {
                    echo "<span class='error'>El archivo no es .txt</span>";
                } else if ($error_tamanio) {
                    echo "<span class='error'>El archivo pesa más de 1MB</span>";
                }
            }
            ?>
            <br>
            <button type="submit" name="btnEnviar">Enviar</button>
        </form>
    <?php
    } else {
        echo "<h2>Horario de los profesores</h2>";
        ?>
        <form action="ej4.php" method="post">
            <label for="horarioP">Horario del profesor:</label>
            <select name="horarioP" id="horarioP">

            </select>
            <?php
            
            ?>            
            <button type="submit" name="btnEnviar">Ver horario</button>
        </form>
        <?php        
    }
    ?>
</body>
</html>