<?php  // Control de errores

if(isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContInsertar"]))
{
    if (isset($_POST["btnContInsertar"])) {        

        $error_nombre = $_POST["nombre"] == "";
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";
        $error_email = $_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    
        $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;
        if (!$error_form) { // LO HACEMOS AQUÍ PORQUE LOS HEADER LOCATION SE TIENEN QUE HACER ANTES DE PONER CÓDIGO HTML

        }
        
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1ºCRUD</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <h1>Nuevo Usuario</h1>
    <form action="usuario_nuevo.php" method="post">
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["btnContInsertar"])) echo $_POST["nombre"];?>" maxlength="30">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_form) {
                    if ($_POST["nombre"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["btnContInsertar"])) echo $_POST["usuario"];?>" maxlength="20">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_form) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" maxlength="15"> <!-- Le damos solo 15 porque luego se le hace el md5 -->
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_form) {
                    if ($_POST["clave"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="email">Email: </label>
            <input type="text" name="email" id="email" value="<?php if(isset($_POST["btnContInsertar"])) echo $_POST["email"];?>" maxlength="50">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_form) {
                    if ($_POST["email"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnContInsertar">Continuar</button>
            <button type="submit" name="btnVolver">Volver</button>
        </p>
    </form>    
</body>
</html>
<?php 
}
else { // Si se intenta acceder a esta página sin haber accedido antes al index, o se da al botón volver
    header("Location: index.php");
    exit;
}
?>