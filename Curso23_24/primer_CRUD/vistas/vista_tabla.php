<?php
try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
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
            echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='".$tupla["nombre"]."'</input><button class='enlace' type ='submit' value='".$tupla["id_usuario"]."' name='btnBorrar'><img src='images/borrar.png' alt='Imagen de borrar' title='Borrar usuario'</button></form></td>"; // Hay que hacer un formulario por fila o botón para evitar errores
            echo "<td><form action='index.php' method='post'><button class='enlace' type ='submit' value='".$tupla["id_usuario"]."' name='btnEditar'><img src='images/editar.png' alt='Imagen de editar' title='Editar usuario'</button></form></td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($resultado);
?>