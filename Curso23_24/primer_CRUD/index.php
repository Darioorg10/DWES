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
            echo "<td>".$tupla["nombre"]."</td>";
            echo "<td><img src='images/borrar.png' alt='Imagen de borrar' title='Borrar usuario'</td>";
            echo "<td><img src='images/editar.png' alt='Imagen de editar' title='Editar usuario'</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Si le damos click a insertar que nos mande a la otra página
        echo "<form action='usuario_nuevo.php' method='post'>";
        echo "<p><button type='submit' name='btnNuevoUsuario'>Insertar nuevo usuario</button></p>";
        echo "</form>";        

        mysqli_close($conexion); // Cerramos la conexión
    ?>        
</body>
</html>