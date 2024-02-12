<?php 

    if (isset($_POST["btnInsertar"])) {
        $error_referencia = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]);
        $error_titulo = $_POST["titulo"] == "";
        $error_autor = $_POST["autor"] == "";
        $error_descripcion = $_POST["descripcion"] == "";
        $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]);

        $error_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio;

        if (!$error_form) {
            // Comprobamos que la referencia no esté repetida
            $url = DIR_SERV."/repetido";
            $datos["tabla"] = "libros";
            $datos["columna"] = "referencia";
            $datos["valor"] = $_POST["referencia"];
            $datos["api_session"] = $_SESSION["api_session"];
            $respuesta = consumir_servicios_REST($url, "GET", $datos);
            $obj = json_decode($respuesta);

            if (!$obj) {
                session_destroy();
                die(error_page("Librería", "Error consumiendo el servicio: $url"));
            }

            if (isset($obj->error)) {
                session_destroy();
                die(error_page("Librería", "Error consumiendo el servicio: ".$obj->error.""));
            }

            if ($obj->repetido) { // Si está repetido
                $error_referencia = true;
            } else { // Si no está repetido, insertamos
                $url = DIR_SERV."/crear_libro";
                $datos["api_session"] = $_SESSION["api_session"];
                $datos["referencia"] = $_POST["referencia"];
                $datos["titulo"] = $_POST["titulo"];
                $datos["autor"] = $_POST["autor"];
                $datos["descripcion"] = $_POST["descripcion"];
                $datos["precio"] = $_POST["precio"];                
                $respuesta = consumir_servicios_REST($url, "POST", $datos);
                $obj = json_decode($respuesta);

                if (!$obj) {
                    session_destroy();
                    die(error_page("Librería", "Error consumiendo el servicio: $url"));
                }

                if (isset($obj->error)) {
                    session_destroy();
                    die(error_page("Librería", "Error consumiendo el servicio: ".$obj->error.""));
                }

                if (isset($obj->mensaje)) {
                    $_SESSION["accion"] = $obj->mensaje;
                    header("Location:gest_libros.php");
                    exit;
                }

            }        
        }

    }

    if (isset($_POST["btnBorrar"])) {
        $_SESSION["accion"] = "El libro con referencia ".$_POST["btnBorrar"]." ha sido borrado con éxito ";
        header("Location:gest_libros.php");
        exit;
    }

    if (isset($_POST["btnEditar"])) {
        $_SESSION["accion"] = "El libro con referencia ".$_POST["btnEditar"]." ha sido editado con éxito ";
        header("Location:gest_libros.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista admin</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }
        
        #libros{
            display: flex;
            justify-content: space-between;
            flex-flow: row wrap;
            width: 90%;
            margin: 0 auto;
        }

        #libros div{
            flex: 0 33%;
            text-align: center;
        }

        img{
            width: 100%;
            height: auto;
        }

        .error{
            color: red;
        }    

        .mensaje{
            font-size: 16px;
            color: blue;
        }

        table{
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            text-align: center;
        }

        td, tr, th{
            border: 1px solid black;            
        }

        th{
            background-color: #CCC;
        }

    </style>
</head>
<body>
    <h1>Librería - Vista admin</h1>
    <form action="../index.php" method="post">
        <p>Bienvenido
            <strong><?php echo $datos_usuario_log->lector; ?></strong> -<button class='enlace' name="btnSalir">salir</button>
        </p>
    </form>
    <?php

        if (isset($_SESSION["accion"])) {
            echo "<p class='mensaje'>".$_SESSION["accion"]."</p>";
            unset($_SESSION["accion"]);
        }

        echo "<h2>Listado de los libros</h2>";

        // Aquí mostramos los libros en una tabla
        $url = DIR_SERV."/obtener_libros";
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Librería", "Error consumiendo el servicio: $obj"));
        }

        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Librería", "Error consumiendo el servicio: ".$obj->error.""));
        }

        echo "<form action='gest_libros.php' method='post'>";
        echo "<table>";
        echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
        foreach ($obj->libros as $tupla) {
            echo "<tr><td>".$tupla->referencia."</td><td><button class='enlace' name='btnDetalle' value='".$tupla->referencia."'>".$tupla->titulo."</button></td><td><button class='enlace' name='btnBorrar' value='".$tupla->referencia."'>Borrar</button> - <button class='enlace' name='btnEditar' value='".$tupla->referencia."'>Editar</button></td></tr>";
        }                
        echo "</table>";
        echo "</form>"
        
    ?>

        <h2>Insertar un nuevo libro</h2>
        <form action="gest_libros.php" method="post">
        <p>
            <label for="referencia">Referencia:</label>
            <input type="text" name="referencia" id="referencia" value="<?php if(isset($_POST["referencia"])) echo $_POST["referencia"]; ?>">
            <?php 
                if (isset($_POST["btnInsertar"]) && $error_referencia) {
                    if ($_POST["referencia"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else if(!is_numeric($_POST["referencia"])){
                        echo "<span class='error'>*La referencia tiene que ser un número*</span>";
                    } else {
                        echo "<span class='error'>*La referencia está repetida*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" value="<?php if(isset($_POST["titulo"])) echo $_POST["titulo"]; ?>">
            <?php 
                if (isset($_POST["btnInsertar"]) && $error_titulo) {
                    if ($_POST["titulo"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="autor">Autor:</label>
            <input type="text" name="autor" id="autor" value="<?php if(isset($_POST["autor"])) echo $_POST["autor"]; ?>">
            <?php 
                if (isset($_POST["btnInsertar"]) && $error_autor) {
                    if ($_POST["autor"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion"><?php if(isset($_POST["descripcion"])) echo $_POST["descripcion"]; ?></textarea>
            <?php 
                if (isset($_POST["btnInsertar"]) && $error_descripcion) {
                    if ($_POST["descripcion"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="precio">Precio:</label>
            <input type="text" name="precio" id="precio" value="<?php if(isset($_POST["precio"])) echo $_POST["precio"]; ?>">
            <?php 
                if (isset($_POST["btnInsertar"]) && $error_precio) {
                    if ($_POST["precio"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*El precio tiene que ser un número*</span>";
                    }
                }
            ?>
        </p>
        <button type="submit" name="btnInsertar">Insertar</button>
    </form>

</body>
</html>