<?php 
    echo "<p>Te dispones a borrar la película con id: <strong>".$_POST['btnBorrar']."</strong>. ¿Estás seguro de que quieres borrarla?</p>";
    echo "<p><form action='index.php' method='post'><button type='submit' name='btnContBorrar' value='".$_POST['btnBorrar']."'>Continuar</button>";
    echo "<button type='submit' name='volver'>Volver</button></form></p>";
?>