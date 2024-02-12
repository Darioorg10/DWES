<?php 

    require "../src/func_ctes.php";
    session_name("practica_exa_sw_22_23"); // El session name es el mismo que el del index
    session_start();

    if (isset($_SESSION["usuario"])) {
        require "../src/seguridad.php";

        if ($datos_usuario_log->tipo == "admin") {
            require "../vistas/vista_admin.php";
        } else {
            header("Location:../index.php");
            exit;
        }


    } else {
        header("Location:../index.php");
        exit;
    }

?>