<?php

    include_once "../src/const_y_func.php";

    if (isset($_POST["btnSalir"])) {
        header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista normal</title>
    <style>
        .enlace{
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Librería</h1>    
    <form action="index.php" method="post">
    <p>Bienvenido <strong></strong> 
    - 
    <?php

        // Nos conectamos con la base de datos si no está abierta
        if(!isset($conexion)){
            try {
                $conexion = mysqli_connect(NOMBRE_HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                session_destroy();
                die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido establecerse la conexión a la base de batos: " . $e->getMessage() . "</p>"));
            }
        }        

        // Hacemos el select para sacar el nombre
        try {
            $consulta = "select * from usuarios";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido realizarse la consulta a la base de batos: " . $e->getMessage() . "</p>"));
        }
        
        $tupla = mysqli_fetch_assoc($resultado);
        echo $tupla["lector"];
        
    ?>
    <button type="submit" class="enlace" name="btnSalir">Salir</button></p>
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