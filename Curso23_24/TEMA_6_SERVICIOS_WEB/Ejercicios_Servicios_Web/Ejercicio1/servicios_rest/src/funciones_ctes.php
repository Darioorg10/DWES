<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_tienda");

// a)
function obtener_productos()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();        
        return $respuesta;
        // Esas dos se pueden hacer en una línea: return array("mensaje_error"=>"No se ha podido conectar a la base de datos: ".e->getMessage());
    }

    try{
        $consulta="select * from producto";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();
        return $respuesta;
    }

    $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// b)
function obtener_producto($codigo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();        
        return $respuesta;
    }

    try{
        $consulta="select * from producto where cod=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$codigo]);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount()>0) {
        $respuesta["producto"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El producto con código $codigo no se encuentra en la BD";
    }
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// c)
function insertar_producto($datos){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();        
        return $respuesta;
    }

    try{
        $consulta="insert into producto(cod, nombre, nombre_corto, descripcion, PVP, familia) values (?,?,?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"] = "El producto se ha insertado correctamente";
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// d
function actualizar_producto($datos){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();        
        return $respuesta;
    }

    try{
        $consulta="update producto set nombre=?, nombre_corto=?, descripcion=?, PVP=?, familia=? where cod=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"] = "El producto se ha actualizado correctamente";
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// e)
function borrar_producto($codigo){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();        
        return $respuesta;
    }

    try{
        $consulta="delete from producto where cod=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$codigo]); // Al no ser un array, tenemos que pasarselo entre llaves
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();
        return $respuesta;
    }

    $respuesta["mensaje"] = "El producto se ha borrado correctamente";
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// f)
function obtener_familias()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();        
        return $respuesta;
        // Esas dos se pueden hacer en una línea: return array("mensaje_error"=>"No se ha podido conectar a la base de datos: ".e->getMessage());
    }

    try{
        $consulta="select * from familia";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();
        return $respuesta;
    }

    $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// g)
function repetido($tabla, $columna, $valor){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();        
        return $respuesta;
        // Esas dos se pueden hacer en una línea: return array("mensaje_error"=>"No se ha podido conectar a la base de datos: ".e->getMessage());
    }

    try{
        $consulta="select * from $tabla where $columna = ?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor]);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();
        return $respuesta;
    }

    $respuesta["repetido"] = ($sentencia->rowCount())>0; // Nos devuelve true si está repetido y false si no
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// h)
function repetido_editar($tabla, $columna, $valor, $columna_id, $valor_id){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();        
        return $respuesta;
        // Esas dos se pueden hacer en una línea: return array("mensaje_error"=>"No se ha podido conectar a la base de datos: ".e->getMessage());
    }

    try{
        $consulta="select * from $tabla where $columna = ? AND $columna_id <> ?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor, $valor_id]);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();
        return $respuesta;
    }

    $respuesta["repetido"] = ($sentencia->rowCount())>0; // Nos devuelve true si está repetido y false si no
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

?>