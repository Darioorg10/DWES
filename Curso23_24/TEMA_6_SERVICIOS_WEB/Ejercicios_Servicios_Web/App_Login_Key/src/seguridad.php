<?php 
    $datos["api_key"] = $_SESSION["api_key"]; // Ahora tenemos que pasar la api ley
    $url = DIR_SERV . "/logueado";
    $respuesta = consumir_servicios_REST($url, "POST", $datos);
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die(error_page("App Login", "<h1>App Login</h1>" . $respuesta));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("App Login", "<h1>App Login</h1>" . $obj->error . "</p>"));
    }

    if (isset($obj->no_login)) {
        session_unset(); // Borramos todas las sesiones que haya (pero como vamos a crear una nueva, no ponemos el destroy)
        $_SESSION["seguridad"] = "El tiempo sesión de la api ha caducado";
        header("Location:index.php");
        exit;
    }

    // Aquí significaría que si existe es que te han baneado
    if (isset($obj->mensaje)) {
        session_unset(); // Borramos todas las sesiones que haya
        $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la base de datos";
        header("Location:index.php");
        exit;
    }

    $datos_usuario_log = $obj->usuario;

    // Por si ha acabado el tiempo de la sesión
    if (time()-$_SESSION["ult_accion"] > MINUTOS*60) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión ha caducado";
        header("Location:index.php");
        exit;
    }

    $_SESSION["ult_accion"] = time(); // Reiniciamos el tiempo
?>