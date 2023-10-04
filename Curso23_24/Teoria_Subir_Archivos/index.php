<?php 
    if (isset($_POST["btnEnviar"])) // El $files existe siempre, por lo que lo comparamos con el nombre del archivo (si está vacío). En name tengo el nombre, y tmp_name donde se ha logrado subir
        $error_archivo = $_FILES["archivo"]["name"]=="" || $_FILES["archivo"]["error"]
        || !getimagesize($_FILES["archivo"]["tmp_name"]) 
        || $_FILES["archivo"]["size"] > 500*1024 ; // Lo del getimagesize lo utilizamos para saber si es una imagen o no, porque si detecta que no es imagen devuelve false

    if (isset($_POST["btnEnviar"]) && !$error_archivo)
        echo "Contesto con la info del archivo subido";
    else // Lo mostramos
    {
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría subir fichero al servidor</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <h1>Teoría subir ficheros al servidor</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="archivo">Seleccione un archivo imagen (Máx 500KB):</label>
            <input type="file" name="archivo" id="archivo" accept="image/*">
            <?php 
            if (isset($_POST["btnEnviar"]) && $error_archivo) {
                if ($_FILES["archivo"]["name"] != "") // Solo me va a avisar de los errores si hemos seleccionado algo
                {
                    if ($_FILES["archivo"]["error"]) {
                        echo "<span class='error'>No se ha podido subir el archivo al servidor</span>";
                    } else if (!getimagesize($_FILES["archivo"]["tmp_name"])) {
                        echo "<span class='error'>No has seleccionado un archivo de tipo imagen</span>";
                    } else {
                        echo "<span class='error'>El archivo seleccionado supera los 500KB</span>";
                    }
                }                
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEnviar">Enviar</button>
        </p>
    </form> 
</body>
</html>
<?php 
    }
?>