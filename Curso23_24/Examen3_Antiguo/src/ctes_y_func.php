<?php

    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_videoclub2");
    define("MINUTOS_INACT", 5);

    function error_page($title, $body){
        return "<!DOCTYPE html>
                <html lang='es'>
                <head>                    
                    <title>$title</title>
                </head>
                <body>
                    $body
                </body>
                </html>";
    }

    function comprobarRepetido($conexion, $tabla, $columna, $valor){
        try {
            
            $consulta = "select * from $tabla where $columna='$valor'";
            $resultado = mysqli_query($conexion, $consulta);
    
            $respuesta = mysqli_num_rows($resultado) > 0; // Si el número de columnas obtenidas es mayor de 0 es que está repetido
            mysqli_free_result($resultado);
    
        } catch (Exception $e) {   
            mysqli_close($conexion);
            $respuesta = error_page("Registro usuario", "<h1>Registro usuario</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>");
        }
        return $respuesta;
    }

    function LetraNIF ($dni) { // Aquí tenemos que pasar el dni entero sin la letra
        $valor=(int)($dni / 23);
        $valor *= 23;
        $valor= $dni - $valor;
        $letras= "TRWAGMYFPDXBNJZSQVHLCKEO";
        $letraNif= substr($letras, $valor, 1);
        return $letraNif;
       }

?>