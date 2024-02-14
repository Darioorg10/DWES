<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



$app->get('/conexion_PDO',function($request){

    echo json_encode(conexion_pdo());
});

$app->get('/conexion_MYSQLI',function($request){
    
    echo json_encode(conexion_mysqli());
});

$app->get("/login", function($request){
    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

$app->get("/logueado", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes los permisos para acceder a este servicio")); // Ha caducado el tiempo de sesión de la api
    }
    
});

$app->get("/salir", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Has cerrado sesión con éxito en la api"));
});

// Obtenemos los usuarios (protegido)
$app->get("/obtener_usuarios", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_usuarios());
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes los permisos para acceder a este servicio"));
    }
    
});

// Obtenemos los horarios por id de profesor (no protegido)
$app->get("/obtenerHorarioPorId", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        echo json_encode(obtenerHorarioPorId($request->getParam("id_usuario")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes los permisos para acceder a este servicio"));
    }
    
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
