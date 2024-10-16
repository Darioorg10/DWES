    <?php         

        /* 
            Si el submit tiene un post se accede a la matriz con los datos
            mediante $_POST y con get igual.

            Están los arrays escalares (se accede por número) y los asociativos
            (se accede por el nombre)
        */

        if (isset($_POST["btnEnviar"])) 
        {
        ?>

        <!-- Metemos el código html -->    
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Recogida de datos</title>
        </head>
        <body>
            <h1>Recogiendo los datos...</h1>
        </body>
        </html>
        
        <!-- Seguimos el php -->
        <?php
            echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
            echo "<p><strong>Apellido: </strong>".$_POST["apellidos"]."</p>";
            echo "<p><strong>Contraseña: </strong>".$_POST["contrasena"]."</p>";

            if (isset($_POST["sexo"])) { // Se pueden ahorrar las llaves si solo hay un if else
                echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
            } else {                        
                echo "<p><strong>Sexo: </strong>No seleccionado</p>";
            }    
            
            if (isset($_POST["suscrito"])){
                echo "<p>Estás suscrito al boletín de novedades</p>";
            } else {
                echo "<p>No estás suscrito al boletín de novedades</p>";
            } 
        } else {            
            header("Location:index.html");            
        }         
    ?>
