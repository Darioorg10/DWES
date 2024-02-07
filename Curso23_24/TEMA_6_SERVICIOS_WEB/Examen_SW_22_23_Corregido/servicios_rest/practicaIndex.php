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

    $usuario = $request->getParam("lector"); // Al hacer la llamada curl tendrán que pasarnos el parámetro como lector
    $clave = $request->getParam("clave");    

    echo json_encode(login($usuario, $clave));

});

// b)
$app->get("/logueado", function($request){

    $token = $request->getParam("api_session");
    session_id($token);
    session_start();

    // Si el usuario con ese token tiene la sesión iniciada
    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

});

// c)
$app->post("/salir", function($request){

    // Aquí lo que hacemos es coger el token de la sesión y cerrarla para que deje de
    // consumir recursos, por eso cogemos el id, la iniciamos y la destruimos
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Cerrada sesión en la api"));

});

// d)
$app->get("obtenerLibros", function(){
    echo json_encode(obtenerLibros());
});

// e)
$app->post("/crearLibro", function($request){

    $token = $request->getParam("api_session");
    session_id($token);

    // Solo vamos a poder insertar libros cuando seamos admin
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam("referencia");
        $datos[] = $request->getParam("titulo");
        $datos[] = $request->getParam("autor");
        $datos[] = $request->getParam("descripcion");
        $datos[] = $request->getParam("precio");
        
        echo json_encode(insertarLibro($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes los permisos para ejecutar este servicio"));
    }

});

// f)
$app->put("/actualizarPortada{referencia}", function($request){

    $token = $request->getParam("api_session");
    session_id($token);    

    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        
        $datos[] = $request->getParam("nombre_nuevo");
        $datos[] = $request->getAttribute("referencia");

        echo json_encode(actualizarPortada($datos));

    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes los permisos para ejecutar este servicio"));
    }    

});


// g)
$app->get("/repetido/{tabla}/{columna}/{valor}", function($request){
    $token = $request->getParam("api_session");
    session_id($token);    

    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(repetido($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes los permisos para ejecutar este servicio"));
    }    
});

// Una vez creado servicios los pongo a disposición
$app->run();
?>