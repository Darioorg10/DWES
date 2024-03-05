<?php

    session_name("exa_rec_sw_22_23_guardias");
    session_start();

    require "src/func_ctes.php";

    if (isset($_POST["btnSalir"])) {
        $url = DIR_SERV."/salir";
        $datos["api_session"] = $_SESSION["api_session"];
        consumir_servicios_REST($url, "POST", $datos);
        session_destroy();
        header("Location:index.php");
        exit;
    }


    // Si se ha iniciado sesión
    if (isset($_SESSION["usuario"])) {

        // Llamamos a seguridad
        require "src/seguridad.php";
        require "vistas/vista_app.php";

    } else {
        require "vistas/vista_login.php";
    }

?>
