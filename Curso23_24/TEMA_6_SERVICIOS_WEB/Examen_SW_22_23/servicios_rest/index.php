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

// Hacemos los métodos que nos pide
// a)
$app->post("/login", function($request){
    $datos = array("lector" => $request->getParam("lector"), "clave" => $request->getParam("clave"));

    echo json_encode(login($datos["lector"], $datos["clave"]));
});

// b)
$app->get("/logueado", function($request){

});

// c)
$app->post("/salir", function($request){

});

// d)
$app->get("/obtenerLibros", function(){
    echo json_encode(obtenerLibros());
});

// e)
$app->post("/crearLibro", function($request){

});

// f)
$app->put("/actualizarPortada/{referencia}", function($request){

});

// g)
$app->get("/repetido/{tabla}/{columna}/{valor}", function($request){

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
