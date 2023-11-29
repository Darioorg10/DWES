<?php

    session_name("Primer_CRUD_Sesion");
    session_start();

    require "src/const_y_funciones.php";

    if (isset($_POST["btnContBorrar"])) {
        // Hacemos la conexión con la base de datos
        try {
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Primer CRUD", "<p>No has podido conectarte a la base de datos: ".$e->getMessage()." </p>"));
        }

        // Hacemos el delete para borrar los datos
        try {
            $consulta = "delete from usuarios where id_usuario=".$_POST["btnContBorrar"]."";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Primer CRUD", "<p>No has podido hacer el delete: ".$e->getMessage()." </p>"));
        }

        $_SESSION["mensaje"] = "Usuario borrado con éxito";
        session_destroy();
        mysqli_close($conexion);

    }    

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
        font-size: 20px;
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
                    // ¡¡¡¡¡¡¡¡¡¡¡ IMPORTANTE HACER UN FORM POR CADA BOTÓN !!!!!!!!!!!!
                    echo "<td><form action='index.php' method='post'><button class='enlace' name='btnDetalle' value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</button></form></td>";
                    echo "<td><form action='index.php' method='post'><input type='hidden' name='nombreOculto' value='".$tupla["nombre"]."'></input><button class='enlace' name='btnBorrar' value='".$tupla["id_usuario"]."'>X</button></form></td>";
                    echo "<td><form action='index.php' method='post'><button class='enlace' name='btnEditar' value='".$tupla["id_usuario"]."'>~</button></form></td>";
                    echo "</tr>";
                }
                  

            ?>
        </table><br>
        <button type="submit" name="btnInsertar">Insertar nuevo usuario</button>
    </form>
    <?php             

        if (isset($_POST["btnDetalle"])) {     

            require "vistas/vista_detalle.php";

        } else if(isset($_POST["btnBorrar"])){

            echo "<p>Se dispone a borrar al usuario ".$_POST["nombreOculto"]." con id: ".$_POST["btnBorrar"]."</p>";
            echo "<form action='index.php' method='post'><button name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button>";
            echo "<button name='btnAtras'>Atrás</button></form>";

        } else if(isset($_POST["btnInsertar"])){
            header("Location:usuario_nuevo.php");
        }

        // Mostramos el mensaje (al final de todos los if)
        if (isset($_SESSION["mensaje"])) {
            echo "<p class='mensaje'>".$_SESSION["mensaje"]."</p>";
        }

    ?>
</body>
</html>