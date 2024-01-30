<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_foro2");
// define("NOMBRE_BD", "bd_tienda"); Para el login

// Para el login (este sería el c)
function login($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error"=>"Error: ".$e->getMessage());
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

// a)
function obtener_usuarios(){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {        
        return array("error"=>"No se ha podido conectar a la base de datos: ".$e->getMessage());
    }

    try{
        $consulta="select * from usuarios";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("error"=>"No se ha podido conectar a la base de datos: ".$e->getMessage());
    }

    $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// b)
function insertar_usuario($datos){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error"=>"No se ha podido conectar a la base de datos: ".$e->getMessage());
    }

    try{
        $consulta="insert into usuarios(nombre, usuario, clave, email) values (?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("error"=>"No se ha podido conectar a la base de datos: ".$e->getMessage());
    }

    $respuesta["ult_id"] = $conexion->lastInsertId();
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// d)
function actualizar_usuario($datos){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error"=>"No se ha podido conectar a la base de datos: ".$e->getMessage());
    }

    try{
        $consulta="update usuarios set nombre=?, usuario=?, clave=?, email=? where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("error"=>"No se ha podido conectar a la base de datos: ".$e->getMessage());
    }

    // Esto no lo pide el enunciado, pero lo hacemos por si no existe el usuario
    if ($sentencia->rowCount()>0) {
        $respuesta["mensaje"] = "El usuario con id: ".$datos[4]." se ha actualizado con éxito";
    } else {
        $respuesta["mensaje_error"] = "El usuario con id: ".$datos[4]." no se encuentra en la base de datos";
    }
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// e)
function borrar_usuario($id_usuario){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error"=>"No se ha podido conectar a la base de datos: ".$e->getMessage());
    }
    
    try{
        $consulta="delete from usuarios where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($id_usuario);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("error"=>"No se ha podido conectar a la base de datos: ".$e->getMessage());
    }
    
        // En los delete el resultado es el mismo si existe o no el usuario a borrar
        $respuesta["mensaje"] = "El usuario con id: $id_usuario se ha borrado con éxito";
    
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


?>