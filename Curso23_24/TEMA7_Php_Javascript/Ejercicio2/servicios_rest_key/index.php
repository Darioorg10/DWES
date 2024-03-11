<?php

require "src/funciones_ctes.php";

require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

// SI CAE UN LOGIN EN EL EXAMEN ESTAS TRES PRIMERAS (SALIR, LOGIN Y LOGUEADO) SON FUNDAMENTALES
// Creamos ahora un método para poder salir
$app->post("/salir", function($request){
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    echo json_encode(array("logout" => "Clossed session"));
});

$app->post("/login", function($request){
    $usuario = $request->getParam("usuario"); // Le pasamos los dos parámetros por debajo
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave)); // Tenemos que crear una función login que nos devuelva un array
});

// Ahora con lo de api_session
$app->post("/logueado", function($request){
    $api_session = $request->getParam("api_session");
    session_id($api_session); // Estas sesiones son con id en vez de con name
    session_start();

    // Si el usuario se ha logueado
    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }

});

// a) Información de todos los productos
$app->get("/productos", function ($request) {
    $api_session = $request->getParam("api_session");
    session_id($api_session); // Estas sesiones son con id en vez de con name
    session_start();
    if (isset($_SESSION["usuario"])) {
        echo json_encode(obtener_productos());
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// b) Todos los datos del producto cuyo código pongamos
$app->get("/producto/{cod}", function($request){ // A la function le tenemos que pasar una request si tenemos un parámetro en la url
    $api_session = $request->getParam("api_session");
    session_id($api_session); // Estas sesiones son con id en vez de con name
    session_start();
    $producto = $request->getAttribute("cod");
    if (isset($_SESSION["usuario"])) {
        echo json_encode(obtener_producto($producto));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }    
});

// c) Insertaremos los productos que le pasaremos por un formulario
$app->post("/producto/insertar", function($request){
    $api_session = $request->getParam("api_session");
    session_id($api_session); // Estas sesiones son con id en vez de con name
    session_start();
    $datos[] = $request->getParam("cod");
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("nombre_corto");
    $datos[] = $request->getParam("descripcion");
    $datos[] = $request->getParam("PVP");
    $datos[] = $request->getParam("familia");

    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(insertar_producto($datos)); // Los datos los tenemos en el orden que aparecen en el insert
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }    
});

// d) Actualizaremos todos los datos del producto especificado
$app->put("/producto/actualizar/{cod}", function($request){
    $api_session = $request->getParam("api_session");
    session_id($api_session); // Estas sesiones son con id en vez de con name
    session_start();
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("nombre_corto");
    $datos[] = $request->getParam("descripcion");
    $datos[] = $request->getParam("PVP");
    $datos[] = $request->getParam("familia");
    $datos[] = $request->getAttribute("cod");

    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(actualizar_producto($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }      
});

// e) Borrar un producto con un código
$app->delete("/producto/borrar/{cod}", function($request){
    $api_session = $request->getParam("api_session");
    session_id($api_session); // Estas sesiones son con id en vez de con name
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(borrar_producto($request->getAttribute("cod")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }      
});

// f) Información de todas las familias
$app->get("/familias", function($request){
    $api_session = $request->getParam("api_session");
    session_id($api_session); // Estas sesiones son con id en vez de con name
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(borrar_producto($request->getAttribute("cod")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }    
});

// Para el ejercicio 1 de ajax
$app->get("/familia/{cod}", function($request){
    $api_session = $request->getParam("api_session");
    session_id($api_session); // Estas sesiones son con id en vez de con name
    session_start();
    if (isset($_SESSION["usuario"])) {
        echo json_encode(obtener_familia($request->getAttribute("cod")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// g) Nos devuelve verdadero si ya existe el valor en una columna de una tabla (para los insertar)
$app->get("/repetido/{tabla}/{columna}/{valor}", function($request){
    $api_session = $request->getParam("api_session");
    session_id($api_session); // Estas sesiones son con id en vez de con name
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(repetido($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }    
});

// h) Nos devuelve verdadero si ya existe el valor en una columna de una tabla (para los editar)
$app->get("/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}", function($request){
    $api_session = $request->getParam("api_session");
    session_id($api_session); // Estas sesiones son con id en vez de con name
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(repetido_editar($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor"), $request->getAttribute("columna_id"), $request->getAttribute("valor_id")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->run();
