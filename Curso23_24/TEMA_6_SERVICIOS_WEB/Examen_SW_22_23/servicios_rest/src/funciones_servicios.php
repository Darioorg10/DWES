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
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }    

    try {
        $consulta = "select * from usuarios where lector=? and clave=?";
        $sentencia = $conexion->prepare($consulta);        
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido realizar la consulta: ".$e->getMessage();
    }

    // Si no se encuentra ningún usuario con esos datos registrado
    if ($sentencia->rowCount() < 0) {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la base de datos";
    } else {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC); // Al ser solo una tupla (aunque varios datos), hacemos solo fetch
    }

    return $respuesta;

}

// b)
function logueado(){

}

// c)
function salir(){

}

// d)
function obtenerLibros(){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }

    try {
        $consulta = "select * from libros";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $respuesta["error"]="Imposible realizar la consulta:".$e->getMessage();
    }

    // Si hemos obtenido resultados
    if ($sentencia->rowCount() > 0) {
        $respuesta["libros"] = $sentencia->fetchAll(PDO::FETCH_ASSOC); // Es un fetchAll porque devuelve más de una tupla (más de una línea)
    }

    return $respuesta;

}

// e)
function crearLibro(){

}

// f)
function actualizarPortada(){

}

// g)
function repetido(){

}

?>
