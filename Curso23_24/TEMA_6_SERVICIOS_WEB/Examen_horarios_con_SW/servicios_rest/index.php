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

// Vamos a crear los métodos necesarios
$app->get("/login", function($request){
    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");

    echo json_encode(login($usuario, $clave));
});

$app->get("/logueado", function($request){

});

$app->get("/salir", function($request){

});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
