
<?php

include_once "src/const_y_func.php";

if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;
    if ($error_clave) {
        $error_usuario = true;
    }

    if (!$error_form) {
        // Nos conectamos con la base de datos
        try {
            $conexion = mysqli_connect(NOMBRE_HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido establecerse la conexión a la base de batos: " . $e->getMessage() . "</p>"));
        }

        // Hacemos la búsqueda para ver si hay coincidencias
        try {
            $consulta = "select * from usuarios";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido realizarse la consulta a la base de batos: " . $e->getMessage() . "</p>"));
        }

        $tupla = mysqli_fetch_assoc($resultado);

        // Si hay coincidencias
        if ($tupla["lector"] == $_POST["usuario"] && $tupla["clave"] == md5($_POST["clave"])) {
            $_SESSION["usuario"] = $_POST["usuario"];
            $_SESSION["clave"] = md5($_POST["clave"]);
            $_SESSION["ultima_accion"] = time();            
            mysqli_close($conexion);
            header("Location:index.php");
            exit;
        } else {
            $error_usuario = true;            
        }        
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .error{
            color: red;
        }

        .mensaje{
            color: blue;
            font-size: 20px;
        }
        
        img{
            width: 200px;
            height: auto;
        }

    </style>
</head>

<body>
    <h1>Librería</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <!-- Hay que mantener valores y controlar los errores -->
            <input type="text" name="usuario" id="usuario" maxlength="15" value="<?php if(isset($_POST["btnEntrar"]) && $error_usuario) echo $_POST["usuario"];?>">
            <?php 
                if (isset($_POST["btnEntrar"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*El usuario/contraseña no está registrado en la BD*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" maxlength="50">
            <?php 
                if (isset($_POST["btnEntrar"]) && $error_clave) {
                    if ($_POST["clave"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*El usuario/contraseña no está registrado en la BD*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEntrar">Entrar</button>
        </p>
    </form>

    <h2>Listado de los libros</h2>

    <?php 

        // Nos conectamos con la base de datos
        try {
            $conexion = mysqli_connect(NOMBRE_HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido establecerse la conexión a la base de batos: " . $e->getMessage() . "</p>"));
        }

        // Hacemos el select para sacar los datos
        try {
            $consulta = "select * from libros";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido realizarse la consulta a la base de batos: " . $e->getMessage() . "</p>"));
        }
        
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td><img src='Images/".$tupla["portada"]."'/></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><span>".$tupla["titulo"]."</span> - <span>".$tupla["precio"]."</span></td>";
            echo "</tr>";            
        }        

        if (isset($_SESSION["seguridad"])) {
            echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        }
    ?>
</body>
</html>