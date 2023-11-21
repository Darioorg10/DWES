<?php 
    if (isset($_POST["btnDeco"])) {                                    

        $error_fichero = $_FILES["archivo"]["name"] == "" || 
        $_FILES["archivo"]["type"] != "text/plain" || 
        $_FILES["archivo"]["size"] > 1025 * 1024 || 
        $_FILES["archivo"]["error"];
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
    <h1>Ejercicio 3. Decodifica una frase</h1>
    <form action="ejercicio3.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="texto">Introduzca un texto:</label>
            <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["btnContar"])) echo $_POST["texto"];?>">
        </p>
        <p>
            <label for="archivo">Seleccione el archivo de claves (.txt y menor 1,25MB)</label>
            <input type="file" name="archivo" id="archivo" accept=".txt">
            <?php 
                if (isset($_POST["btnDeco"]) && $error_fichero) {
                    if ($_FILES["archivo"]["name"] == "") {
                        echo "<span class='error'>*</span>";
                    } else if($_FILES["archivo"]["type"] != "text/plain"){
                        echo "<span class='error'>No has seleccionado un .txt</span>";
                    } else if($_FILES["archivo"]["size"] > 1025 * 1024){
                        echo "<span class='error'>El tamaño del archivo es mayor a 1,25MB</span>";
                    } else {
                        echo "<span class='error'>No se ha podido subir el archivo al servidor</span>";
                    }
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnDeco" id="btnDeco">Decodificar</button>
        </p>
    </form>
    <?php 
        if (isset($_POST["btnDeco"]) && !$error_fichero) {
            
        }
    ?>    
</body>
</html>