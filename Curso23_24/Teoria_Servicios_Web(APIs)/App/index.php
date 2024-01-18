<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría servicios web</title>
</head>
<body>
    <h1>Teoría servicios web</h1>
    <?php

    define("DIR_SERV", "http://localhost/Proyectos/DWES/Curso23_24/Teoria_Servicios_Web(APIs)/primera_api");

    // Esta función es lo mismo que el file_get_contents, pero sirve para post, put y delete también
    function consumir_servicios_REST($url, $metodo, $datos = null){
        $llamada = curl_init();
        curl_setopt($llamada, CURLOPT_URL, $url);
        curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
        if (isset($datos))
            curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
        $respuesta = curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }

    $url = DIR_SERV . "/saludo";
    // $respuesta = file_get_contents($url); Así sería con el file_get_contents
    $respuesta = consumir_servicios_REST($url, "GET");

    // Hacemos el decode al json (a lo que le hicimos encode antes)
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    echo "<p>El saludo recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";

    // Otro saludo pero con parámetro
    $url = DIR_SERV . "/saludo/".urlencode("María Antonia"); // Si solo fuera una palabra no hace falta el urlencode (porque al ser parte de la url no da problema si no le pones espacios)
    $respuesta = consumir_servicios_REST($url, "GET");
    
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    echo "<p>El saludo recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";

    // Ahora con el de post
    $url = DIR_SERV."/saludo";
    $datos["nombre"] = "Juan Alonso";
    $respuesta = consumir_servicios_REST($url, "POST", $datos); // Aquí le tenemos que pasar otro parámetro (el array con los datos)
    
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    echo "<p>El saludo recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";

    // Ahora con el delete
    $url = DIR_SERV."/borrar_saludo/95";
    $respuesta = consumir_servicios_REST($url, "DELETE");
    
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    echo "<p>El mensaje recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";

    // Ahora con el put
    $url = DIR_SERV."/actualizar_saludo/78";
    $datos["nombre"] = "Pepe Pepito";
    $respuesta = consumir_servicios_REST($url, "PUT", $datos); // Aquí le tenemos que pasar otro parámetro (el array con los datos)
    
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    echo "<p>El mensaje recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";

    ?>
</body>
</html>