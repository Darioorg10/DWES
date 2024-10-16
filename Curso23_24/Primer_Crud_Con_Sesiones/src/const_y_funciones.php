<?php

function error_page($title, $body)
{
    return 
    '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>'.$title.'</title>
        </head>
        <body>
            '.$body.'
        </body>
        </html>';
}

function repetido($conexion, $tabla, $columna, $valor){
    try {
        
        $consulta = "select * from $tabla where $columna='$valor'";
        $resultado = mysqli_query($conexion, $consulta);

        $respuesta = mysqli_num_rows($resultado) > 0; // Si el número de columnas obtenidas es mayor de 0 es que está repetido
        mysqli_free_result($resultado);

    } catch (Exception $e) {   
        mysqli_close($conexion);
        $respuesta = error_page("Práctica 1ºCRUD", "<h1>Práctica 1ºCRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>");        
    }
    return $respuesta;
}
