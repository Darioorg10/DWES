<?php

require "src/funciones_ctes.php";

require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

// SI CAE UN LOGIN EN EL EXAMEN ESTAS TRES PRIMERAS (SALIR, LOGIN Y LOGUEADO) SON FUNDAMENTALES
// Creamos ahora un método para poder salir
$app->post("/salir", function($request){
    session_id($request->getParam("api_key"));
    session_start();
    session_destroy();
    echo json_encode(array("logout" => "Clossed session"));
});

$app->post("/login", function($request){
    $usuario = $request->getParam("usuario"); // Le pasamos los dos parámetros por debajo
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave)); // Tenemos que crear una función login que nos devuelva un array
});

// Ahora con lo de api_key
$app->post("/logueado", function($request){
    $api_key = $request->getParam("api_key");
    session_id($api_key); // Estas sesiones son con id en vez de con name
    session_start();

    // Si el usuario se ha logueado
    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "No tienes permisos para usar este servicio"));
    }

});

// También cambiamos el usuarios, para que solo lo puedan obtener los admin
$app->get("/usuarios", function($request){
    $api_key = $request->getParam("api_key");
    session_id($api_key);
    session_start();

    // Cuando se haya iniciado sesión y sea admin
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_usuarios());    
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "no_logueado"));
    }
    
});

// Crear usuario solo lo van a poder hacer los admin
$app->post("/crearUsuario", function($request){  
    
    $api_key = $request->getParam("api_key");
    session_id($api_key);
    session_start();
    
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam("nombre");
        $datos[] = $request->getParam("usuario");
        $datos[] = $request->getParam("clave");
        $datos[] = $request->getParam("email");

        echo json_encode(insertar_usuario($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "no_logueado"));
    }

    
});

// Coger la información por id también está protegido
$app->get("/usuario/{id_usuario}", function($request){
    $api_key = $request->getParam("api_key");
    $id = $request->getAttribute("id_usuario");    
    session_id($api_key);
    session_start();

    // Cuando se haya iniciado sesión y sea admin
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(obtener_usuario($id));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "no_logueado"));
    }
    
});

// Protegemos
$app->put("/actualizarUsuario/{id_usuario}", function($request){
    $api_key = $request->getParam("api_key");    
    session_id($api_key);
    session_start();

    // Cuando se haya iniciado sesión y sea admin
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam("nombre");
        $datos[] = $request->getParam("usuario");
        $datos[] = $request->getParam("clave");
        $datos[] = $request->getParam("email");

        $datos[] = $request->getAttribute("id_usuario");

        echo json_encode(actualizar_usuario($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "no_logueado"));
    }
    
});

// Protegemos
$app->put("/actualizarUsuarioSinClave/{id_usuario}", function($request){
    $api_key = $request->getParam("api_key");    
    session_id($api_key);
    session_start();

    // Cuando se haya iniciado sesión y sea admin
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        $datos[] = $request->getParam("nombre");
        $datos[] = $request->getParam("usuario");
        $datos[] = $request->getParam("email");

        $datos[] = $request->getAttribute("id_usuario");

        echo json_encode(actualizar_usuario_sin_clave($datos));        
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "no_logueado"));
    }

    
});

// Protegemos
$app->delete("/borrarUsuario/{id_usuario}", function($request){
    $api_key = $request->getParam("api_key");    
    session_id($api_key);
    session_start();

    // Cuando se haya iniciado sesión y sea admin
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        $id = $request->getAttribute("id_usuario");
        echo json_encode(borrar_usuario($id));  
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "no_logueado"));
    }
    
});


// Protegemos
$app->get("/repetido/{tabla}/{columna}/{valor}", function($request){
    $api_key = $request->getParam("api_key");    
    session_id($api_key);
    session_start();

    // Cuando se haya iniciado sesión y sea admin
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(repetido($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor")));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "no_logueado"));
    }    
});

// Protegemos
$app->get("/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}", function($request){
    $api_key = $request->getParam("api_key");    
    session_id($api_key);
    session_start();

    // Cuando se haya iniciado sesión y sea admin
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] == "admin") {
        echo json_encode(repetido_editar($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor"), $request->getAttribute("columna_id"), $request->getAttribute("valor_id")));
    } else {
        session_destroy();
        echo json_encode(array("no_login" => "no_logueado"));
    }        
});


/* Para probarlo sin tener que crear una app
$app->get("/login", function($request){
    $usuario = "admin";
    $clave = md5("123");

    echo json_encode(login($usuario, $clave)); // Tenemos que crear una función login que nos devuelva un array

});
*/

$app->run();
