<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

// Estos métodos tienen dos argumentos, el primero es la continuación que sería de la dirección en la que estamos
// es decir /Proyectos/CURSO23_23/TEMA_6_SERVICIOS_WEB/Teoria_Servicios_Web(APIs)/primera_api/saludo
$app->get('/saludo', function($request){ // En este caso vamos a hacer un método get con un parámetro (nombre)
    $respuesta["mensaje"] = "Hola";

    // La forma de enviar es con echo
    // Vamos a terminar siempre así, con un echo de un json con un array
    echo json_encode($respuesta);
});

$app->get('/saludo/{nombre}', function($request){ // En este caso vamos a hacer un método get con un parámetro (nombre)
    $valor_recibido = $request->getAttribute('nombre'); // Recogemos el atributo que está en el parámetro
    $respuesta["mensaje"] = "Hola ".$valor_recibido;
    echo json_encode($respuesta);
});

// Ahora con post, no está repetido porque este es post y el anterior get, aquí vamos a recoger el parámetro sin que sea visible (sin que esté en la url)
$app->post('/saludo', function($request){
    $valor_recibido = $request->getParam('nombre'); // En los post hay que llamarlo con el getParam, porque viene "por abajo" y no por la url
    $respuesta["mensaje"] = "Hola ".$valor_recibido;
    echo json_encode($respuesta);
});

// Delete
$app->delete('/borrar_saludo/{id}', function($request){
    $id_recibida = $request->getAttribute('id');
    $respuesta["mensaje"] = "Se ha borrado el saludo con id:".$id_recibida;
    echo json_encode($respuesta);
});

// Put
$app->put('/actualizar_saludo/{id}', function($request){
    $id_recibida = $request->getAttribute('id');
    $nombre_nuevo = $request->getParam('nombre');
    $respuesta["mensaje"] = "Se ha actualizado el saludo con id:$id_recibida al nombre: $nombre_nuevo";
    echo json_encode($respuesta);
});



// Una vez creado servicios los pongo a disposición
$app->run();
?>