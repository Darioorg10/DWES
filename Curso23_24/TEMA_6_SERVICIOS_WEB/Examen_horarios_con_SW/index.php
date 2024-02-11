<?php
    
    session_name("sesion-examen-horarios-sw-23-24");
    session_start();        

    require "src/funciones_ctes.php";

    // Si le damos al botón de login
    if (isset($_POST["btnLogin"])) {
        
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";

        $error_form = $error_usuario || $error_clave;

        // Si no hay error en el formulario intentamos iniciar sesión
        if (!$error_form) {
            $url = DIR_SERV."/login";
            $datos["usuario"] = $_POST["usuario"];
            $datos["clave"] = md5($_POST["clave"]);

            $respuesta = consumir_servicios_REST($url, "GET", $datos);
            $obj = json_decode($respuesta);            

            if (!$obj) {
                session_destroy();
                die(error_page("Examen horarios con sw", "Ha habido un error"));
            }

            if (isset($obj->error)) {
                session_destroy();
                die(error_page("Examen horarios con sw", "Ha habido un error: ".$obj->error));                
            }            
            
            if (isset($obj->mensaje)) { // Si mandábamos un mensaje es que el usuario no estaba en la bd
                $error_usuario = true;  // Ponemos esto para que nos ponga el mensaje de que el usuario o la contraseña no son correctos
            } else {
                // Ahora vamos a guardar las sesiones
                $_SESSION["usuario"] = $obj->usuario->usuario;
                $_SESSION["clave"] = $obj->usuario->clave;
                // El tipo lo vamos a guardar en seguridad
                $_SESSION["api_session"] = $obj->api_session;        
                $_SESSION["ult_accion"] = time(); // Guardamos la ultima acción para controlar el tiempo
            }

        }

    }

    // Si le damos al botón de salir
    if (isset($_POST["btnSalir"])) {
        $url = DIR_SERV."/salir";
        $datos["api_session"] = $_SESSION["api_session"];
        consumir_servicios_REST($url, "POST", $datos);
        session_destroy();                
        header("Location:index.php");
        exit;
    }

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen2 PHP</title>
        <style>
            .error{color: red}
            .mensaje{font-size: 16px; color: blue;}
            .centrado{text-align: center; font-weight: bold;}

            table{
                width: 80%;
                margin: 0 auto;
                border-collapse: collapse;
            }

            td, th, tr{
                border: 1px solid black;
            }

            th{
                background-color: #CCC;
            }

        </style>
    </head>
    <body>
        <h1>Examen2 PHP</h1>
        <h2>Horario de los Profesores</h2>

        <!-- Hacemos el formulario de login -->
        <form action="index.php" method="post">
            <p>
                <label for="usuario">Nombre de usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"]; ?>"/>
                <?php
                if (isset($_POST["btnLogin"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*Usuario y/o contraseña incorrectos*</span>";
                    }
                }                                                                                       
                    
                ?>
            </p>
            <p>
                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" id="clave"/>
                <?php 
                    if (isset($_POST["btnLogin"]) && $_POST["clave"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    }
                ?>
            </p>
            <p>
                <button type="submit" name="btnLogin">Iniciar sesión</button>
            </p>
        </form>
        <?php 
            if (isset($_SESSION["mensaje"])) {
                echo "<span class='mensaje'>".$_SESSION["mensaje"]."</span>";
                session_destroy();
            }

            if (isset($_SESSION["usuario"])) {
                require "src/seguridad.php";
                if ($datos_usuario_log->tipo == "admin") {
                    echo "<h1>Vista admin</h1>";                                       
                    if (isset($_SESSION["seguridad"])) {
                        echo "<span class='mensaje'>".$_SESSION["seguridad"]."</span>";
                        session_destroy();
                    }

                    // Mostramos todos los nombres en un select
                    $url = DIR_SERV."/obtenerNombres";
                    $respuesta = consumir_servicios_REST($url, "GET");
                    $obj = json_decode($respuesta);

                    if (!$obj) {
                        session_destroy();
                        die(error_page("Examen horarios con sw", "<p>Ha habido un error</p></body></html>"));
                    }
        
                    if (isset($obj->error)) {
                        session_destroy();
                        die(error_page("Examen horarios con sw", "<p>Ha habido un error: ".$obj->error."</p></body></html>"));
                    }                    

                    ?>

                    <h2>Horario de los profesores</h2>
                    <form action="index.php" method="post">
                    <p>Horario del profesor:                    
                        <select name="selNombres" id="selNombres">
                            <?php
                                foreach ($obj->nombres as $tupla) {
                                    if ($_POST["selNombres"] == $tupla->nombre) {
                                        echo "<option selected>".$tupla->nombre."</option>";
                                    } else {
                                        echo "<option>".$tupla->nombre."</option>";
                                    }                                    
                                }
                            ?>
                        </select>
                        <button name="btnVerHorario" id="btnVerHorario">Ver horario</button>
                    </form>                        
                    </p>

                    <?php
                    // Si le damos al botón de ver horario
                    if (isset($_POST["btnVerHorario"])) {
                        echo "<p class='centrado'>Horario del profesor: ".$_POST["selNombres"]."</p>";

                        // Vamos a sacar la id con el nombre
                        $url = DIR_SERV."/obtenerIdProfesor";
                        $datos["nombre"] = $_POST["selNombres"];
                        $respuesta = consumir_servicios_REST($url, "GET", $datos);
                        $obj = json_decode($respuesta);

                        if (!$obj) {
                            session_destroy();
                            die(error_page("Examen horarios con sw", "<p>Ha habido un error</p></body></html>"));
                        }
            
                        if (isset($obj->error)) {
                            session_destroy();
                            die(error_page("Examen horarios con sw", "<p>Ha habido un error: ".$obj->error."</p></body></html>"));
                        }

                        $id_profesor = $obj->usuarios->id_usuario;                        
                        
                        // Vamos a sacar el horario con la id
                        $url = DIR_SERV."/obtenerHorarioProfesor";
                        $datos["id_profesor"] = $id_profesor;
                        $respuesta = consumir_servicios_REST($url, "GET", $datos);
                        $obj = json_decode($respuesta);

                        if (!$obj) {
                            session_destroy();
                            die(error_page("Examen horarios con sw", "<p>Ha habido un error</p></body></html>"));
                        }
            
                        if (isset($obj->error)) {
                            session_destroy();
                            die(error_page("Examen horarios con sw", "<p>Ha habido un error: ".$obj->error."</p></body></html>"));
                        }                        

                        

                        echo "<table>";
                        echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
                        echo "<tr><th>8:15 - 9:15</th></tr>";
                        echo "<tr><th>9:15 - 10:15</th></tr>";
                        echo "<tr><th>10:15 - 11:15</th></tr>";
                        echo "<tr><th>11:15 - 11:45</th></tr>";
                        echo "<tr><th>11:45 - 12:45</th></tr>";
                        echo "<tr><th>12:45 - 13:45</th></tr>";
                        echo "<tr><th>13:45 - 14:45</th></tr>";
                        echo "</table>";

                    }



                    echo "<form action='index.php' method='post'><button name='btnSalir'>Salir</button></form>";
                } else {
                    echo "<h1>Vista normal</h1>";
                }
            }

            
        ?>
    </body>
</html>