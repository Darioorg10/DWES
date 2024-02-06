<?php
require "config_bd.php";

function conexion_pdo()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}


function conexion_mysqli()
{
  
    try
    {
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        mysqli_close($conexion);
    }
    catch(Exception $e)
    {
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function login($lector, $clave){
    try {
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where lector=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$lector, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    // Si devuelve algún resultado la consulta
    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("examen_sw_22-23");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuario"]["lector"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
        $respuesta["api_session"] = session_id();
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la base de datos";
    }
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function logueado($lector, $clave){
    try {
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where lector=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$lector, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    // Si devuelve algún resultado la consulta
    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("examen_sw_22-23");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuario"]["lector"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
        $respuesta["api_session"] = session_id();
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la base de datos";
    }
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtenerLibros(){
    try {
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from libros";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    // Aquí no hay que hacer el rowcount
    $respuesta["libros"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function insertar_libro($datos){
    try {
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "insert into libros (referencia, titulo, autor, descripcion, precio) values (?,?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }
    
    $respuesta["mensaje"] = "Libro insertado correctamente en la base de datos";
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function actualizar_portada($datos){
    try {
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "update libros set portada=? where referencia = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos); // Como datos es ya un array no hace falta pasárselo entre llaves
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }
    
    $respuesta["mensaje"] = "Portada cambiada correctamente en la base de datos";
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function repetido($tabla, $columna, $valor){
    try {
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select $columna from $tabla where $columna=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }
    
    $respuesta["repetido"] = $sentencia->rowCount()>0;
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

?>
