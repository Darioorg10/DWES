<?php 

    session_name("Examen2_23_24");
    session_start();
    require "src/func_ctes.php";



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2</title>
    <style>
        .centrado{
            text-align: center;
        }

        table{
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
        }

        table, th, td{
            border: 1px solid black;
        }

        th{
            background-color: #CCC;
        }

    </style>
</head>
<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los profesores</h2>
    <?php 
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die("<p>No ha podido establecerse la conexión con la base de datos: ".$e->getMessage()."</p></body></html>");
        }

        try {
            $consulta = "select * from usuarios";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            session_destroy();
            die("<p>No ha podido hacerse la consulta: ".$e->getMessage()."</p></body></html>");
        }

        if (mysqli_num_rows($resultado) > 0) 
        {
            ?>
            <form action="index.php" method="post">
                <p>
                    <label for="profesor">Horario del profesor:</label>
                    <select name="profesor" id="profesor">
                        <?php 
                            while ($tupla = mysqli_fetch_assoc($resultado)) {
                                if (isset($_POST["profesor"]) && $_POST["profesor"]) {
                                    echo "<option selected value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</option>";
                                    $nombre_usuario = $tupla["nombre"];
                                } else {
                                    echo "<option selected value='".$tupla["id_usuario"]."'>".$tupla["nombre"]."</option>";
                                }                                
                            }
                        ?>
                    </select>
                    <button type="submit" name="btnVerHorario">Ver Horario</button>
                </p>
            </form>
        <?php

            if (isset($_POST["profesor"])) {
                echo "<h2>Horario del profesor ".$nombre_usuario."</h2>";

                $id_usuario = $_POST["profesor"];

                try {
                    $consulta = "select grupos.nombre,horario_lectivo.dia, horario_lectivo.hora from horario_lectivo, grupos where grupos.id_grupo=horario_lectivo.grupo and usuario=".$id_usuario."";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    mysqli_close($conexion);
                    session_destroy();
                    die("<p>No ha podido hacerse la consulta: ".$e->getMessage()."</p></body></html>");
                }

                $dias[1] = "Lunes";
                $dias[] = "Martes";
                $dias[] = "Miércoles";
                $dias[] = "Jueves";
                $dias[] = "Viernes";

                $horas[1] = "8:15 - 9:15";
                $horas[] = "9:15 - 10:15";
                $horas[] = "10:15 - 11:15";
                $horas[] = "11:15 - 11:45";
                $horas[] = "11:45 - 12:45";
                $horas[] = "12:45 - 13:45";
                $horas[] = "13:45 - 14:45";

                echo "<table class='centrado'>";
                echo "<tr>";
                for ($i=0; $i < 5; $i++) {
                    echo "<th>".$dias[$i]."</th>";
                }
                echo "</tr>";
                for ($hora=1; $hora < 7; $hora++) {
                    echo "<tr>";
                    echo "<th>".$horas["hora"]."</th>";
                    if ($hora == 4) {
                        echo "<td colspan='5'>RECREO</td>";
                    } else {
                        for ($dia=1; $dia < 5; $dia++) {
                            echo "<td><form action=''></form></td>";
                        }
                    }                    
                    echo "</tr>";
                }
                echo "</table>";

            }

        }
        else
        {
            echo "<p>No hay profesores registrados en la BD</p>";
        }
        ?>
</body>
</html>