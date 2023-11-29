<?php 
    session_name("Primer_CRUD_Sesion");
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer crud</title>
</head>
<style>

    table{
        text-align: center;
    }

    table, td, th{
        border: 1px solid black;
        border-collapse: collapse;
    }

    td{
        padding: 1rem;
    }

    .mensaje{
        color: blue;
    }

    .enlace{
        border: none;
        background-color: white;
        color: blue;
        text-decoration: underline;
        cursor: pointer;
    }
    
</style>
<body>
    <h1>Listado de los usuarios</h1>
    <form action="index.php" method="post">
        <table>
            <tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>
            <?php 
                // Hacemos la conexión con la base de datos
                try {
                    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
                    mysqli_set_charset($conexion, "utf8");
                } catch (Exception $e) {
                    session_destroy();
                    die("<p>No has podido conectarte a la base de datos: ".$e->getMessage()." </p></body></html>");
                }

                // Hacemos el select para sacar los datos
                try {
                    $consulta = "select * from usuarios";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    session_destroy();
                    die("<p>No has podido hacer el select: ".$e->getMessage()." </p></body></html>");
                }

                while ($tupla = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td><button class='enlace' name='btnDetalle' value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</button></td>";
                    echo "<td><button class='enlace' name='btnBorrar' value='".$tupla["id_usuario"]."'>X</button></td>";
                    echo "<td><button class='enlace' name='btnEditar' value='".$tupla["id_usuario"]."'>~</button></td>";
                    echo "</tr>";
                }
                  

            ?>
        </table><br>
        <button type="submit" name="btnInsertar">Insertar nuevo usuario</button>
    </form>
    <?php 
        if (isset($_SESSION["mensaje"])) {
            echo "<p class='mensaje'>".$_SESSION["mensaje"]."</p>";
        }

        if (isset($_POST["btnDetalle"])) {
        
            if (!isset($conexion)) {
                // Hacemos la conexión con la base de datos
                try {
                    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
                    mysqli_set_charset($conexion, "utf8");
                } catch (Exception $e) {
                    session_destroy();
                    die("<p>No has podido conectarte a la base de datos: ".$e->getMessage()." </p></body></html>");
                }
            }

            // Hacemos el select para sacar los datos
            try {
                $consulta = "select * from usuarios where id_usuario='".$_POST["btnDetalle"]."'";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                session_destroy();
                die("<p>No has podido hacer el select: ".$e->getMessage()." </p></body></html>");
            }

            while ($tupla = mysqli_fetch_assoc($resultado)) {
                echo "<p><strong>Nombre: </strong>".$tupla["nombre"]."</p>";
                echo "<p><strong>Usuario: </strong>".$tupla["usuario"]."</p>";
                echo "<p><strong>Email: </strong>".$tupla["email"]."</p>";
            }            

            echo "<form action='index.php' method='post'><button name='btnVolver'>Volver</button></form>";

            mysqli_free_result($resultado);
            mysqli_close($conexion);            


        }
    ?>
</body>
</html>