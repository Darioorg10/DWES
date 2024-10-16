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


$app->post('/login',function($request){
    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

$app->get('/logueado',function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para utilizar este servicio"));
    }    
});

$app->post('/salir',function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Cerrada sesión en la api"));
});

$app->get('/alumnos',function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor") {
        echo json_encode(obtener_alumnos());
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para utilizar este servicio"));
    }    
});

$app->get('/notasAlumno/{cod_alu}',function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"])) {
        echo json_encode(obtener_notas_alumno($request->getAttribute("cod_alu")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para utilizar este servicio"));
    }    
});

$app->get('/NotasNoEvalAlumno/{cod_alu}',function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor") {
        echo json_encode(obtener_notas_no_eval_alumno($request->getAttribute("cod_alu")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para utilizar este servicio"));
    }    
});

$app->delete('/quitarNota/{cod_alu}',function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor") {        
        $datos[] = $request->getParam("cod_asig");
        $datos[] = $request->getAttribute("cod_alu");
        echo json_encode(quitar_nota($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para utilizar este servicio"));
    }    
});

$app->put('/cambiarNota/{cod_alu}',function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor") {
        $datos[] = $request->getParam("nota");
        $datos[] = $request->getParam("cod_asig");
        $datos[] = $request->getAttribute("cod_alu");
        echo json_encode(cambiar_nota($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para utilizar este servicio"));
    }    
});

$app->post('/ponerNota/{cod_alu}',function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor") {        
        $datos[] = $request->getParam("cod_asig");
        $datos[] = $request->getAttribute("cod_alu");
        echo json_encode(poner_nota($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para utilizar este servicio"));
    }    
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
