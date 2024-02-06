<?php 

    if (isset($_POST["btnLogin"])) {
        
        // Control de errores        
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";

        $error_form = $error_usuario || $error_clave;

        // Si ningún campo está vacío vamos a intentar loguearnos
        if (!$error_form) {
            $url = DIR_SERV."/login";
            $clave_encriptada = md5($_POST["clave"]);
            $datos["lector"] = $_POST["usuario"]; // El parámetro que pide es lector
            $datos["clave"] = $clave_encriptada;
            $respuesta = consumir_servicios_REST($url, "POST", $datos);
            $obj = json_decode($respuesta);

            if (!$obj) {
                echo "<p>Error consumiendo el servicio: $url</p>";
            }

        }

    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen SW 22_23</title>
    <style>
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
    </style>
</head>
<body>
    <h1>Librería</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["btnLogin"])) echo $_POST["usuario"]; ?>">
            <?php 
                if (isset($_POST["btnLogin"]) && $error_usuario) {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave">
            <?php 
                if (isset($_POST["btnLogin"]) && $error_clave) {
                    echo "<span class='error'>*Campo obligatorio*</span>";
                }
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">Login</button>
        </p>
    </form>
    <h2>Listado de los libros</h2>
    <?php 
        $url = DIR_SERV."/obtenerLibros";
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die("<p>Error consumiendo el servicio: $url</p></body></html>");
        }

        if (isset($obj->error)) {
            session_destroy();
            die("<p>".$obj->error."</p></body></html>");
        }

        echo "<div id='libros'>";
        foreach ($obj->libros as $tupla) {
            echo "<div>";
            echo "<img src='images/".$tupla->portada."' alt='portada' title='portada'>".$tupla->titulo." - ".$tupla->precio." €";
            echo "</div>";
        }
        echo "</div>";

    ?>
</body>
</html>