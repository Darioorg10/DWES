<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Recogida de datos</title>
                <style>
                    .error{color:red}
                    .tam_imag{width: 35%;}
                </style>
            </head>
            <body>
                <h1>Recogiendo los datos...</h1>
                <?php
                echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
                echo "<p><strong>Apellido: </strong>".$_POST["apellidos"]."</p>";
                echo "<p><strong>Contraseña: </strong>".$_POST["contrasena"]."</p>";
                echo "<p><strong>DNI: </strong>".$_POST["dni"]."</p>";

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
                
                if ($_FILES["archivo"]["name"] != "") {
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
                } else {
                    echo "<p><strong>Foto: </strong>Foto no seleccionada</p>";
                } 
                    
                        
                
                
                

                ?>
            </body>
            </html>
            
            
            