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
function login($lector, $clave){
    // Primero nos conectamos con la bd
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where lector=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$lector, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: ".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    // Si devuelve algo la consulta significa que hay algún usuario con ese usuario y clave
    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC); // Solo nos devuelve una tupla (con el lector y la clave)
        // Como queremos guardar los datos en una sesión, la creamos
        session_name("exa-sw-22-23");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuario"]["lector"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
        $respuesta["api_session"] = session_id(); // Guardamos el token de esta sesión
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la base de datos";
    }


    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


// b)
function logueado($lector, $clave){
    // Primero nos conectamos con la bd
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where lector=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$lector, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: ".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    // Si devuelve algo la consulta significa que hay algún usuario con ese usuario y clave
    if ($sentencia->rowCount()>0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC); // Solo nos devuelve una tupla (con el lector y la clave)
    } else {
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la base de datos";
    }


    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


// d)
function obtenerLibros(){
    // Primero nos conectamos con la bd
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from libros";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $respuesta["error"] = "Error: ".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    // Obtenemos los libros de la base de datos
    // En este caso si nos va a devolver más de una tupla (vamos a obtener todos los libros, eso es más de una fila)    
    $respuesta["libros"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;

}

// e)
function insertarLibro($datos){
    // Primero nos conectamos con la bd
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "insert into libros (referencia, titulo, autor, descripcion, precio) values (?,?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos); // Ya pasamos los datos en un array, no hay que meterlo en corchetes
    } catch (PDOException $e) {
        $respuesta["error"]="Error:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    $respuesta["mensaje"] = "Libro insertado correctamente en la base de datos";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// f)
function actualizarPortada($datos){
    // Primero nos conectamos con la bd
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }
    
    try {
        $consulta = "update libros set portada=? where referencia=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos); // Ya pasamos los datos en un array, no hay que meterlo en corchetes
    } catch (PDOException $e) {
        $respuesta["error"]="Error:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    $respuesta["mensaje"] = "Portada cambiada correctamente en la base de datos";

    $sentencia = null;
    $conexion = null;
    return $respuesta;

}

// g)
function repetido($tabla, $columna, $valor){
    // Primero nos conectamos con la bd
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }
    
    try {
        $consulta = "select $columna from $tabla where $columna = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]); // Tenemos que pasarlo como array
    } catch (PDOException $e) {
        $respuesta["error"]="Error:".$e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    $respuesta["repetido"] = $sentencia->rowCount()>0; // Nos devuelve true o false

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}


?>