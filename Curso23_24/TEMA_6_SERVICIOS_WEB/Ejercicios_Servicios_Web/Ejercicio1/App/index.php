<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación web de prueba de servicios</title>
</head>
<body>
    <?php
    define("DIR_SERV", "http://localhost/Proyectos/DWES/Curso23_24/TEMA_6_SERVICIOS_WEB/Ejercicios_Servicios_Web/Ejercicio1/servicios_rest");
    
    function consumir_servicios_REST($url, $metodo, $datos = null)
    {
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

    $datos["cod"] = "YYYYYYYY";
    $datos["nombre"] = "producto a borrar";
    $datos["nombre_corto"] = "producto a borrar";
    $datos["descripcion"] = "Descripción a borrar";
    $datos["PVP"] = "25.5";
    $datos["familia"] = "MP3";

    $url = DIR_SERV . "/producto/insertar";
    $respuesta = consumir_servicios_REST($url, "POST", $datos);
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    
    if (isset($obj->mensaje_error)) {
        die("<p>".$obj->mensaje_error."</p></body></html>");
    }

    echo "<p>".$obj->mensaje."</p>";

    ?>
</body>
</html>