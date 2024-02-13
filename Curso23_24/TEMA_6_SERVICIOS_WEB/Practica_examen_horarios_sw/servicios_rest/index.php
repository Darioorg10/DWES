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
        echo json_encode(array("no_auth" => "No tienes permisos para realizar esta acción")); // Ha caducado la sesión de la api
    }
});

$app->get("/salir", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();
});

$app->get("/obtenerProfesoresNormales", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtenerProfesoresNormales());
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para realizar esta acción")); // Ha caducado la sesión de la api
    }
});

$app->get("/obtenerHorarioPorId", function($request){        
    echo json_encode(obtenerHorarioPorId($request->getParam("id_usuario")));    
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
