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
$app->get("/alumnos", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor") {
        echo json_encode(alumnos());
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }    
});

// e)
$app->get("/notasAlumno/{cod_alu}", function($request){
    echo json_encode(notasAlumno($request->getAttribute("cod_alu")));
});

// f)
$app->get("/NotasNoEvalAlumno/{cod_alu}", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor") {
        echo json_encode(NotasNoEvalAlumno($request->getAttribute("cod_alu")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }    
});

// g)
$app->delete("/quitarNota/{cod_alu}", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor") {
        $cod_asig = $request->getParam("cod_asig");
        $cod_alu = $request->getAttribute("cod_alu");
        echo json_encode(quitarNota($cod_asig, $cod_alu));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }    
});

// h)
$app->post("/ponerNota/{cod_alu}", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor") {
        $cod_asig = $request->getParam("cod_asig");
        $cod_alu = $request->getAttribute("cod_alu");
        echo json_encode(ponerNota($cod_asig, $cod_alu));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }    
});

// i)
$app->put("/cambiarNota/{cod_alu}", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "tutor") {
        $nota = $request->getParam("nota");
        $cod_asig = $request->getParam("cod_asig");        
        $cod_alu = $request->getAttribute("cod_alu");
        echo json_encode(cambiarNota($nota, $cod_asig, $cod_alu));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }    
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>