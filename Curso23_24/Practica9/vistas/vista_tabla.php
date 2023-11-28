<?php 
    try {
        $consulta = "select * from peliculas";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
    }    
?>
    <table>
        <tr>
            <th>id</th>
            <th>Título</th>
            <th>Carátula</th>
            <th><form action="index.php" method="post"><button type="submit" class="enlace" name="btnInsertar">Películas+</button></form></th>
        </tr>
<?php
    while ($tupla = mysqli_fetch_assoc($resultado)) { // Mientras haya datos
        echo "<tr>";
        echo "<td>".$tupla['idPelicula']."</td>";
        echo "<td><form action='index.php' method='post'><button type='submit' name='btnDetalle' class='enlace' value='".$tupla['idPelicula']."'>".$tupla['titulo']."</button></form></td>";
        echo "<td><img src='Img/".$tupla['caratula']."'></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' name='btnBorrar' value='".$tupla['idPelicula']."'>Borrar</button> - <button type='submit' class='enlace' value='".$tupla["idPelicula"]."'>Editar</button></form></td>";
        echo "</tr>";
    }
?>                
    </table>
<?php
    // Liberamos el resultado luego de haber hecho un select
    mysqli_free_result($resultado);
    mysqli_close($conexion);
?>