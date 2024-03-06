<?php 

    // Cogemos los datos de la tabla
    $url = DIR_SERV."/horario/".$datos_usuario_log->id_usuario;
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Práctica examen final", "Ha habido un error consumiendo el servicio: ".$url));
    }

    if (isset($obj->error)) {
        consumir_servicios_REST($url."/salir", "POST", $datos);
        session_destroy();
        die(error_page("Práctica examen final", "Ha habido un error consumiendo el servicio: ".$obj->error));
    }

    if (isset($obj->no_auth)) {
        session_unset();
        $_SESSION["seguridad"] = "No tienes permisos para usar este servicio";
        header("Location:index.php");
        exit;
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

        table{
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
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
    <h1>Vista normal</h1>

    <form action="index.php" method="post">
        <p>Bienvenido <strong><?php echo $datos_usuario_log->usuario; ?></strong> - <button type="submit" class="enlace" name="btnSalir">Salir</button></p>
    </form>

    <h2>Su horario</h2>
    <h3 style="text-align: center;">Horario del profesor: <i><?php echo $datos_usuario_log->nombre; ?></i></h3>

    <?php 

        // Guardamos los días y las horas en un array
        $dias[0] = "";
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

        // Esto nos sirve para imprimir los nombres de los grupos
        foreach ($obj->horario as $tupla) {
            if (isset($horario[$tupla->dia][$tupla->hora])) {
                $horario[$tupla->dia][$tupla->hora] .= "/".$tupla->nombre; // Si ya hay un grupo ese día y hora lo concatenamos
            } else {
                $horario[$tupla->dia][$tupla->hora] = $tupla->nombre;
            }            
        }

        // Empezamos la tabla
        echo "<table>";
        // Hacemos la cabecera con los días
        echo "<tr>";
        for ($dia=0; $dia <= 5; $dia++) {
            echo "<th>".$dias[$dia]."</th>";
        }
        echo "</tr>";        
        
        for ($hora=1; $hora <= 7; $hora++) {

            echo "<tr>";
            echo "<th>".$horas[$hora]."</th>"; // Imprimimos la primera columna de horas
            if ($hora == 4) { // En el recreo
                echo "<td colspan='5'>RECREO</td>";
            } else {
                for ($dia=1; $dia <= 5; $dia++) {
                    if (isset($horario[$dia][$hora])) { // Si hay algo en el día y hora en el que estamos lo ponemos
                        echo "<td>".$horario[$dia][$hora]."</td>"; // Ponemos el nombre del grupo del día y hora en el que estamos
                    } else {
                        echo "<td></td>";
                    }         
                }
            }                                                
            
            echo "</tr>";
        }


        echo "</table>";

    ?>

</body>
</html>