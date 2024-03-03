<?php 

$url = DIR_SERV."/logueado";
$datos["api_session"] = $_SESSION["api_session"];
$respuesta = consumir_servicios_REST($url, "GET", $datos);

$obj = json_decode($respuesta);

if (!$obj) {
    session_destroy();
    die(error_page("Examen4", "Ha habido un error en $url"));
}

if (isset($obj->error)) {
    session_destroy();
    die(error_page("Examen4", "Ha habido un error al consumir el servicio: ".$obj->error.""));
}

if (isset($obj->mensaje)) {
    session_unset();
    $_SESSION["mensaje"] = "El usuario ha sido baneado";
    header("Location:$salto");
    exit;
}

if (isset($obj->no_auth)) {
    session_unset();
    $_SESSION["mensaje"] = "El tiempo de sesión en la api ha caducado";
    header("Location:$salto");
    exit;
}

$datos_usuario_log = $obj->usuario;


if (time() - $_SESSION["ult_accion"] > MINUTOS*60) {
    session_unset();
    $_SESSION["mensaje"] = "El tiempo de sesión ha caducado";
    header("Location:$salto");
    exit;
}

$_SESSION["ult_accion"] = time();

?>