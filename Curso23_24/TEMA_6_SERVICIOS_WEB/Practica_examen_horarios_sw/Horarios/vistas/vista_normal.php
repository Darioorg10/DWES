<?php 
    // Vamos a obtener el horario del profesor por id
    $url = DIR_SERV."/obtenerHorarioPorId";    
    $datos["id_usuario"] = $datos_usuario_log->id_usuario;
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj2 = json_decode($respuesta);

    if (!$obj2) {
        session_destroy();
        die(error_page("Horarios", "<p>Error en: ".$url."</p>"));
    }

    if (isset($obj2->error)) {
        session_destroy();
        die(error_page("Horarios", "<p>Error: ".$obj2->error."</p>"));
    }

    if (isset($obj2->no_auth)) {
        session_unset();
        die(error_page("Horarios", "<p>Error: ".$obj2->no_auth."</p>"));
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
</head>
<style>

    .enlace{
        background: none;
        border: none;
        color: blue;
        text-decoration: underline;
        cursor: pointer;
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

    tr, th, td{
        border: 1px solid black;
    }

    th{
        background-color: #CCC;
    }

</style>
<body>
    <h1>Vista normal profesores</h1>
        <form action="index.php" method="post">
            <p>Bienvenido <strong><?php echo $datos_usuario_log->usuario ?></strong> - <button type="submit" class='enlace' name="btnSalir">salir</button></p>
        </form>    
        <?php 

            echo "<h3 class='centrado'>Horario del profesor: <em>".$datos_usuario_log->nombre."</em></h3>";

            // Guardamos en cada día y hora el/los grupo/s correspondiente/s
            foreach ($obj2->horario as $tupla) {      
                if (isset($horario[$tupla->dia][$tupla->hora])) { // Para saber si ya hay uno ahí, lo hacemos con el isset
                    $horario[$tupla->dia][$tupla->hora] .= "/".$tupla->nombre; // Si hay varios grupos los concatenamos
                } else {
                    $horario[$tupla->dia][$tupla->hora] = $tupla->nombre; // En la posición del día y hora que toque, guardamos el nombre del grupo
                }                
            }

            $dias[] = "";
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
            // Los días en la cabecera
            echo "<tr>";
            for ($i=0; $i <= 5; $i++) {
                echo "<th>".$dias[$i]."</th>";
            }
            echo "</tr>";

            // Ahora las horas
            for ($hora=1; $hora < 7; $hora++) {
                echo "<tr>";
                echo "<th>".$horas[$hora]."</th>"; // Por cada fila vamos mostrando las horas, y rellenando luego con los datos

                // Si estamos en el recreo
                if ($hora == 4) {
                    echo "<td colspan='5'>RECREO</td>";
                } else { // Mostramos las diferentes horas
                    for ($dia=1; $dia < 5; $dia++) { // Aquí estamos haciendo un doble for, en el que estamos poniendo en cada hora de cada día, el grupo correspondiente
                        if (isset($horario[$dia][$hora])) { // Si existe algo en la hora por la que voy, la muestro
                            echo "<td>".$horario[$dia][$hora]."</td>";
                        } else {
                            echo "<td></td>"; // Si no hay nada lo dejamos vacío
                        }
                    }
                }   
                echo "</tr>";
            }

            echo "</table>";

        ?>
</body>
</html>