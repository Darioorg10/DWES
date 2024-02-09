<?php

    // Activamos la seguridad si el usuario está logueado, para ello llamamos a la función y le pasamos la api_session
    $url = DIR_SERV . "/logueado";
    $datos["api_session"] = $_SESSION["api_session"];

    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Examen horarios con sw", "Ha habido un error"));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Examen horarios con sw", "Ha habido un error: " . $obj->error));
    }

    // Esto será cuando el tiempo de la api caduca
    if (isset($obj->no_auth)) {
        session_unset(); // No queremos quitar todas las sesiones
        $_SESSION["seguridad"] = "El tiempo de sesión de la api ha caducado";
        header("Location:../index.php");
        exit;
    }

    // Esto será que te han baneado
    if (isset($obj->mensaje)) { 
        session_unset(); // No queremos quitar todas las sesiones
        $_SESSION["seguridad"] = "Ya no estás registrado en la base de datos";
        header("Location:../index.php");
        exit;
    }

    // Vamos a guardar los datos del usuario logueado por si nos hacen falta
    $datos_usuario_log = $obj->usuario;

    // Vamos a hacer el control de tiempo
    if (time() - $_SESSION["ult_accion"] > MINUTOS*60) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de tu sesión ha expirado";
        header("Location:../index.php");
        exit;
    }

    // Reseteamos el tiempo
    $_SESSION["ult_accion"] = time();

?>