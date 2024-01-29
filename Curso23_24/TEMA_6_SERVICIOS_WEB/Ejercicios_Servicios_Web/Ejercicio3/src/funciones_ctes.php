<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_tienda");

function login($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]); // Como dijimos tiene que devolver un array con el usuario y la clave
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta=array("mensaje_error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC); // AQUÍ PONEMOS FETCH PORQUE BUSCAMOS UN RESULTADO CONCRETO
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra en la base de datos";
    }
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

?>