<?php

    include_once "../src/const_y_func.php";

    if (isset($_POST["btnSalir"])) {              
        header("Location:../index.php");
        exit;
    }

    if (isset($_POST["btnAgregar"])) {
        try {
            $conexion = mysqli_connect(NOMBRE_HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido establecerse la conexión a la base de batos: " . $e->getMessage() . "</p>"));
        }

        $error_referencia = $_POST["referencia"] == "" || comprobarRepetido($conexion, "libros", "referencia", $_POST["referencia"]) || !is_numeric($_POST["referencia"]);
        $error_titulo = $_POST["titulo"] == "";
        $error_autor = $_POST["autor"] == "";
        $error_descripcion = $_POST["descripcion"] == "";
        $error_precio = $_POST["descripcion"] == "";

        $error_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio;

        if (!$error_form) {
            // Intentamos la inserción
            try {
                $consulta = "insert into `libros`(`referencia`, `titulo`, `autor`, `descripcion`, `precio`) VALUES ('".$_POST["referencia"]."',".$_POST["titulo"].",'".$_POST["autor"]."','".$_POST["descripcion"]."','".$_POST["precio"]."')";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {                
                die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido realizarse la consulta a la base de batos: " . $e->getMessage() . "</p>"));
            }
        }


    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión libros</title>
    <style>
        .enlace{
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        img{
            width: 100px;
            height: auto;
        }

        table{
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        th{
            background-color: #CCC;
        }

        table, td, th{
            border: 1px solid black;            
        }

        .error{
            color: red;
        }


    </style>
</head>
<body>
    <h1>Librería</h1>
    <form action="gest_libros.php" method="post">
        <p>Bienvenido 
            <strong>
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
                mysqli_free_result($resultado);
                
                ?>
            </strong>
        -     
        <button type="submit" class="enlace" name="btnSalir">Salir</button></p>
    </form>

    <h2>Listado de los libros</h2>

    <?php

        // Hacemos el select para sacar los datos
        try {
            $consulta = "select * from libros";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido realizarse la consulta a la base de batos: " . $e->getMessage() . "</p>"));
        }
        
        echo "<table>";
        echo "<tr>";
        echo "<th>Ref</th><th>Título</th><th>Acción</th>";
        echo "</tr>";
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>".$tupla["referencia"]."</td>";
            echo "<td>".$tupla["titulo"]."</td>";
            echo "<td><button class='enlace'>Borrar</button> - <button class='enlace'>Editar</button></td>";            
            echo "</tr>";            
        }
        echo "</table>";
    ?>

    <h2>Agregar un nuevo libro</h2>

    <form action="gest_libros.php" method="post">
        <p>
            <label for="referencia">Referencia:</label>
            <input type="text" name="referencia" id="referencia" value="<?php if(isset($_POST["btnAgregar"]) && $error_form) echo $_POST["referencia"];?>">
            <?php 
                if (isset($_POST["btnAgregar"]) && $error_referencia) {
                    if ($_POST["referencia"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else if(comprobarRepetido($conexion, "libros", "referencia", $_POST["referencia"])){
                        echo "<span class='error'>*El código de referencia está repetido*</span>";
                    } else {
                        echo "<span class='error'>*No has puesto un número*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="titulo">Titulo:</label>
            <input type="text" name="titulo" id="titulo" value="<?php if(isset($_POST["btnAgregar"]) && $error_form) echo $_POST["titulo"];?>">
            <?php 
                if (isset($_POST["btnAgregar"]) && $error_titulo) {
                    if ($_POST["titulo"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="autor">Autor:</label>
            <input type="text" name="autor" id="autor" value="<?php if(isset($_POST["btnAgregar"]) && $error_form) echo $_POST["autor"];?>">
            <?php 
                if (isset($_POST["btnAgregar"]) && $error_autor) {
                    if ($_POST["autor"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="descripcion">Descripcion:</label>
            <textarea name="descripcion" id="descripcion"><?php if(isset($_POST["btnAgregar"]) && $error_form) echo $_POST["autor"];?></textarea>
            <?php 
                if (isset($_POST["btnAgregar"]) && $error_descripcion) {
                    if ($_POST["descripcion"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="precio">Precio:</label>
            <input type="text" name="precio" id="precio" value="<?php if(isset($_POST["btnAgregar"]) && $error_form) echo $_POST["autor"];?>">
            <?php 
                if (isset($_POST["btnAgregar"]) && $error_precio) {
                    if ($_POST["precio"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>
        <button type="submit" name="btnAgregar">Agregar</button>
    </form>    

</body>
</html>