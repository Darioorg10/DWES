<?php 

    $url = DIR_SERV."/logueado";
    $datos["api_session"] = $_SESSION["api_session"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);

    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Práctica examen final", "Ha habido un error consumiendo el servicio: ".$url));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Práctica examen final", "Ha habido un error consumiendo el servicio: ".$obj->error));
    }

    if (isset($obj->mensaje)) {
        consumir_servicios_REST($url."/salir", "POST", $datos);
        session_unset();
        $_SESSION["seguridad"] = "El usuario ha sido baneado de la base de datos";
        header("Location:index.php");
        exit;
    }

    if (isset($obj->no_auth)) {
        session_unset();
        $_SESSION["seguridad"] = "No tienes permisos para utilizar este servicio";
        header("Location:index.php");
        exit;
    }

    $datos_usuario_log = $obj->usuario;

    if (time() - $_SESSION["ult_accion"] > MINUTOS * 60) {
        consumir_servicios_REST($url."/salir", "POST", $datos);
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión del usuario ha caducado";
        header("Location:index.php");
        exit;
    }

    $_SESSION["ult_accion"] = time();


?>