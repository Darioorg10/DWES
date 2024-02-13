<?php 
    // Vamos a obtener los horarios del profesor
    $url = DIR_SERV . "/obtenerHorario/".$datos_usuario_log->id_usuario;
    // $datos["api_session"] = $_SESSION["api_session"]; Esto lo tenemos ya de seguridad
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj2 = json_decode($respuesta); // COMO ARRIBA TENEMOS YA $obj, 
    if (!$obj2) {
        session_destroy();
        die(error_page("Examen SW 22_23", "<h1>Librería</h1><p>Error consumiendo el servicio : $url</p>"));
    }

    if (isset($obj2->error)) {
        session_destroy();
        die(error_page("Examen SW 22_23", "<h1>Librería</h1><p>Error consumiendo el servicio : $url</p>"));
    }

    if (isset($obj2->no_auth)) {
        session_unset();
        $_SESSION["seguridad"] = "No estás autorizado";
        header("Location:index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 2 23_24 SW</title>
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

        .centrado{
            text-align: center;
        }

        table{
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            text-align: center;
        }

        td, tr, th{
            border: 1px solid black;
            padding: 0.5rem;
        }

        th{
            background-color: #CCC;
        }
        
    </style>
</head>
<body>
    <h1>Librería</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log->usuario; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>

    <?php 
        echo "<h3 class='centrado'>Horario del profesor: <i>".$datos_usuario_log->nombre."</i></h3>";

        // Vamos a guardar en cada día y hora el grupo
        foreach ($obj2->horario as $tupla) {
            if (isset($horario[$tupla->dia][$tupla->hora])) { // Si ya hay un grupo ahí, los concatenamos
                $horario[$tupla->dia][$tupla->hora] .= "/".$tupla->nombre; // Guardamos el nombre del grupo en el día y hora
            } else {
                $horario[$tupla->dia][$tupla->hora] = $tupla->nombre;
            }
        }

        $dias[] = ""; // Esto sería el [0]
        $dias[] = "Lunes";
        $dias[] = "Martes";
        $dias[] = "Miércoles";
        $dias[] = "Jueves";
        $dias[] = "Viernes";

        $horas[1] = "8:15-9:15";
        $horas[] = "9:15-10:15";
        $horas[] = "10:15-11:15";
        $horas[] = "11:15-11:45";
        $horas[] = "11:45-12:45";
        $horas[] = "12:45-13:45";
        $horas[] = "13:45-14:45";                    

        echo "<table>";
        echo "<tr>";
        // Mostramos los días arriba
        for ($i=0; $i <= 5; $i++) {
            echo "<th>".$dias[$i]."</th>";
        }
        echo "</tr>";

        for ($hora=1; $hora < 7; $hora++) {
            echo "<tr>";
            echo "<th>".$horas[$hora]."</th>"; // Mostramos las horas en la primera columna
            // Si estamos en el recreo
            if ($hora == 4) {
                echo "<td colspan='5'>RECREO</td>";
            } else {
                for ($dia=1; $dia <= 5; $dia++) { // En cada hora de cada día
                    if (isset($horario[$dia][$hora])) { // Si existe horario en el día y hora por el que voy
                        echo "<td>".$horario[$dia][$hora]."</td>";
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