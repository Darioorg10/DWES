<?php 

if (isset($_POST["btnEnviar"])) 
{
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recogida de datos</title>
    </head>
    <body>
        <h1>Recogida de datos</h1>
    </body>
    </html>

<?php 
      
      // Nombre
      echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";

      // Nacido en
      echo "<p><strong>Nacido en: </strong>".$_POST["nacido"]."</p>";

      // Sexo
      if (isset($_POST["sexo"])) { // Se pueden ahorrar las llaves si solo hay un if else
        echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
        } else {                        
            echo "<p><strong>Sexo: </strong>No seleccionado</p>";
        }    

        // Aficiones
        

        // Comentarios
        echo "<p><strong>Comentarios: </strong>".$_POST["comentarios"]."</p>";



} else {
    header("Location:index.html");
}
?>



