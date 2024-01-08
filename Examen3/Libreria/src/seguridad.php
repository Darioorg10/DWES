<?php

    // Nos conectamos con la base de datos
    try {
        $conexion = mysqli_connect(NOMBRE_HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        session_destroy();
        die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido establecerse la conexión a la base de batos: " . $e->getMessage() . "</p>"));
    }

    // Control de tiempo
    if(time()-$_SESSION["ultima_accion"]>MINUTOS_INACT*60) // Hay que poner el *60
    {
        mysqli_close($conexion);
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión ha expirado";
        header("Location:index.php");
        exit;
    }
    
    $_SESSION["ultima_accion"]=time();

?>