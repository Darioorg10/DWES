<?php
session_name("Examen2_curso18_19");
session_start();

require "src/ctes_funciones.php";

if(isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

if (isset($_SESSION["usuario"])) {
    // Estoy logueado
    // seguridad
    require "src/seguridad.php";
    // Vista oportuna
    if ($datos_usuario_logueado["tipo"] == "admin") {
        mysqli_close($conexion);
        header("Location: admin/gest_clientes.php");
        exit();
    } else {
        require "vistas/vista_normal.php";
    }
    mysqli_close($conexion);
} else if (isset($_POST["btnRegistro"]) || isset($_POST["btnContRegistro"])) {
    require "vistas/vista_registro.php";
} else {
    require "vistas/vista_login.php";
}
?>