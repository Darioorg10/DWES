<?php 

    require "src/const_y_funciones.php";

    if (isset($_POST["btnContInsertar"])) {
        $error_nombre = $_POST["nombreInsertado"] == "" || strlen($_POST["nombreInsertado"]) > 30;
        $error_usuario = $_POST["usuarioInsertado"] == "" || strlen($_POST["usuarioInsertado"]) > 50;

        if (!$error_usuario) {
            try {
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {                
                die("<p>No has podido conectarte a la base de datos: ".$e->getMessage()." </p></body></html>");
            }

        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuarioInsertado"]);

        }

        $error_clave = $_POST["claveInsertada"] == "" || strlen($_POST["claveInsertada"]) > 15;
        $error_email = $_POST["emailInsertado"] == "" || strlen($_POST["emailInsertado"]) > 50;

        if (!$error_email) {
            try {
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {                
                die("<p>No has podido conectarte a la base de datos: ".$e->getMessage()." </p></body></html>");
            }

            $error_email = repetido($conexion, "usuarios", "email", $_POST["emailInsertado"]);
        }

        $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

        if (!$error_form) {
            // Hacemos la inserción
            try {
                $consulta = "insert into usuarios (nombre, usuario, clave, email) values ('".$_POST["nombreInsertado"]."','".$_POST["usuarioInsertado"]."','".md5($_POST["claveInsertada"])."','".$_POST["emailInsertado"]."')";
                $resultado = mysqli_query($conexion, $consulta);                
            } catch (Exception $e) {
                session_destroy();
                die("<p>No has podido hacer el select: ".$e->getMessage()." </p></body></html>");
            }            

            header("Location:index.php");

        }


    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario nuevo</title>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <h1>Nuevo usuario</h1>

    <form action="usuario_nuevo.php" method="post">
        <p><label for="nombreInsertado">Nombre:</label>
        <input type="text" name="nombreInsertado" id="nombreInsertado"/>
        <?php
            if (isset($_POST["btnContInsertar"]) && $error_nombre) {
                if ($_POST["nombreInsertado"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else {
                    echo "<span class='error'>*Máx. 30 carácteres*</span>";
                }
            }
        ?>
        </p>

        <p><label for="usuarioInsertado">Usuario:</label>
        <input type="text" name="usuarioInsertado" id="usuarioInsertado"/>
        <?php 
            if (isset($_POST["btnContInsertar"]) && $error_usuario) {
                if ($_POST["usuarioInsertado"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else if(strlen($_POST["usuarioInsertado"]) > 50){
                    echo "<span class='error'>*Máx. 50 carácteres*</span>";
                } else {
                    echo "<span class='error'>*Usuario repetido*</span>";
                }
            }
        ?>
        </p>

        <p><label for="claveInsertada">Clave:</label>
        <input type="text" name="claveInsertada" id="claveInsertada"/>
        <?php 
            if (isset($_POST["btnContInsertar"]) && $error_clave) {
                if ($_POST["claveInsertada"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else {
                    echo "<span class='error'>*Máx. 15 carácteres*</span>";
                }
            }
        ?>
        </p>

        <p><label for="emailInsertado">Email:</label>
        <input type="text" name="emailInsertado" id="emailInsertado"/>
        <?php 
            if (isset($_POST["btnContInsertar"]) && $error_email) {
                if ($_POST["emailInsertado"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else if(strlen($_POST["emailInsertado"]) > 50){
                    echo "<span class='error'>*Máx. 50 carácteres*</span>";
                } else {
                    echo "<span class='error'>*Email repetido*</span>";
                }
            }
        ?>
        </p>

        <p><button type="submit" name="btnContInsertar">Continuar</button><button type="submit" name="btnVolver">Volver</button></p>

    </form>    

</body>
</html>