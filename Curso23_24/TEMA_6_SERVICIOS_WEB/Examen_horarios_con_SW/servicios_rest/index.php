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

// Vamos a crear los métodos necesarios
$app->get("/login", function($request){
    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

$app->get("/logueado", function($request){
    $token = $request->getParam("api_session"); // Comprobamos que el usuario con ese token esté logueado
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        echo json_encode(array("no_auth" => "No estás autorizado para hacer esto"));
    }

});

$app->post("/salir", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy(); // Destruimos la sesión
    echo json_encode(array("log_out" => "Has cerrado sesión en la api"));
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
