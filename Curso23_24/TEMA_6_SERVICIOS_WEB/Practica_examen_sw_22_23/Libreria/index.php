<?php

    session_name("practica_exa_sw_22_23");
    session_start();

    require "src/func_ctes.php";
    
    // Si le da al botón salir
    if (isset($_POST["btnSalir"])) {
        // Llamada al servicio
        $datos["api_session"] = $_SESSION["api_session"];
        $url = DIR_SERV . "/salir";
        consumir_servicios_REST($url, "POST", $datos);

        session_destroy();
        header("Location:index.php");
        exit;
    }
    
    // Si estoy logueado
    if (isset($_SESSION["usuario"])) {
        require "src/seguridad.php";

        // Si es admin me va a admin, y si no a vista normal        
        if ($datos_usuario_log->tipo == "admin") {
            header("Location:admin/gest_libros.php");
            exit;
        } else {
            require "vistas/vista_normal.php";
        }

    } else {        
        require "vistas/vista_home.php";
    }


?>