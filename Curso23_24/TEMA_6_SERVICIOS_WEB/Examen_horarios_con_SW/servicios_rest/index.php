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

// Hacemos lo pida o no el login, logueado y salir
$app->get("/login", function($request){
    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

$app->get("/logueado", function($request){

    $token = $request->getParam("api_session");
    session_id($token); // Cogemos el token de el usuario para comprobar si está logueado o no
    session_start();
    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

});

$app->post("salir", function($request){
    // Aquí lo que hacemos es coger el token de la sesión y cerrarla para que deje de
    // consumir recursos, por eso cogemos el id, la iniciamos y la destruimos
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Cerrada sesión en la API"));
});

$app->get("/obtenerUsuarios", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_usuarios());
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get("/obtenerHorario/{id_usuario}", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        echo json_encode(obtener_horario($request->getAttribute("id_usuario")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});



// Una vez creado servicios los pongo a disposición
$app->run();
?>
