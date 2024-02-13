<?php

session_name("practica_examen_horarios_sw_2_23_24");
session_start();

require "src/func_ctes.php";


if (isset($_POST["btnSalir"])) {
    $url = DIR_SERV."/salir";
    $datos["api_session"] = $_SESSION["api_session"];
    consumir_servicios_REST($url, "GET", $datos);
    session_destroy();
    header("Location:index.php");
    exit;
}

// Si estoy logueado
if (isset($_SESSION["usuario"])) {
    require "src/seguridad.php";
    if ($datos_usuario_log->tipo == "admin") {
        require "vistas/vista_admin.php";
    } else {
        require "vistas/vista_normal.php";
    }
} else {
    require "vistas/vista_home.php";
}

?>
