<?php 

session_name("exa4_pra_sw");
session_start();

require "../src/func_ctes.php";

$salto = "../index.php";

if (isset($_POST["btnSalir"])) {
    $datos["api_session"] = $_SESSION["api_session"];
    $url = DIR_SERV."/salir";
    consumir_servicios_REST($url, "POST", $datos);
    session_destroy();
    header("Location:$salto");
    exit;
}


// Si hemos iniciado sesión
if (isset($_SESSION["usuario"])) {

    // Llamamos a seguridad
    require "../src/seguridad.php";

    if ($datos_usuario_log->tipo == "tutor") {
        require "../vistas/vista_admin.php";
    } else {
        header("Location:$salto");
    }
} else {
    require "../vistas/vista_home.php";
}




?>