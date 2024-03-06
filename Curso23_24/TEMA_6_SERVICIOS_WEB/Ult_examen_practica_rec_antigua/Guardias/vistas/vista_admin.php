<?php 

    // Si se pulsa sobre un nombre
    if (isset($_POST["btnDetalles"])) {
        
        $url = DIR_SERV."/usuario/".$_POST["btnDetalles"];
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj2 = json_decode($respuesta);

        if (!$obj2) {
            session_destroy();
            die(error_page("Práctica examen final", "Ha habido un error consumiendo el servicio: ".$url));
        }

        if (isset($obj2->error)) {
            consumir_servicios_REST($url."/salir", "POST", $datos);
            session_destroy();
            die(error_page("Práctica examen final", "Ha habido un error consumiendo el servicio: ".$obj->error));
        }

        if (isset($obj2->no_auth)) {
            session_unset();
            $_SESSION["seguridad"] = "No tienes permisos para usar este servicio";
            header("Location:index.php");
            exit;
        }        

    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista admin</title>
    <style>

        .enlace{
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        table{
            border-collapse: collapse;
            width: 100%;            
            text-align: center;
        }

        tr, th, td{
            border: 1px solid black;
        }

        th{
            background-color: #CCC;
        }

    </style>
</head>
<body>
    <h1>Vista admin</h1>

    <form action="index.php" method="post">
        <p>Bienvenido <strong><?php echo $datos_usuario_log->usuario; ?></strong> - <button type="submit" class="enlace" name="btnSalir">Salir</button></p>
    </form>

    <?php

        // Guardamos los días y las horas en un array        
        $dias[1] = "Lunes";
        $dias[2] = "Martes";
        $dias[3] = "Miércoles";
        $dias[4] = "Jueves";
        $dias[5] = "Viernes";

        $horas[1] = "8:15 - 9:15";
        $horas[2] = "9:15 - 10:15";
        $horas[3] = "10:15 - 11:15";
        $horas[4] = "11:15 - 11:45";
        $horas[5] = "11:45 - 12:45";
        $horas[6] = "12:45 - 13:45";
        $horas[7] = "13:45 - 14:45";

        echo "<h3>Hoy es ".$dias[date("w")]."</h3>"; // Mostramos el día de hoy

        // Comenzamos la tabla
        echo "<table>";
        echo "<th>Hora</th><th>Profesor de guardia</th><th>Información del profesor con id:";
        if (isset($_POST["btnDetalles"])) {
            echo $_POST["btnDetalles"];
        }
        echo "</th>";
        
        // Ponemos en la primera columna las horas (en el rowspan como valor el count de los nombres que devuelva)
        for ($hora=1; $hora <= 7; $hora++) {
            echo "<tr><td>".$horas[$hora]."</td>";

            // Cogemos los profesores que hay de guardia en el día de hoy y cada hora
            $url = DIR_SERV."/usuariosGuardia/".date("w")."/".$hora;
            $respuesta = consumir_servicios_REST($url, "GET", $datos);
            $obj = json_decode($respuesta);

            if (!$obj) {
                session_destroy();                
            }

            if (isset($obj->error)) {
                consumir_servicios_REST($url."/salir", "POST", $datos);
                session_destroy();                
            }

            if (isset($obj->no_auth)) {
                session_unset();
                $_SESSION["seguridad"] = "No tienes permisos para usar este servicio";
                header("Location:index.php");
                exit;
            }

            echo "<td>";
            echo "<ol>";
            foreach ($obj->usuarios as $tupla) {
                echo "<form action='index.php' method='post'>";
                echo "<li><button type='submit' class='enlace' name='btnDetalles' value='".$tupla->id_usuario."'>".$tupla->nombre."</button></li>";
                echo "</form>";
            }
            echo "</ol>";
            echo "</td>";            

            if (isset($_POST["btnDetalles"])) {
                if ($hora == 1) {
                    echo "<td><strong>Nombre: </strong>".$obj2->usuario->nombre."<br/>";
                    echo "<strong>Usuario: </strong>".$obj2->usuario->usuario."<br/>";
                    echo "<strong>Contraseña: </strong>".$obj2->usuario->clave."<br/>";
                    if (isset($obj2->usuario->email)) {
                        echo "<strong>Email: </strong>".$obj2->usuario->email."<br/>";
                    } else {
                        echo "<strong>Email: </strong>Email no disponible<br/>";
                    }
                    echo "</td>";
                }                
            }
            

            echo "</tr>";

        }

        echo "</table>";

    ?>

</body>
</html>