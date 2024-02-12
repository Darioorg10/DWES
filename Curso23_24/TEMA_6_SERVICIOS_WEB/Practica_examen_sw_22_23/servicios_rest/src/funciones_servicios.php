<?php
require "config_bd.php";

function conexion_pdo()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
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

function login($usuario, $clave){

    // Primero hacemos la conexión
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }

    try {
        $consulta = "select * from usuarios where lector=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"]="No se ha podido realizar la consulta: ".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }    

    // Si existen coincidencias
    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("login_practica_examen_sw_22_23");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuario"]["lector"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
        $respuesta["api_session"] = session_id();
    } else {
        $respuesta["mensaje"] = "No se encuentra registrado en la base de datos";
    }
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;

}

function logueado($usuario, $clave){

    // Primero hacemos la conexión
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }

    try {
        $consulta = "select * from usuarios where lector=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"]="No se ha podido realizar la consulta: ".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }    

    // Si existen coincidencias
    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "No se encuentra registrado en la base de datos"; // Te han "baneado"
    }
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;

}

function obtener_libros(){

    // Primero hacemos la conexión
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }

    try {
        $consulta = "select * from libros";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $respuesta["error"]="No se ha podido realizar la consulta: ".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }    

    $respuesta["libros"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;

}

function crear_libro($referencia, $titulo, $autor, $descripcion, $precio){

    // Primero hacemos la conexión
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }

    try {
        $consulta = "insert into libros(referencia, titulo, autor, descripcion, precio) values(?, ?, ?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$referencia, $titulo, $autor, $descripcion, $precio]);
    } catch (PDOException $e) {
        $respuesta["error"]="No se ha podido realizar la consulta: ".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }    

    $respuesta["mensaje"] = "Libro insertado correctamente en la base de datos";
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;

}


function repetido($tabla, $columna, $valor){

    // Primero hacemos la conexión
    try{
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar: ".$e->getMessage();
    }

    try {
        $consulta = "select $columna from $tabla where $columna=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);
    } catch (PDOException $e) {
        $respuesta["error"]="No se ha podido realizar la consulta: ".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }    

    $respuesta["repetido"] = $sentencia->rowCount()>0; // Devuelve true o false si está repetido o no
    
    $sentencia = null;
    $conexion = null;
    return $respuesta;

}

?>
