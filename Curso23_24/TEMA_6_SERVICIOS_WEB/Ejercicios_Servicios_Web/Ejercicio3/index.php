<?php

require "src/funciones_ctes.php";

require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

// a)
$app->get("/usuarios", function(){
    echo json_encode(obtener_usuarios());
});

// Para el CRUD necesitamos sacar usuario por código
$app->get("/usuario/{id_usuario}", function($request){
    $id = $request->getAttribute("id_usuario");
    echo json_encode(obtener_usuario($id));
});

// b)
$app->post("/crearUsuario", function($request){    
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    $datos[] = $request->getParam("email");

    echo json_encode(insertar_usuario($datos));
});

// d)
$app->put("/actualizarUsuario/{id_usuario}", function($request){
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    $datos[] = $request->getParam("email");

    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(actualizar_usuario($datos));
});

// Para el crud, al editar necesitamos poder actualizar sin meterle valor en la clave
$app->put("/actualizarUsuarioSinClave/{id_usuario}", function($request){
    $datos[] = $request->getParam("nombre");
    $datos[] = $request->getParam("usuario");    
    $datos[] = $request->getParam("email");

    $datos[] = $request->getAttribute("id_usuario");

    echo json_encode(actualizar_usuario_sin_clave($datos));
});

// e)
$app->delete("/borrarUsuario/{id_usuario}", function($request){
    $id = $request->getAttribute("id_usuario");
    echo json_encode(borrar_usuario($id));
});


// Del login (c)
$app->post("/login", function($request){
    $usuario = $request->getParam("usuario"); // Le pasamos los dos parámetros por debajo
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave)); // Tenemos que crear una función login que nos devuelva un array

});

// Para el CRUD vamos a hacer una función para comprobar si está repetido
$app->get("/repetido/{tabla}/{columna}/{valor}", function($request){
    echo json_encode(repetido($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor")));
});

// Y el de editar
$app->get("/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}", function($request){
    echo json_encode(repetido_editar($request->getAttribute("tabla"), $request->getAttribute("columna"), $request->getAttribute("valor"), $request->getAttribute("columna_id"), $request->getAttribute("valor_id")));
});


/* Para probarlo sin tener que crear una app
$app->get("/login", function($request){
    $usuario = "admin";
    $clave = md5("123");

    echo json_encode(login($usuario, $clave)); // Tenemos que crear una función login que nos devuelva un array

});
*/

$app->run();
