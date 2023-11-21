<?php 
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
?>