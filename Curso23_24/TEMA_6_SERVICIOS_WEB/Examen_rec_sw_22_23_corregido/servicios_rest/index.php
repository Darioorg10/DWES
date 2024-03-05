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
        session_destroy();
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
$app->get("/usuario/{id_usuario}", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        echo json_encode(obtener_datos_usuario($request->getAttribute("id_usuario")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// e)
$app->get("/usuariosGuardia/{dia}/{hora}", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    $dia = $request->getAttribute("dia");
    $hora = $request->getAttribute("hora");

    if (isset($_SESSION["usuario"])) {
        echo json_encode(obtener_usuarios_guardias_dia_hora($dia, $hora));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// f)
$app->get("/deGuardia/{dia}/{hora}/{id_usuario}", function($request){

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    $dia = $request->getAttribute("dia");
    $hora = $request->getAttribute("hora");
    $id_usuario = $request->getAttribute("id_usuario");

    if (isset($_SESSION["usuario"])) {
        echo json_encode(esta_de_guardia_dia_hora($dia, $hora, $id_usuario));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
