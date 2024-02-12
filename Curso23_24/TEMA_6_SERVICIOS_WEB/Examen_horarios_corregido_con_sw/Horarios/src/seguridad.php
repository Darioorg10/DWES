<?php 
    // Si estoy logueado
    $url = DIR_SERV . "/logueado";
    $datos["api_session"] = $_SESSION["api_session"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die(error_page("Examen SW 22_23", "<h1>Examen 2 23_24 SW</h1><p>Error consumiendo el servicio : $url</p>"));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Examen SW 22_23", "<h1>Examen 2 23_24 SW</h1><p>Error consumiendo el servicio : " . $obj->error . "</p>"));
    }

    // Cuando el tiempo de la API caduca (el token)
    if (isset($obj->no_auth)) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location:index.php");
        exit;
    }

    // Me han baneado
    if (isset($obj->mensaje)) {
        session_unset();
        $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la base de datos";
        header("Location:index.php");
        exit;
    }

    $datos_usuario_log = $obj->usuario; // Guardamos los datos del usuario logueado

    // Si se acaba el tiempo
    if (time()-$_SESSION["ult_accion"] > MINUTOS*60) {
        session_unset();
        $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
        header("Location:index.php");
        exit;
    }

    $_SESSION["ult_accion"] = time();
?>