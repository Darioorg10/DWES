<?php
    try {
        $conexion = mysqli_connect(HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
    } catch (Exception $e) {
        die("<p>No se ha podido realizar la conexión con la base de datos: ".$e->getMessage()."</p></body></html>");
    }
        try {
            $consulta = "select * from peliculas where idPelicula = '".$_POST['btnDetalle']."'";
            $resultado = mysqli_query($conexion, $consulta);                
        } catch (Exception $e) {
            die(error_page("Videoclub", "<p>No se han podido listar los datos: ".$e->getMessage()."</p>"));
        }

        // Si obtenemos resultado
        if (mysqli_num_rows($resultado) > 0) { 
            $datos_pelicula = mysqli_fetch_assoc($resultado);
            ?>
                <p><strong>Título: </strong><?php echo $datos_pelicula["titulo"];?></p>
                <p><strong>Director: </strong><?php echo $datos_pelicula["director"];?></p>
                <p><strong>Sinopsis: </strong><?php echo $datos_pelicula["sinopsis"];?></p>
                <p><strong>Temática: </strong><?php echo $datos_pelicula["tematica"];?></p>
                <p><strong>Carátula: </strong><br><img src="Img/<?php echo $datos_pelicula["caratula"];?>"></p>
                <form action="index.php">
                    <button type="submit">Volver</button>
                </form>
            <?php
        } else {
            echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
        }

        mysqli_free_result($resultado);
        mysqli_close($conexion);
?>