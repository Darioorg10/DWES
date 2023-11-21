<?php
echo "<p>Se dispone usted a borrar al usuario con id: ".$_POST['btnBorrar']."</p>";
echo "<form action='index.html' method='post'>";

echo "</form>";
    try {
        $consulta = "delete from usuarios where id_usuario=".$_POST['btnBorrar']."";        
        $resultado = mysqli_query($conexion, $consulta);
        echo "<br>El usuario seleccionado ha sido borrado correctamente";
    } catch (Exception $e) {
        die(error_page("Práctica 8", "<p>No ha podido conectarse a la base de datos: ".$e->getMessage()."</p>"));
        mysqli_close($conexion);
    }

    /*
    if ($_POST["nombre_foto"] != "no_imagen.jpg") {
        unlink("Img/".$_POST["nombre_foto"]);        
    }
    */
?>