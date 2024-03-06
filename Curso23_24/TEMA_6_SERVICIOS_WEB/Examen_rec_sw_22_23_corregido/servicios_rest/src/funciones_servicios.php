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

// a)
function login($usuario, $clave){
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
        $respuesta["error"]="No se ha podido realizar la consulta:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("exa_rec_sw_22_23_fun_ser");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $respuesta["api_session"] = session_id();
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la base de datos";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// b)
function logueado($usuario, $clave){
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
        $respuesta["error"]="No se ha podido realizar la consulta:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la base de datos";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// d)
function obtener_datos_usuario($id_usuario){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        $respuesta["error"]="No se ha podido realizar la consulta:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $respuesta["mensaje"] = "El usuario con $id_usuario no se encuentra registrado en la base de datos";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// e)
function obtener_usuarios_guardias_dia_hora($dia, $hora){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select usuarios.* from usuarios, horario_guardias where usuarios.id_usuario = horario_guardias.usuario and horario_guardias.dia=? and horario_guardias.hora=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora]);
    } catch (PDOException $e) {
        $respuesta["error"]="No se ha podido realizar la consulta:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


// f)
function esta_de_guardia_dia_hora($dia, $hora, $id_usuario){

    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select usuario from horario_guardias where dia=? and hora=? and usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia, $hora, $id_usuario]);
    } catch (PDOException $e) {
        $respuesta["error"]="No se ha podido realizar la consulta:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    $respuesta["de_guardia"] = $sentencia->rowCount()>0; // Devuelve un true o false

    $sentencia = null;
    $conexion = null;
    return $respuesta;

}


?>
