<?php 

    require_once "func_ctes.php";

    $url = DIR_SERV."/logueado";
    $datos["api_session"] = $_SESSION["api_session"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: $url"));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: ".$obj->error));
    }

    if (isset($obj->mensaje)) {
        session_unset();
        $_SESSION["seguridad"] = "El usuario ya no se encuentra registrado en la base de datos";
    }

    $datos_usuario_log = $obj->usuario;

    if (time() - $_SESSION["ult_accion"] > MINUTOS*60) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión ha caducado";
        header("Location:index.php");
        exit;
    }

    $_SESSION["ult_accion"] = time();

?>