<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

// Conexión PDO
$app->get('/conexion_PDO', function ($request) {
    echo json_encode(conexion_pdo());
});

// Login
$app->get("/login", function ($request) {
    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");
    echo json_encode(login($usuario, $clave));
});

// Logueado
$app->post("/logueado", function ($request) {
    $api_session = $request->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio."));
    }
});

// Salir
$app->get("/salir", function ($request) {
    $api_session = $request->getParam("api_session");
    session_id($api_session);
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Cerrada sesión en la API"));
});

$app->get("/obtenerHorario", function ($request) {
    $api_session = $request->getParam("api_session");
    $id_usuario = $request->getParam("id_usuario");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"])) {
        echo json_encode(obtener_horario($id_usuario));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio."));
    }
});

$app->get("/obtenerGuardias", function ($request) {
    $api_session = $request->getParam("api_session");
    $dia = $request->getParam("dia");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_guardias($dia));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio."));
    }
});

$app->get("/obtenerProfesor", function ($request) {
    $api_session = $request->getParam("api_session");
    $id_usuario = $request->getParam("id_usuario");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_profesor($id_usuario));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio."));
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();
