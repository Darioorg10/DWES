<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
</head>
<body>
    <h1>Estos son los datos enviados:</h1>
    <p>
        <strong>El nombre enviado ha sido: </strong><?php echo $_POST["nombre"];?>
    </p>
    <p>
        <strong>Ha nacido en: </strong><?php echo $_POST["nacido"];?>
    </p>
    <p>
        <strong>El sexo es: </strong><?php echo $_POST["sexo"];?>
    </p>
    <?php 

    if (!isset($_POST["aficiones"])) {
        echo "<p><strong>No has seleccionado ninguna afición</strong></p>";
    } else if(count($_POST["aficiones"]) == 1){
        echo "<p><strong>La aficción seleccionada ha sido:</strong></p>";
        echo "<ol>";
        echo "<li>".$_POST["aficiones"][0]."</li>";
        echo "</ol>";
    } else {
        echo "<p><strong>Las aficiones seleccionadas han sido:</strong></p>";
        echo "<ol>";
        for ($i=0; $i < count($_POST["aficiones"]); $i++) { 
            echo "<li>".$_POST["aficiones"][$i]."</li>";
        }
        echo "</ol>";
    }

    
    if ($_POST["comentarios"] == "") {
        echo "<p><strong>No has escrito ningún comentario</strong></p>";
    } else {
        echo "<p><strong>El comentario enviado ha sido: </strong>".$_POST["comentarios"]."</p>";
    }

    ?>
</body>
</html>