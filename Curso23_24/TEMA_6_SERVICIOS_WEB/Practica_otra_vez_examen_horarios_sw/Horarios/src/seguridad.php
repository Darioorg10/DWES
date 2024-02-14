<?php

    $url = DIR_SERV."/logueado";
    $datos["api_session"] = $_SESSION["api_session"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Horario", "<p>Error en: $url</p>"));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Horario", "<p>Error: " . $obj->error."</p>"));
    }

    if (isset($obj->mensaje)) {
        session_unset();
        $_SESSION["seguridad"] = "El usuario ha sido baneado";
        header("Location:index.php");
        exit;
    }

    if (isset($obj->no_auth)) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión en la api ha caducado";
        header("Location:index.php");
        exit;
    }

    $datos_usuario_log = $obj->usuario;

    if (time() - $_SESSION["ult_accion"] > MINUTOS*60) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión del usuario ha caducado";
        header("Location:index.php");
        exit;
    }

    $_SESSION["ult_accion"] = time();


?>
