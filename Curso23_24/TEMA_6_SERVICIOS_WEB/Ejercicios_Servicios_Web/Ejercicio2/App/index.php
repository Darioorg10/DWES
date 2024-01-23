<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2 - CRUD</title>
</head>
<body>
    <?php
        define("DIR_SERV", "http://localhost/Proyectos/DWES/Curso23_24/TEMA_6_SERVICIOS_WEB/Ejercicios_Servicios_Web/Ejercicio2/servicios_rest/");
    
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

    ?>
</body>
</html>