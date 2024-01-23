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
        
    /* PARA ACTUALIZAR
    $datos["nombre"] = "producto a borrar";
    $datos["nombre_corto"] = "producto a borrar";
    $datos["descripcion"] = "Descripción a borrar";
    $datos["PVP"] = "50";
    $datos["familia"] = "MP3";
    

    $url = DIR_SERV . "/producto/actualizar/".urlencode("YYYYYYYY");
    $respuesta = consumir_servicios_REST($url, "PUT", $datos); // En insertar y actualizar, poner el $datos como parámetro
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    
    if (isset($obj->mensaje_error)) {
        die("<p>".$obj->mensaje_error."</p></body></html>");
    }

    echo "<p>".$obj->mensaje."</p>";    
    */
    
    /* PARA BORRAR
    $url = DIR_SERV . "/producto/borrar/".urlencode("YYYYYYYY");
    $respuesta = consumir_servicios_REST($url, "DELETE"); // En insertar y actualizar, poner el $datos como parámetro
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    
    if (isset($obj->mensaje_error)) {
        die("<p>".$obj->mensaje_error."</p></body></html>");
    }

    echo "<p>".$obj->mensaje."</p>";
    */

    // Vamos a mostrar los productos en una tabla
    $url = DIR_SERV . "/productos";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    
    if (isset($obj->mensaje_error)) {
        die("<p>".$obj->mensaje_error."</p></body></html>");
    }

    echo "<h1>Nombre ejemplo: ".$obj->productos[0]->nombre_corto."</h1>";
    echo "<p>El número de tuplas obtenidas ha sido: ".count($obj->productos)."</p>";

    echo "<table>";
    echo "<tr><th>Cod</th><th>Nombre Corto</th></tr>";
    foreach ($obj->productos as $tupla) {
        echo "<tr>";
        echo "<td>".$tupla->cod."</td>";
        echo "<td>".$tupla->nombre_corto."</td>";
        echo "</tr>";
    }

    // Con un for lo mismo sería
    for ($i=0; $i < count($obj->productos); $i++) {
        echo "<tr>";
        echo "<td>".$obj->productos[$i]->cod."</td>";
        echo "<td>".$obj->productos[$i]->nombre_corto."</td>";
        echo "</tr>";
    }

    echo "</table>";

    $url = DIR_SERV . "/producto/KSTDTG332GBR";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj) {
        die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
    }
    
    if (isset($obj->mensaje_error)) {
        die("<p>".$obj->mensaje_error."</p></body></html>");
    }

    echo "<h1>Nombre corto de KSTDTG332GBR es: ".$obj->producto[0]->nombre_corto."</h1>";

    ?>
</body>
</html>