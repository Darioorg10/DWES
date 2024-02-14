<?php 

    $url = DIR_SERV."/obtener_usuarios";
    $datos["api_session"] = $_SESSION["api_session"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Horario", "<p>Error en: $url</p>"));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Horario", "<p>Error: " . $obj->error."</p>"));
    }

    if (isset($obj->no_auth)) {
        session_unset();
        die(error_page("Horario", "<p>Error: " . $obj->no_auth."</p>"));
    }

    if (isset($_POST["btnVerHorario"])) {
        $url = DIR_SERV."/obtenerHorarioPorId";
        $datos["api_session"] = $_SESSION["api_session"];
        $datos["id_usuario"] = $_POST["profesor"];
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj2 = json_decode($respuesta);

        if (!$obj2) {
            session_destroy();
            die(error_page("Horario", "<p>Error en: $url</p>"));
        }

        if (isset($obj2->error)) {
            session_destroy();
            die(error_page("Horario", "<p>Error: " . $obj2->error."</p>"));
        }

        if (isset($obj2->no_auth)) {
            session_unset();
            die(error_page("Horario", "<p>Error: " . $obj2->no_auth."</p>"));
        }
        
        foreach ($obj2->horarios as $tupla) {
            if (isset($horario[$tupla->dia][$tupla->hora])) { // Si hay más de un grupo ese día, los concatenamos
                $horario[$tupla->dia][$tupla->hora] .= "/".$tupla->nombre; // Ponemos el nombre que corresponda en el día y hora correspondientes
            } else {
                $horario[$tupla->dia][$tupla->hora] = $tupla->nombre;
            }
            
        }        

    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios vista admin</title>
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
        text-align: center;
        border-collapse: collapse;
    }

    tr, th, td{
        border: 1px solid black;
    }

    th{
        background-color: #CCC;
    }

</style>
<body>
    <h1>Horario de profesores - Vista admin</h1>
    <form action="index.php" method="post">
        <p>Bienvenido <strong><?php echo $datos_usuario_log->usuario; ?></strong> - <button class="enlace" type="submit" name="btnSalir">salir</button></p>
    </form>
    <h2>Horario de los profesores</h2>
    <p>
        <form action="index.php" method="post">
            <label for="profesor">Horario del profesor: </label>
            <select name="profesor">
                <?php 
                    foreach ($obj->usuarios as $tupla) {
                        if (isset($_POST["profesor"]) && $tupla->id_usuario == $_POST["profesor"]) {
                            $nombre_profesor = $tupla->nombre;
                            echo "<option selected value='".$tupla->id_usuario."'>".$tupla->nombre."</option>";
                        } else {
                            echo "<option value='".$tupla->id_usuario."'>".$tupla->nombre."</option>";
                        }                        
                    }
                ?>
            </select>
            <button name="btnVerHorario">Ver horario</button>
        </form>        
    </p>

    <?php 

        if (isset($_POST["btnVerHorario"])) {
            
            echo "<h3 class='centrado'>Horario del profesor: <em>".$nombre_profesor."</em></h3>";

            $dias[0] = "";
            $dias[] = "Lunes";
            $dias[] = "Martes";
            $dias[] = "Miércoles";
            $dias[] = "Jueves";
            $dias[] = "Viernes";

            $horas[1] = "8:15-9:15";
            $horas[] = "9-15:10-15";
            $horas[] = "10-15:11-15";
            $horas[] = "11-15:11-45";
            $horas[] = "11-45:12-45";
            $horas[] = "12-45:13-45";
            $horas[] = "13-45:14-45";


            // Vamos a imprimir la cabecera con los días
            echo "<table>";
            echo "<tr>";
            for ($dia=0; $dia <= 5; $dia++) {
                echo "<th>".$dias[$dia]."</th>";
            }
            echo "</tr>";

            // Ahora mostramos las horas
            for ($hora=1; $hora <= 6; $hora++) {                
                echo "<tr>";
                if ($hora == 4) {
                    echo "<th>".$horas[$hora]."</th>";
                    echo "<td colspan='5'>RECREO</td>";
                } else {
                    echo "<th>".$horas[$hora]."</th>";
                    for ($dia=1; $dia <= 5; $dia++) { // Estamos recorriendo cada hora de cada día
                        if (isset($horario[$dia][$hora])) { // Si hay algo en este día y hora (lo metimos arriba), ponemos el nombre del grupo
                            echo "<td>".$horario[$dia][$hora]."</td>";
                        } else {
                            echo "<td></td>";
                        }
                    }
                }
                
                echo "</tr>";
            }

            echo "</table";


        }

    ?>

</body>
</html>