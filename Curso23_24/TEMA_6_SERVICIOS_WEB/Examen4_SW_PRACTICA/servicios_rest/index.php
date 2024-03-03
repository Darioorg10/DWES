<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

// a)
$app->post("/login", function($request){
    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");
    echo json_encode(login($usuario, $clave));
});

// b)
$app->get("/logueado", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// c)
$app->post("/salir", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Cerrada sesión en la api"));
});

// d)
$app->get("/alumnos", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor") {
        echo json_encode(alumnos());
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }    
});

// e)
$app->get("/notasAlumno/{cod_alu}", function($request){
    echo json_encode(notasAlumno($request->getAttribute("cod_alu")));
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>