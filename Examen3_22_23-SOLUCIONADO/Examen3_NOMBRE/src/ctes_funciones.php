<?php
    // SERVIDOR_BD,USUARIO_BD,CLAVE_BD y NOMBRE_BD son CTES
    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_exam2223");
    define("MINUTOS", 5);

    function error_page($title, $body) {
        return '<!DOCTYPE html>
        <html lang="en">
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

    function repetido($conexion, $tabla, $columna, $valor, $columna_clave=null, $valor_clave=null)
    {
        try {
            if (isset($columna_clave)) {
                $consulta = 'select * from ' .$tabla . ' where ' . $columna . '="' . $valor . '" AND ' . $columna_clave . '<>"' . $valor_clave . '"';
            } else {
                $consulta = 'select * from ' .$tabla . ' where ' . $columna . '="' . $valor . '"';
            }
            $resultado = mysqli_query($conexion, $consulta);
            $respuesta = mysqli_num_rows($resultado) > 0;
            mysqli_free_result($resultado);
        } catch (Exception $e) {
            mysqli_close($conexion);
            $respuesta = error_page('Práctica 1º CRUD', '<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: ' . $e->getMessage() . '</p>');
        }
        return $respuesta;
    }

    //Conexión con PDO
    // $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    
    // Conexión mysqli
    // $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
    // mysqli_set_charset($conexion,"utf-8");

    //Algunas funciones y metodos según conexion PDO ó mysqli
    // $ultim_id=$conexion->lastInsertId();

    // $ultim_id=mysqli_insert_id($conexion);
?>