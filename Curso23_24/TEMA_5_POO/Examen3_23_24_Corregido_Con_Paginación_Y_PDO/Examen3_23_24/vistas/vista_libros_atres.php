<?php
echo "<h3>Listado de los libros</h3>";
        

try{
    $consulta="select * from libros";
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute();
}
catch(PDOException $e)
{
    session_destroy();
    $conexion = null;
    die("<p>No he podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

while($tupla=$sentencia->fetch(PDO::FETCH_ASSOC))
{
    echo "<p class='libros'>";
    echo "<img src='img/".$tupla["portada"]."' alt='imagen libro' title='imagen libro'><br>";
    echo $tupla["titulo"]." - ".$tupla["precio"]."€";
    echo "</p>";
}

$sentencia = null;

?>