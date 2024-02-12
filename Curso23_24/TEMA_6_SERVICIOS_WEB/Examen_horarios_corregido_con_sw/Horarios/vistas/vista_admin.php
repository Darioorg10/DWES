<?php

    // Vamos a obtener los profesores no admin
    $url = DIR_SERV . "/obtenerProfesoresNoAdmin";
    $datos["api_session"] = $_SESSION["api_session"];
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die(error_page("Examen SW 22_23", "<h1>Librería</h1><p>Error consumiendo el servicio : $url</p>"));
    }

    if (isset($obj->no_auth)) {
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
        <h1>Horario de los profesores</h1>
        <form action="index.php" method='post'>
            <p>
                Horario de los profesores no admin:
                <select name="selProfesNormales" id="selProfesNormales">
                    <?php

                        foreach ($obj->profesor as $tupla) {
                            if (isset($_POST["selProfesNormales"]) && $_POST["selProfesNormales"] == $tupla->id_usuario) {
                                $profesorSel = $tupla;
                                echo "<option value='".$tupla->id_usuario."' selected>".$tupla->nombre."</option>"; // Le pasamos como value la id
                            } else {
                                echo "<option value='".$tupla->id_usuario."'>".$tupla->nombre."</option>";
                            }
                        }
                                    
                    ?>
                </select>
                <button name="btnVerHorario">Ver horario</button>
            </p>

            <?php 
                if (isset($_POST["btnVerHorario"])) {
                    echo "<h3 class='centrado'>Horario del profesor: <i>".$profesorSel->nombre."</i></h3>";

                    $dias = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes");
                    $horas = array("8:15-9:15", "9:15-10:15", "10:15-11:15", "11:15-11:45", "11:45-12:45", "12:45-13:45", "13:45-14:45");

                    echo "<table>";
                    // Vamos a poner la cabecera
                    echo "<tr>";
                    echo "<th></th>";
                    for ($i=0; $i < count($dias); $i++) { 
                        echo "<th>".$dias[$i]."</th>";
                    }
                    echo "</tr>";

                    for ($i=0; $i < count($horas); $i++) {
                        echo "<tr><th>".$horas[$i]."</th></tr>";
                    }

                    echo "</table>";

                }
            ?>            
        </form>        
    </div>
</body>

</html>