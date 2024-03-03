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

// a)
function login($usuario, $clave)
{
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
        $respuesta["error"] = "No se ha podido realizar la consulta";
        $sentencia = null;
        $conexion = null;
    }

    // Si se encuentra un usuario
    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("exa4_pra_fun_y_ser");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
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

// b)
function logueado($usuario, $clave)
{
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
        $respuesta["error"] = "No se ha podido realizar la consulta";
        $sentencia = null;
        $conexion = null;
    }

    // Si se encuentra un usuario
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
function alumnos()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }


    try {
        $consulta = "select * from usuarios where tipo='alumno'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta";
        $sentencia = null;
        $conexion = null;
    }

    $respuesta["alumnos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// e)
function notasAlumno($cod_alu)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }


    try {
        $consulta = "select asignaturas.cod_asig, asignaturas.denominacion, notas.nota from asignaturas, notas where asignaturas.cod_asig = notas.cod_asig and cod_usu=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_alu]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta";
        $sentencia = null;
        $conexion = null;
    }

    $respuesta["notas"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// f)
function NotasNoEvalAlumno($cod_alu)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }


    try {
        $consulta = "select * from asignaturas where asignaturas.cod_asig not in (select asignaturas.cod_asig from asignaturas, notas where asignaturas.cod_asig = notas.cod_asig and cod_usu=?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_alu]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta";
        $sentencia = null;
        $conexion = null;
    }

    $respuesta["notas"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// g)
function quitarNota($cod_asig, $cod_alu){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }


    try {
        $consulta = "delete from notas where cod_asig=? and cod_usu=? ";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_asig, $cod_alu]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta";
        $sentencia = null;
        $conexion = null;
    }

    $respuesta["mensaje"] = "Asignatura descalificada con éxito";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// h)
function ponerNota($cod_asig, $cod_alu){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }


    try {
        $consulta = "insert into 'notas'('cod_asig', 'cod_usu', 'nota') values (?,?,0)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_asig, $cod_alu]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta";
        $sentencia = null;
        $conexion = null;
    }

    $respuesta["mensaje"] = "Asignatura descalificada con éxito";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// i)
function cambiarNota($nota, $cod_asig, $cod_alu){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }


    try {
        $consulta = "update notas set nota = ? where cod_asig=? and cod_usu=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$nota, $cod_asig, $cod_alu]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta";
        $sentencia = null;
        $conexion = null;
    }

    $respuesta["mensaje"] = "Asignatura descalificada con éxito";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


?>