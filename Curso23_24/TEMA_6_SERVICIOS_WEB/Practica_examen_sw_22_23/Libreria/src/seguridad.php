<?php
    
    // Tenemos que comprobar si el usuario que nos pasan está logueado
    $url = DIR_SERV . "/logueado";
    $datos["api_session"] = $_SESSION["api_session"];    
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Examen SW 22_23", "<h1>Librería</h1><p>Error consumiendo el servicio : $url</p>"));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Examen SW 22_23", "<h1>Librería</h1><p>Error consumiendo el servicio : " . $obj->error . "</p>"));
    }

    if (isset($obj->no_auth)) { // El tiempo de sesión de la api ha caducado
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la api ha caducado";
        header("Location:../index.php");
        exit;
    }


    if (isset($obj->mensaje)) { // El usuario está baneado
        session_unset();
        $_SESSION["seguridad"] = "El usuario está baneado";
        header("Location:../index.php");
        exit;
    }
    
    $datos_usuario_log = $obj->usuario;

    // Control de tiempo
    if (time() - $_SESSION["ult_accion"] > MINUTOS*60) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de tu sesión ha expirado";
        header("Location:../index.php");
        exit;        
    }

    $_SESSION["ult_accion"] = time();

?>
