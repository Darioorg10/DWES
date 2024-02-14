<?php

    session_name("Examen_horarios_23_24_SW_s");
    session_start();

    require "src/funciones_ctes.php";

    if (isset($_POST["btnSalir"])) {
        $url = DIR_SERV."/salir";
        $datos["api_session"] = $_SESSION["api_session"]; // Se lo hemos pasado al loguearnos
        consumir_servicios_REST($url, "POST", $datos);
        session_destroy();
        header("Location:index.php");
        exit;
    }

    if (isset($_SESSION["usuario"])) {
        require "src/seguridad.php";

        if ($datos_usuario_log->tipo=="normal") {
            require "vistas/vista_normal.php";
        } else {
            require "vistas/vista_admin.php";
        }

    } else {
        require "vistas/vista_home.php";
    }

?>
