<?php 
    require "src/ctes_y_funciones.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen DWES</title>
    <style>
        table{
            border-collapse: collapse;
        }

        table, td, th{
            border: 1px solid black;
        }

        th{
            background-color: #CCC;
        }

    </style>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <?php
        try {
            $conexion = mysqli_connect(NOMBRE_HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            
            die(error_page("Examen DWES", "<p>No ha podido realizarse la conexión con la base de datos: ".$e->getMessage()."</p>"));
        }

        // Sacamos los datos de los alumnos
        try {
            $consulta = "select * from  alumnos";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("EXAMEN DWES", "<p>No ha podido realizarse la consulta: ".$e->getMessage()."</p>"));
        }

        if (mysqli_num_rows($resultado) > 0) { // Si sacamos algún dato ponemos la segunda página del enunciado            

            // Mostramos los alumnos de los que podemos ver las notas
        ?>
            <form action='index.php' method='post'>
                <p>
                    <label for="alumno">Seleccione un alumno:</label>
                    <select name="alumno" id="alumno">
                        <?php 
                            while($datos_alumno = mysqli_fetch_assoc($resultado)){
                                if (isset($_POST["alumno"]) && $_POST["alumno"] == $datos_alumno["cod_alu"]) {
                                    echo "<option selected value='".$datos_alumno['cod_alu']."'>".$datos_alumno['nombre']."</option>";
                                    $nombre_alumno = $datos_alumno["nombre"];
                                } else {
                                    echo "<option value='".$datos_alumno['cod_alu']."'>".$datos_alumno['nombre']."</option>"; // Creamos una opción para cada uno con el nombre
                                }                                
                            }    
                        ?>
                    </select>                        
                    <button type='submit' name='btnVerNotas'>Ver notas</button>
                </p>
            </form>
        <?php
            if (isset($_POST["btnVerNotas"])) {
                echo "<h2>Notas del alumno $nombre_alumno </h2>";
                // Por aquí continuamos
                echo "<table>";
                echo "<tr>";
                echo "<th>Asignatura</th>";
                echo "<th>Nota</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                // select * from asignaturas where cod_asig not in (select asignaturas cod.asig from asignaturas, notas where asignaturas.cod_asig = notas.cod_asig and notas.cod_alu = 2)
                echo "</table>";
            }

        } else {
            echo "<p>En estos momentos no tenemos ningún alumno registrado en la BD</p>";
            mysqli_free_result($resultado);
            mysqli_close($conexion);
        }

    ?>
</body>
</html>