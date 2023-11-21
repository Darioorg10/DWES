<?php 
    try {
        $consulta = "select * from usuarios where id_usuario='".$_POST['btnListar']."'";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        die(error_page("Práctica 8", "<p>No ha podido conectarse a la base de datos: ".$e->getMessage()."</p>"));
        mysqli_close($conexion);
    }

    // Comprobación por si se borra un usuario mientras estamos nosotros mirando
    if (mysqli_num_rows($resultado) > 0) {
        $datos_usuario = mysqli_fetch_assoc($resultado);
        echo "<p><strong>Usuario: </strong>".$datos_usuario["usuario"]."</p>";
        echo "<p><strong>Nombre: </strong>".$datos_usuario["nombre"]."</p>";
        echo "<p><strong>DNI: </strong>".$datos_usuario["dni"]."</p>";
        echo "<p><strong>Sexo: </strong>".$datos_usuario["sexo"]."</p>";
        echo "<strong>Foto: </strong><p><img class='foto_detalle' src='Img/".$datos_usuario["foto"]."'</p>";
    } else {
        echo "<p>El usuario seleccionado no está ya en la base de datos</p>";
    }     

    // Hacemos el botón para volver
    echo "<form action='index.php' method='post'>";
    echo "<button type='submit'>Volver</button>";
    echo "</form>";
?>