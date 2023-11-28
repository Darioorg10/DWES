<?php

    session_name("CRUD22_23");
    require "src/ctes_y_funciones.php";

    if (isset($_POST["btnBorrarNota"])) {
        try {
            $conexion = mysqli_connect(NOMBRE_HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die(error_page("Examen DWES", "<p>No ha podido realizarse la conexión con la base de datos: ".$e->getMessage()."</p>"));
        }

        // Borramos el alumno
        try {
            $consulta = "delete from notas where cod_asig='".$_POST['btnBorrarNota']."' and cod_alu='".$_POST['alumno']."'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Examen DWES", "<p>No ha podido realizarse la consulta: ".$e->getMessage()."</p>"));
        }

        $_SESSION["mensaje"] = "Nota borrada con éxito";
        $_SESSION["cod_alu"] = $_POST["cod_alu"];
        header("Location:index.php");
        exit;

    }
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
        if (!isset($conexion)) {
            try {
                $conexion = mysqli_connect(NOMBRE_HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                
                die("<p>No ha podido realizarse la conexión con la base de datos: ".$e->getMessage()."</p>"); // NO PONEMOS EL ERROR PAGE PORQUE YA ESTAMOS DENTRO DEL HTML, EL ERROR PAGE ES CUANDO ESTAMOS ARRIBA ANTES DE EMPEZAR
            }
        }        

        // Sacamos los datos de los alumnos
        try {
            $consulta = "select * from  alumnos";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>No ha podido realizarse la consulta: ".$e->getMessage()."</p>");
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
                                if (isset($_POST["alumno"]) && $_POST["alumno"] == $datos_alumno["cod_alu"] || (isset($_SESSION["alumno"]) && $_SESSION["alumno"] == $datos_alumno["cod_alu"])) { // Mantenemos el nombre
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
            if (isset($_POST["btnVerNotas"]) || isset($_SESSION["alumno"])) { // Puedo haber pulsado el botón o venir de haber borrado
                if (condition) {
                    # code...
                }
                $cod_alu = $_POST["alumno"];
                echo "<h2>Notas del alumno $nombre_alumno </h2>";
                // Por aquí continuamos

                try {
                    $consulta = "select asignaturas.cod_asig, asignaturas.denominacion, notas.nota from asignaturas, notas where asignaturas.cod_asig = notas.cod_asig and notas.cod_alu = $cod_alu";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
                }

                // Sacamos la tabla de las asignaturas y las notas
                echo "<table>";
                echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
                while ($tupla = mysqli_fetch_assoc($resultado)) {                    
                    echo "<tr>";
                    echo "<td>".$tupla['denominacion']."</td>";
                    echo "<td>".$tupla['nota']."</td>";
                    echo "<td>
                            <form action='index.php' method='post'>
                                <input type='hidden' value='".$cod_alu."'>
                                <button type='submit' name='btnBorrar' value='".$cod_alu."'>Borrar</button>
                                -
                                <button type='submit' name='btnEditar'>Editar</button>
                            </form>
                            </td>";
                    echo "</tr>";
                }                
                echo "</table>";

                // Sacamos las asignatuas que están sin nota
                try {
                    $consulta = "select * from asignaturas where cod_asig not in (select asignaturas.cod_asig from asignaturas";
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
                }

                if (mysqli_num_rows($resultado) > 0) {
                    ?>
                    <form action="index.php" method="post">
                        <p>
                            <label for="asignatura">Asignaturas que le quedan a <?php echo $nombre_alumno ?> por calificar:</label>
                            <input type="hidden" name="alumno" value="<?php echo $cod_alu;?>">
                            <select name="asignatura" id="asignatura">
                                <?php 
                                    while ($tupla = mysqli_fetch_assoc($resultado)) {
                                        echo "<option value='".$tupla['cod_asig']."'>".$tupla['denominacion']."</option>";
                                    }
                                ?>
                            </select>
                            <button type="submit" name="btnCalificar">Calificar</button>
                        </p>
                    </form>
                    <?php
                } else {
                    echo "<p>A $nombre_alumno no le quedan asignaturas por calificar</p>";
                }

            }

        } else {
            echo "<p>En estos momentos no tenemos ningún alumno registrado en la BD</p>";
            mysqli_free_result($resultado);
            mysqli_close($conexion);
        }

    ?>
</body>
</html>