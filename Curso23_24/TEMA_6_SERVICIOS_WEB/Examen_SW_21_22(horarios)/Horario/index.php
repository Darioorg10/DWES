<?php 

    session_name("exa_sw_21_22_pra_ind");
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

        if ($datos_usuario_log -> tipo == "admin") {
            require "vistas/vista_admin.php";
        } else {
            require "vistas/vista_normal.php";
        }

    } else {
        require "vistas/vista_home.php";
    }

?>