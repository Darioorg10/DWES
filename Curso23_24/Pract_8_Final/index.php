<?php
require "src/ctes_funciones.php";

if(isset($_POST["btnContNuevo"]))
{
    $error_nombre=$_POST["nombre"]=="" || strlen($_POST["nombre"])>50;
    $error_usuario=$_POST["usuario"]=="" || strlen($_POST["usuario"])>50;
    if(!$error_usuario)
    {
        try{
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");
        }
        catch(Exception $e)
        {
            die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
        }

        $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"]);
        
        if(is_string($error_usuario))
        {
            mysqli_close($conexion);
            die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No se ha podido realizar la consulta: ".$error_usuario."</p>"));
        }
    }
    $error_clave=$_POST["clave"]=="" || strlen($_POST["clave"])>15;
    $dni_may=strtoupper($_POST["dni"]);
    $error_dni=$_POST["dni"]=="" || !dni_bien_escrito($dni_may) || !dni_valido($dni_may);
    if(!$error_dni)
    {
        if(!isset($conexion))
        {
            try{
                $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
                mysqli_set_charset($conexion,"utf8");
            }
            catch(Exception $e)
            {
                die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
            }
        }
        $error_dni=repetido($conexion,"usuarios","dni",$dni_may);
        
        if(is_string($error_dni))
        {
            mysqli_close($conexion);
            die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No ha podido realizarse la consulta: ".$error_dni."</p>"));
        }
    }
    $error_sexo=!isset($_POST["sexo"]); 
    $error_foto=$_FILES["foto"]["name"]!="" && ($_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || !tiene_extension($_FILES["foto"]["name"]) || $_FILES["foto"]["size"]>500 *1024);

    $error_form=$error_nombre||$error_usuario|| $error_clave || $error_dni || $error_sexo || $error_foto;
    if(!$error_form)
    {
        //Inserto base de datos
        try{
            $consulta="insert into usuarios (nombre, usuario, clave, dni,sexo) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POSt["clave"])."','".$dni_may."','".$_POST["sexo"]."')";
            mysqli_query($conexion,$consulta);
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        }

        if($_FILES["foto"]["name"]!="")
        {
            $last_id=mysqli_insert_id($conexion);
            $array_nombre=explode(".",$_FILES["foto"]["name"]);
            $nombre_foto="img_".$last_id.".".end($array_nombre);

            @$var=move_uploaded_file($_FILES["foto"]["tmp_name"],"Img/".$nombre_foto);
            if($var)
            {
                try{
                    $consulta="update usuarios set foto='".$nombre_foto."' where id_usuario='".$last_id."'";
                    mysqli_query($conexion,$consulta);
                }
                catch(Exception $e)
                {
                    unlink("Img/".$nombre_foto);
                    mysqli_close($conexion);
                    die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
                }
            }    

        }

        mysqli_close($conexion);
        header("Location:index.php");
        exit;
    }
}

if(isset($_POST["btnContBorrar"]))
{
    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
    }

    try{
        $consulta="delete from usuarios where id_usuario='".$_POST["btnContBorrar"]."'";
        mysqli_query($conexion, $consulta);

    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No ha podido realizarse la consulta: ".$e->getMessage()."</p>"));
    }

    if($_POST["nombre_foto"]!="no_imagen.jpg")
        unlink("Img/".$_POST["nombre_foto"]);

    mysqli_close($conexion);
    header("Location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 8</title>
    <style>
        table,td,th{border:1px solid black;}
        table{border-collapse:collapse;text-align:center;width:90%;margin:0 auto}
        th{background-color:#CCC}
        table img{width:50px;}
        .enlace{border:none;background:none;cursor:pointer;color:blue;text-decoration:underline}
        .error{color:red}
        .foto_detalle{width:20%}
    </style>
</head>
<body>
    <h1>Práctica 8</h1>
    <?php
    if(isset($_POST["btnDetalle"]))
    {
        require "vistas/vista_detalle.php"; 
    }

    if(isset($_POST["btnBorrar"]))
    {
        require "vistas/vista_conf_borrar.php";
    }

    if(isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContNuevo"]))
    {
        require "vistas/vista_nuevo_usuario.php";
    }

    require "vistas/vista_tabla_principal.php";
    
    ?>
    
</body>
</html>