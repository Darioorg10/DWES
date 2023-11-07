<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1ºCRUD</title>
    <style>
        table, td, th{
            border: 1px solid black;
        }

        table{
            border-collapse: collapse;
            text-align: center;
        }

        th{
            background-color: #CCC;
        }

        img{
            width: 50px;
            height: 50px;
        }
        
        .enlace{
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Listado de los usuarios</h1>
    <?php 
        try {
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("<p>No se ha podido conectarse a la base de datos: ".$e->getMessage()."</p></body></html>");
        }                

        try {
            $consulta = "select * from usuarios";
            $resultado = mysqli_query($conexion, $consulta);            
        } catch (Exception $e) {
            die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
            mysqli_close($conexion); // Cerramos la conexión            
        }

        // Creamos la tabla
        echo "<table>";
        echo "<tr><th>Nombre de usuario</th><th>Borrar</th><th>Editar</th></tr>";
        while($tupla = mysqli_fetch_assoc($resultado)){
            echo "<tr>";
            echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' name='btnDetalle' title='Listar usuario' value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</button></form></td>"; // Le ponemos como valor la clave primaria para tenerlo como dato
            echo "<td><form action='index.php' method='post'><button class='enlace' type ='submit' value='".$tupla["id_usuario"]."' name='btnBorrar'><img src='images/borrar.png' alt='Imagen de borrar' title='Borrar usuario'</button></form></td>"; // Hay que hacer un formulario por fila o botón para evitar errores
            echo "<td><form action='index.php' method='post'><button class='enlace' type ='submit' value='".$tupla["id_usuario"]."' name='btnEditar'><img src='images/editar.png' alt='Imagen de editar' title='Editar usuario'</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Si se pulsa un nombre que nos de los datos
        if (isset($_POST["btnDetalle"])) {
            echo "<h3>Detalles del usuario con id: ".$_POST['btnDetalle']."</h3>";

            // Hacemos la consulta
            try {
                $consulta = "select * from usuarios where id_usuario='".$_POST["btnDetalle"]."'";
                $resultado = mysqli_query($conexion, $consulta);            
            } catch (Exception $e) {
                die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
                mysqli_close($conexion); // Cerramos la conexión            
            }

            // Comprobamos que exista por si se borra un usuario
            if (mysqli_num_rows($resultado) > 0) { // Si hemos obtenido alguna tupla
                $datos_usuario = mysqli_fetch_assoc($resultado);

                echo "<p>";
                echo "<strong>Nombre: </strong>".$datos_usuario["nombre"]."<br>";
                echo "<strong>Usuario: </strong>".$datos_usuario["usuario"]."<br>";
                echo "<strong>Email: </strong>".$datos_usuario["email"]."<br>";
                echo "</p>";
            } else {
                echo "<p>El usuario seleccionado ya no está registrado en la BD</p>";
            }         
            
            // Botón para volver
            echo "<form action='index.php' method='post'>";
            echo "<p><button type='submit' name='btnVolver'>Volver</button></p>";
            echo "</form>";            

        } else if(isset($_POST["btnBorrar"])){

        } else if(isset($_POST["btnEditar"])){
                    
        } else {
            // Si le damos click a insertar que nos mande a la otra página
            echo "<form action='usuario_nuevo.php' method='post'>";
            echo "<p><button type='submit' name='btnNuevoUsuario'>Insertar nuevo usuario</button></p>";
            echo "</form>";
        }                

        mysqli_free_result($resultado); // Para liberar memoria
        mysqli_close($conexion); // Cerramos la conexión
    ?>        
</body>
</html>