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

function login($usuario, $clave){
    // Primero abrimos la conexión
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));              
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al hacer la consulta: ".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }    

    if ($sentencia->rowCount()>0) {        
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("funciones-examen-horario-sw-23-24");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"]; // Queremos guardar el usuario, la clave y el tipo
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

function logueado($usuario, $clave){
    // Primero abrimos la conexión
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al hacer la consulta: ".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }    

    // Solo queremos saber si el usuario con nuestra api_session está logueado
    if ($sentencia->rowCount()>0) {        
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la base de datos";
    }


    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// Función para obtener los nombres de todos los profesores
function obtenerNombres(){
    // Abrimos la conexión
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: ".$e->getMessage();
        $conexion = null;
        $sentencia = null;
        return $respuesta;
    }

    // En este caso hacemos un fetchAll porque nos va a devolver más de una tupla
    $respuesta["nombres"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = null;
    $sentencia = null;
    return $respuesta;


}

// Función para saber la id del profesor con el nombre
function obtenerIdProfesor($nombre){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where nombre=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$nombre]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: ".$e->getMessage();
        $conexion = null;
        $sentencia = null;
        return $respuesta;
    }

    // En este caso hacemos un fetchAll porque nos puede devolver más de una tupla
    $respuesta["usuarios"] = $sentencia->fetch(PDO::FETCH_ASSOC);

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

// Función para obtener el horario de un profesor con su id
function obtenerHorarioProfesor($id_profesor){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from horario_lectivo where usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_profesor]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: ".$e->getMessage();
        $conexion = null;
        $sentencia = null;
        return $respuesta;
    }

    // En este caso hacemos un fetchAll porque nos puede devolver más de una tupla
    $respuesta["horarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

?>
