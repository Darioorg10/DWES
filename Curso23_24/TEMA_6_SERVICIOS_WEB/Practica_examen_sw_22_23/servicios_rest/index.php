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


$app->post("/login", function($request){
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
        echo json_encode(array("no_auth" => "No tienes los permisos necesarios"));
    }
});

$app->post("/salir", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Cerrada sesión en la API"));
});

$app->get("/obtener_libros", function(){
    echo json_encode(obtener_libros());
});

$app->post("/crear_libro", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    if (isset($_SESSION["usuario"])) {
        echo json_encode(crear_libro($request->getParam("referencia"), $request->getParam("titulo"), $request->getParam("autor"), $request->getParam("descripcion"), $request->getParam("precio")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes los permisos necesarios"));
    }
});

$app->get("/repetido", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    if (isset($_SESSION["usuario"])) {
        echo json_encode(repetido($request->getParam("tabla"), $request->getParam("columna"), $request->getParam("valor")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes los permisos necesarios"));
    }
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
