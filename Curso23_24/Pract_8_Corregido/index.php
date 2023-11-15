<?php
require "src/ctes_funciones.php";

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

if (isset($_POST["btnContInsertar"])) {
    $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 50;
    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 30;
    $error_psw = $_POST["psw"] == "" || strlen($_POST["psw"]) > 15;
    $error_dni = $_POST["dni"] == "" || strlen($_POST["dni"]) > 10 || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    $error_imagen = $_FILES["archivo"]["size"] > 500*1024;
    
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

    if(isset($_POST["btnNuevoUsuario"]))
    {
        //Formulario para insertar nuevo usuario
        echo "<h2>Agregar Nuevo Usuario</h2>";
        ?>
        <form action="index.php" method="post" enctype="multipart/form-data">
                <p>
                    <label for="nombre">Nombre:</label><br/>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre...">
                    <?php 
                        if (isset($_POST["btnContInsertar"])) {
                            if ($_POST["nombre"] == "") {
                                echo "<span class='error'>*Campo obligatorio*</span>";
                            } else {
                                echo "<span class='error'>*Máx 50 carácteres*</span>";
                            }
                        }
                    ?>
                </p>
                <p>
                    <label for="usuario">Usuario:</label><br/>
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario...">
                    <?php 
                        if (isset($_POST["btnContInsertar"])) {
                            if ($_POST["usuario"] == "") {
                                echo "<span class='error'>*Campo obligatorio*</span>";
                            } else {
                                echo "<span class='error'>*Máx 30 carácteres*</span>";
                            }
                        }
                    ?>                    
                </p>
                <p>
                    <label for="psw">Contraseña:</label><br/>
                    <input type="password" name="psw" id="psw" placeholder="Contraseña...">
                    <?php 
                        if (isset($_POST["btnContInsertar"])) {
                            if ($_POST["psw"] == "") {
                                echo "<span class='error'>*Campo obligatorio*</span>";
                            } else {
                                echo "<span class='error'>*Máx 15 carácteres*</span>";
                            }
                        }
                    ?>
                </p>
                <p>
                    <label for="dni">DNI:</label><br/>
                    <input type="text" name="dni" id="dni" placeholder="DNI: 11223344Z">
                    <?php 
                        if (isset($_POST["btnContInsertar"])) {
                            if ($_POST["dni"] == "") {
                                echo "<span class='error'>*Campo obligatorio*</span>";
                            } else if(strlen($_POST["dni"]) > 10){
                                echo "<span class='error'>*Máx 10 carácteres*</span>";
                            } else if(!dni_bien_escrito($_POST["dni"])){
                                echo "<span class='error'>*No has escrito un dni válido*</span>";
                            } else {
                                echo "<span class='error'>*La letra del dni no es correcta*</span>";
                            }
                        }
                    ?>
                </p>
                <p>
                    <label for="sexo">Sexo:</label><br/>
                    <input type="radio" name="sexo" id="hombre" value="hombre"><label for="hombre">Hombre</label></input><br/>
                    <input type="radio" name="sexo" id="mujer" value="mujer"><label for="mujer">Mujer</label></input><br/>
                </p>
                <p>
                    <label for="archivo">Incluir mi foto </label><input type="file" name="archivo" id="archivo" accept="image/*">
                    <?php
                        if (isset($_POST["btnContInsertar"])) {
                            if ($_FILES["archivo"]["size"] > 500*1024) {
                                echo "<span class='error'>*El tamaño máximo es de 500KB*</span>";
                            } else {
                                // El tipo de la foto
                            }
                        }                        
                    ?>
                </p>

                <button type="submit" name="btnContInsertar">Guardar Cambios</button>
                <button type="submit" name="btnAtras">Atrás</button>
</form>
        <?php
    }

    require "vistas/vista_tabla_principal.php";
    
    ?>
    
</body>
</html>