<?php

require "src/funciones_ctes.php";

require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


$app->post("/login", function($request){
    $usuario = $request->getParam("usuario"); // Le pasamos los dos parámetros por debajo
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave)); // Tenemos que crear una función login que nos devuelva un array

});


/* Para probarlo sin tener que crear una app
$app->get("/login", function($request){
    $usuario = "admin";
    $clave = md5("123");

    echo json_encode(login($usuario, $clave)); // Tenemos que crear una función login que nos devuelva un array

});
*/

$app->run();
