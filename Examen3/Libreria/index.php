<?php

    include_once "src/const_y_func.php";

    session_name("examen3_22_23");
    session_start();    

    if (isset($_SESSION["usuario"])) {
        // Si estoy logueado        
        // Seguridad
        include_once "src/seguridad.php";

        if (isset($_SESSION["seguridad"])) {
            echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        }
            
        // Nos conectamos con la base de datos para comprobar que tipo somos
        try {
            $conexion = mysqli_connect(NOMBRE_HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido establecerse la conexión a la base de batos: " . $e->getMessage() . "</p>"));
        }

        // Hacemos la búsqueda
        try {
            $consulta = "select * from usuarios";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen3-22-23", "<h1>Librería</h1><p>No ha podido realizarse la consulta a la base de batos: " . $e->getMessage() . "</p>"));
        }

        $tupla = mysqli_fetch_assoc($resultado);

        // Sacamos el tipo
        if ($tupla["tipo"] == "normal") { // Si es normal            
            header("Location:vistas/vista_normal.php");
        } else {
            header("Location:admin/gest_libros.php");
        }                         

        

    } else {
        // Si no, hay que mostrar el login
        // Login
        require "vistas/vista_login.php";        

    }    

    

?>