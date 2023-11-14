<?php

    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_cv");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("Práctica 8", "<p>No ha podido conectarse a la base de datos: ".$e->getMessage()."</p>"));
    }    
    
    // Consulta para coger los datos
    try {
        $consulta = "select * from usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("Práctica 8", "<p>No ha podido conectarse a la base de datos: ".$e->getMessage()."</p>"));
    }

    echo "<table>"; // El usuario+ es para insertar
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>Foto</th>";
    echo "<th>Nombre</th>";
    echo "<th><form action='index.php' method='post'><button class='enlace' name='btnInsertar'>Usuario+</button></form></th>";
    echo "</tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>"; // Hacemos un formulario por fila para evitar errores    
        echo "<td>".$tupla['id_usuario']."</td>";
        echo "<td>".$tupla['foto']."</td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' name='btnListar' value='".$tupla['id_usuario']."'>".$tupla['nombre']."</button></form></td>"; // Le pasamos el id como value para tenerlo como dato
        echo "<td><form action='index.php' method='post'><button class='enlace' name='btnBorrar' value='".$tupla['id_usuario']."'>Borrar</button> - <button class='enlace' name='btnEditar' value='".$tupla['id_usuario']."'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($resultado);
?>