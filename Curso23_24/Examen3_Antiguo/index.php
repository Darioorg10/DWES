<?php

// Iniciamos la sesión
session_name("Examen3_17-18");
session_start();
include_once "src/ctes_y_func.php";

if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}

// Si estoy logueado voy por un lado
if (isset($_SESSION["usuario"])) {
    // Seguridad
    require "src/seguridad.php";

    // Vista oportuna
    require "vistas/vista_examen.php";

    mysqli_close($conexion);

} else {
    // Si no estoy logueado, voy por otro lado
    require "vistas/vista_login.php";
}

?>