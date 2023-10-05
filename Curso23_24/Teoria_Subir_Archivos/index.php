<?php 
    if (isset($_POST["btnEnviar"])) // El $files existe siempre, por lo que lo comparamos con el nombre del archivo (si está vacío). En name tengo el nombre, y tmp_name donde se ha logrado subir
        $error_archivo = $_FILES["archivo"]["name"]=="" || $_FILES["archivo"]["error"]
        || !getimagesize($_FILES["archivo"]["tmp_name"]) 
        || $_FILES["archivo"]["size"] > 500*1024 ; // Lo del getimagesize lo utilizamos para saber si es una imagen o no, porque si detecta que no es imagen devuelve false

    if (isset($_POST["btnEnviar"]) && !$error_archivo)
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
            .tam_imag{width:35%}
    </style>
    </head>
    <body>
        <h1>Teoría subir ficheros al servidor</h1>
        <h2>Datos del archivo subido</h2>
        <?php
            $nombre_nuevo = md5(uniqid(uniqid(), true));
            $array_nombre = explode(".", $_FILES["archivo"]["name"]); // Separamos la extensión
            $extension = "";
            if (count($array_nombre)>1) { // Si tenemos más de un elemento significa que tiene punto y por lo tanto que tiene extensión
                $extension = ".".end($array_nombre);
            }

            $nombre_nuevo.=$extension; // Esto es lo mismo que en java por ejemplo nombre = nombre + extensión
            @$var = move_uploaded_file($_FILES["archivo"]["tmp_name"], "images/".$nombre_nuevo); // El @ sirve para que no te salten los errores, y que puedas poner tú lo que sea
            // Tenemos que hacer en la carpeta images un sudo chmod 777 -R

            if ($var) {
                echo "<h3>Foto</h3>";
                echo "<p><strong>Nombre: </strong>".$_FILES["archivo"]["name"]."</p>";
                echo "<p><strong>Tipo: </strong>".$_FILES["archivo"]["type"]."</p>";
                echo "<p><strong>Tamaño: </strong>".$_FILES["archivo"]["size"]." bytes</p>";
                echo "<p><strong>Error: </strong>".$_FILES["archivo"]["error"]."</p>";
                echo "<p><strong>Archivo en el temporal del servidor: </strong>".$_FILES["archivo"]["tmp_name"]."</p>";
                echo "<p>La imagen ha sido subida con éxito</p>";
                echo "<p><img class='tam_imag' src='images/".$nombre_nuevo."' alt='Foto' title='Foto'/></p>";
            } else {
                echo "<p class='error'>No se ha podido mover la imagen a la carpeta destino en el servidor</p>";
            }                                    

        ?>

    </body>
    </html>

    <?php
    }    
    else
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