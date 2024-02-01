<?php

    $url = DIR_SERV."/usuarios"; // Aquí obteníamos el listado de usuarios
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);

    // Si no existe el objeto
    if (!$obj) {
        session_destroy();
        die("<p>Error consumiendo el servicio: ".$url."</p></body></html>");
    }

    // Si nos devuelve un error
    if (isset($obj->error)) {
        session_destroy();
        die("<p>".$obj->error."</p></body></html>");
    }

    // Creamos la tabla
    echo "<table>";
    echo "<tr><th>Nombre de usuario</th><th>Borrar</th><th>Editar</th></tr>";
    foreach($obj->usuarios as $tupla) {
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' name='btnDetalle' title='Listar usuario' value='" . $tupla->id_usuario . "'>" . $tupla->nombre . "</button></form></td>"; // Le ponemos como valor la clave primaria para tenerlo como dato
        echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='" . $tupla->nombre . "'</input><button class='enlace' type ='submit' value='" . $tupla->id_usuario . "' name='btnBorrar'><img src='images/borrar.png' alt='Imagen de borrar' title='Borrar usuario'</button></form></td>"; // Hay que hacer un formulario por fila o botón para evitar errores
        echo "<td><form action='index.php' method='post'><button class='enlace' type ='submit' value='" . $tupla->id_usuario . "' name='btnEditar'><img src='images/editar.png' alt='Imagen de editar' title='Editar usuario'</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";    

    if (isset($_SESSION["mensaje"])) {
        echo "<p class='mensaje'>" . $_SESSION['mensaje'] . "</p>";
        session_destroy();
    }
