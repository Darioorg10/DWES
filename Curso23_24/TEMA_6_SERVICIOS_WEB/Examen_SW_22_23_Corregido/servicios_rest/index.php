<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



$app->get('/conexion_PDO',function($request){

    echo json_encode(conexion_pdo());
});

// a)
$app->post("/login", function($request){
    $lector = $request->getParam("lector");
    $clave = $request->getParam("clave");

    echo json_encode(login($lector, $clave));
});

/* Para probar el login
$app->get("/login", function($request){
    $lector="dario";
    $clave = md5("123");

    echo json_encode(login($lector, $clave));
});
*/

// b)
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

// c)
$app->post("salir", function($request){
    // Aquí lo que hacemos es coger el token de la sesión y cerrarla para que deje de
    // consumir recursos, por eso cogemos el id, la iniciamos y la destruimos
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Cerrada sesión en la API"));
});

// d)
$app->get("/obtenerLibros", function(){ // Esta no hay que protegerla (porque no te pide que pases la api_session y lo haces en el home sin loguearte)
    echo json_encode(obtenerLibros());
});

// e)
$app->post("/crearLibro", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam("referencia");
        $datos[] = $request->getParam("titulo");        
        $datos[] = $request->getParam("autor");
        $datos[] = $request->getParam("descripcion");
        $datos[] = $request->getParam("precio");

        echo json_encode(insertar_libro($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// f)
$app->put("/actualizarPortada/{referencia}", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam("portada");
        $datos[] = $request->getAttribute("referencia");

        echo json_encode(actualizarPortada($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// g)
$app->get("/repetido/{tabla}/{columna}/{valor}", function($request){
    $token = $request->getParam("api_session");
    session_id($token);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(repetido($request->getAttribute("tabla"),$request->getAttribute("columna"),$request->getAttribute("valor")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

    /* 
        Si quisieramos saber por qué no funciona al dar un error, podemos coger la url del error, y aquí en el get solo poner el echo
        echo json_encode(repetido($request->getAttribute("tabla"),$request->getAttribute("columna"),$request->getAttribute("valor")));
    */
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
