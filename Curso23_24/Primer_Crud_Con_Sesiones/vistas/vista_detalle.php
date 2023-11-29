<?php 
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

    // En cada select tenemos que mostrar el resultado
    mysqli_free_result($resultado);
    mysqli_close($conexion); 
?>