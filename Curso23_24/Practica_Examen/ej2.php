<?php // Control de errores
    if (isset($_POST["btnEnviar"])) {                
        $error_vacio = $_FILES["fichero"]["name"] == "";
        $error_subida = $_FILES["fichero"]["error"];
        $error_tipo = $_FILES["fichero"]["type"] != "text/plain";
        $error_tamanio = $_FILES["fichero"]["size"] > 1000*1024;        
                

        $error_form = $error_vacio || $error_subida || $error_tipo || $error_tamanio;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <h1>Ejercicio 2</h1>
    <form action="ej2.php" method="post" enctype="multipart/form-data">
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
        if (isset($_POST["btnEnviar"]) && !$error_form) {
            echo "<h3>El archivo ha sido subido correctamente</h3>";            
            $nombre_nuevo = md5(uniqid(uniqid($_FILES["fichero"]["tmp_name"])));                        

            @$var = move_uploaded_file($_FILES["fichero"]["tmp_name"], "ficheros/$nombre_nuevo.txt");

            if ($var) {
                echo "<h3>El archivo se ha movido a la carpeta ficheros correctamente</h3>";
            } else {
                die("<h3>El archivo no se ha podido mover a la carpeta</h3>");
            }

        }
    ?>
</body>
</html>