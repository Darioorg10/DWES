<?php

// Constantes base de datos

define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_foro2");

function error_page($title, $body){
    $page='<!DOCTYPE html>
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
    return $page;
}

function repetido($conexion, $tabla, $columna, $valor, $columna_clave=null, $valor_clave=null){
    try {
        if (isset($columna_clave)) {
            $consulta = "select * from $tabla where $columna='$valor' AND ".$columna_clave."<>'".$valor_clave."'";
        } else {
            $consulta = "select * from $tabla where $columna='$valor'";
        }
        
        $resultado = mysqli_query($conexion, $consulta);
        $respuesta = mysqli_num_rows($resultado) > 0; // Si el número de columnas obtenidas es mayor de 0 es que está repetido
        mysqli_free_result($resultado);
    } catch (Exception $e) {   
        mysqli_close($conexion);
        $respuesta = error_page("Práctica 1ºCRUD", "<h1>Práctica 1ºCRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>");
    }
    return $respuesta;
}
?>