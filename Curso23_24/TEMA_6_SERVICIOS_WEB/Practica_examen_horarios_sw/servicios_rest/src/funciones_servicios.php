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
    // Primero hacemos la conexión
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }

    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: ".$e->getMessage();
        $conexion = null;
        $sentencia = null;
        return $respuesta;
    }

    if ($sentencia->rowCount()>0) {
        $respuesta["usuarios"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("servicios_practica_examen_horarios_sw");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuarios"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuarios"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuarios"]["tipo"];
        $respuesta["api_session"] = session_id();
    } else {
        $respuesta["mensaje"] = "No hay usuarios con esos datos en la base de datos";
    }

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function logueado($usuario, $clave){
    // Primero hacemos la conexión
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));                
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }

    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: ".$e->getMessage();
        $conexion = null;
        $sentencia = null;
        return $respuesta;
    }

    if ($sentencia->rowCount()>0) {
        $respuesta["usuarios"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "No hay usuarios con esos datos en la base de datos"; // Te han baneado
    }

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function obtenerProfesoresNormales(){
    // Primero hacemos la conexión
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }

    try {
        $consulta = "select * from usuarios where tipo = 'normal'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: ".$e->getMessage();
        $conexion = null;
        $sentencia = null;
        return $respuesta;
    }

    $respuesta["profesores"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function obtenerHorarioPorId($id_usuario){
    // Primero hacemos la conexión
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }

    try {        
        // Lo mismo pero con un join
        // SELECT horario_lectivo.*, grupos.nombre FROM horario_lectivo join grupos on grupos.id_grupo = horario_lectivo.grupo WHERE horario_lectivo.usuario = 44;
        $consulta = "SELECT horario_lectivo.*,  grupos.nombre FROM horario_lectivo, grupos WHERE horario_lectivo.grupo = grupos.id_grupo and horario_lectivo.usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: ".$e->getMessage();
        $conexion = null;
        $sentencia = null;
        return $respuesta;
    }

    $respuesta["horario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

?>
