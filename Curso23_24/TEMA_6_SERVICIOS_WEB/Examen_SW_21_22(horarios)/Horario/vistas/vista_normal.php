<?php 

    $url = DIR_SERV."/obtenerHorario/".$datos_usuario_log->id_usuario;
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Examen SW 21_22", "Ha habido un error al consumir el servicio: $url"));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Examen SW 21_22", "Ha habido un error al consumir el servicio: ".$obj->error));
    }

    if (isset($obj->no_auth)) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión en la api ha caducado";
        header("Location:index.php");
        exit;
    }    

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen SW 21_22</title>
</head>
<style>

    .enlace{
        border: none;
        background: none;
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
    <h1>Vista normal</h1>

    <form action="index.php" method="post">
        <p>Bienvenido <strong><?php echo $datos_usuario_log->usuario ?></strong> - <button class="enlace" type="submit" name="btnSalir">Salir</button></p>
    </form>    

    <h2>Su horario</h2>
    <h3 class="centrado">Horario del profesor: <i><?php echo $datos_usuario_log->nombre ?></i></h3>

    <?php 

        $dias[] = "";
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

        // Vamos a recorrer el horario y guardar las horas en las que haya algo
        foreach ($obj->horario as $tupla) {
            if (isset($horario[$tupla->dia][$tupla->hora])) { // Si ya hay algo en esa hora concatenamos
                $horario[$tupla->dia][$tupla->hora] .= "/".$tupla->nombre;                
            } else {
                $horario[$tupla->dia][$tupla->hora] = $tupla->nombre;
            }
        }
    
        echo "<table>";
        
        echo "<tr>";
        // Mostramos la cabecera de los días
        for ($i=0; $i < count($dias); $i++) { 
            echo "<th>".$dias[$i]."</th>";
        }
        echo "</tr>";

        // Mostramos las horas
        for ($hora=1; $hora < count($horas); $hora++) { 
            echo "<tr>";
            echo "<th>".$horas[$hora]."</th>";

            if ($hora == 4) { // Si estamos en el recreo
                echo "<td colspan='5'>RECREO</td>";
            } else {

                // Estamos dentro de cada hora, pues vamos a ver si en el día
                // por el que pasemos hay algo
                for ($dia=1; $dia <= 5; $dia++) { 
                    if (isset($horario[$dia][$hora])) {
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