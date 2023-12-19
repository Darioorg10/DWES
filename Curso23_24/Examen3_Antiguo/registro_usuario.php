<?php

include_once "src/ctes_y_func.php";

    // Control de errores
    if (isset($_POST["btnContinuar"])) {

        // Nos conectamos con la BD
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("Registro usuario", "<p>No se ha podido realizar la conexión con la base de datos: ".$e->getMessage()."</p>"));
        }        

        // Recogemos los datos de la BD
        try {
            $consulta = "select * from usuarios";
        } catch (Exception $e) {
            die(error_page("Registro usuario", "<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        }

        // Creamos los errores que puede haber al registrarse
        $error_usuario = $_POST["nombreUsuario"] == "" || comprobarRepetido($conexion, "usuarios", "usuario", $_POST["nombreUsuario"]);
        $error_clave = $_POST["clave"] == "";
        $error_claveRepetida = $_POST["claveRepetida"] == "" || $_POST["claveRepetida"] != $_POST["clave"];
        $error_dni = $_POST["dni"] == "" || !is_numeric(substr($_POST["dni"], 0, 8)) || LetraNIF(substr($_POST["dni"], 0, 8)) != substr($_POST["dni"], 8);
        $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || comprobarRepetido($conexion, "usuarios", "email", $_POST["email"]);
        $error_telefono = $_POST["telefono"] == "" || !is_numeric($_POST["telefono"]) || strlen($_POST["telefono"]) != 9;

        $error_form = $error_usuario || $error_clave || $error_claveRepetida || $error_dni || $error_email || $error_telefono;

        // Si no hay errores
        if (!$error_form) {
            // Registramos al usuario en la base de datos
            try {
                $consulta = "insert `usuarios`(`DNI`, `usuario`, `clave`, `telefono`, `email`) values ('".$_POST["dni"]."','".$_POST["nombreUsuario"]."','".md5($_POST["clave"])."','".$_POST["telefono"]."','".$_POST["email"]."')";
                mysqli_query($conexion, $consulta);
                $_SESSION["mensaje"] = "Usuario registrado con éxito en la base de datos";
            } catch (Exception $e) {
                die(error_page("Registro usuario", "<p>No se ha podido registrar al usuario: ".$e->getMessage()."</p>"));
            }
        }
    }

    if (isset($_POST["btnVolver"])) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro usuario</title>
    <style>
        .error{
            color: red;
        }

        .mensaje{
            color: blue;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <h2>Video Club</h2>
    <form action="registro_usuario.php" method="post">
        <label for="nombreUsuario">Nombre de usuario:</label>
        <input type="text" name="nombreUsuario" id="nombreUsuario" value="<?php if(isset($_POST["btnContinuar"]) && $_POST["nombreUsuario"] != "" && $error_form) echo $_POST["nombreUsuario"];?>">
        <?php 
            if (isset($_POST["btnContinuar"]) && $error_usuario) {
                if ($_POST["nombreUsuario"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else {
                    echo "<span class='error'>*El usuario está repetido*</span>";
                }
            }
        ?>
        <br/><br/>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave">
        <?php 
            if (isset($_POST["btnContinuar"]) && $error_clave) {
                if ($_POST["clave"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                }
            }
        ?>
        <br/><br/>
        <label for="claveRepetida">Repita la contraseña:</label>
        <input type="password" name="claveRepetida" id="claveRepetida">
        <?php 
            if (isset($_POST["btnContinuar"]) && $error_claveRepetida) {
                if ($_POST["claveRepetida"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else {
                    echo "<span class='error'>*La contraseña repetida no es igual*</span>";
                }
            }
        ?>
        <br/><br/>
        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" value="<?php if(isset($_POST["btnContinuar"]) && $_POST["dni"] != "" && $error_form) echo $_POST["dni"];?>">
        <?php 
            if (isset($_POST["btnContinuar"]) && $error_dni) {
                if ($_POST["dni"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else if(!is_numeric(substr($_POST["dni"], 0, 8))){
                    echo "<span class='error'>*El dni no es correcto*</span>";
                } else {
                    echo "<span class='error'>*La letra no pertenece al dni*</span>";
                }
            }
        ?>
        <br/><br/>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?php if(isset($_POST["btnContinuar"]) && $_POST["email"] != "" && $error_form) echo $_POST["email"];?>">
        <?php 
            if (isset($_POST["btnContinuar"]) && $error_email) {
                if ($_POST["email"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                    echo "<span class='error'>*El email no es sintácticamente correcto*</span>";
                } else {
                    echo "<span class='error'>*El email está repetido*</span>";
                }
            }
        ?>
        <br/><br/>
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" id="telefono" value="<?php if(isset($_POST["btnContinuar"]) && $_POST["telefono"] != "" && $error_form) echo $_POST["telefono"];?>">
        <?php 
            if (isset($_POST["btnContinuar"]) && $error_telefono) {
                if ($_POST["telefono"] == "") {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                } else if(!is_numeric($_POST["telefono"])){
                    echo "<span class='error'>*El teléfono no está compuesto por números*</span>";
                } else {
                    echo "<span class='error'>*El teléfono no tiene una longitud de 9 números*</span>";
                }
            }
        ?>
        <br/><br/>

        <button type="submit" name="btnVolver" id="btnVolver">Volver</button>
        <button type="submit" name="btnContinuar" id="btnContinuar">Continuar</button>
        <br/><br/>
    </form>

    <?php 
        if (isset($_SESSION["mensaje"])) {
            echo "<span class='mensaje'>".$_SESSION["mensaje"]."</span>";
        }
    ?>

</body>
</html>